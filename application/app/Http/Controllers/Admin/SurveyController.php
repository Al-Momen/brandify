<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Survey;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Constants\Status;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
   
        $status = $request->get('status', 'all');
        $query = Survey::searchable(['title'])->latest();
        switch ($status) {
            case 'disable':
                $query->where('status', Status::SURVEY_DISABLE);
                break;
            case 'enable':
                $query->where('status', Status::SURVEY_ENABLE);
                break;
            case 'all':
                $query->whereIn('status', [Status::SURVEY_ENABLE, Status::SURVEY_DISABLE, Status::SURVEY_INITIAL, Status::SURVEY_REJECTED]);
                break;
            default:
                break;
        }
 
        $surveys = $query->with('author')->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Surveys';

        return view('Admin::survey.index', compact('surveys', 'pageTitle'));
    }


    public function create()
    {
        $pageTitle = 'Create New Survey';
        $categories = Category::where('status', Status::CATEGORY_ENABLE)->get();
        return view('Admin::survey.create', compact('pageTitle', 'categories'));
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = gs()->open_ai_key;

        $response = $this->generateSurveyJson($apiKey, $prompt);

        return response()->json($response);
    }

    protected function generateSurveyJson($apiKey, $prompt, $model = 'gpt-4o-mini', $temperature = 0.4)
    {
        $client = new Client();
        $messages = [
            [
                "role" => "system",
                "content" => "You are a professional survey generator. Use question types: mcq_single, mcq_multiple, both multiple-choice (single/multiple) and written written_textarea, written_input. Always respond with valid JSON only with valid JSON in the following exact schema. Do NOT change key names or structure. 
                The schema is:
                {
                    \"type\": \"object\",
                    \"properties\": {
                        \"title\": { \"type\": \"string\" },
                        \"questions\": {
                        \"type\": \"array\",
                        \"items\": {
                            \"type\": \"object\",
                            \"properties\": {
                            \"id\": { \"type\": \"integer\" },
                            \"type\": { \"enum\": [\"mcq_single\", \"mcq_multiple\", \"written_input\",\"written_textarea\"] },
                            \"question\": { \"type\": \"string\" },
                            \"options\": {
                                \"type\": \"array\",
                                \"items\": { \"type\": \"string\" },
                                \"minItems\": 2
                            },
                            \"placeholder\": { \"type\": \"string\" }
                            },
                            \"required\": [\"id\", \"type\", \"question\"],
                            \"allOf\": [
                            {
                                \"if\": {
                                \"properties\": {
                                    \"type\": { \"enum\": [\"mcq_single\", \"mcq_multiple\"] }
                                }
                                },
                                \"then\": {
                                \"required\": [\"options\"]
                                }
                            }
                            ]
                        },
                        \"uniqueItems\": true
                        }
                    },
                    \"required\": [\"title\", \"questions\"]
                }"
            ],
            ["role" => "user", "content" => $prompt]
        ];

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => $temperature,
                    'max_tokens' => 1200,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (!isset($result['choices'][0]['message']['content'])) {
                return [
                    'status' => 'error',
                    'message' => 'Empty response from OpenAI.',
                    'data' => null
                ];
            }

            // Remove ```json ``` fencing if present
            $content = trim($result['choices'][0]['message']['content']);
            $content = preg_replace('/^```json|```$/m', '', $content);
            $json = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid JSON format received.',
                    'data' => $content // raw text for debugging
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Survey generated successfully.',
                'data' => $json
            ];
        } catch (\Exception $e) {
            Log::error("OpenAI API Error: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'An error occurred while generating the survey.',
                'data' => null
            ];
        }
    }

    public function store(Request $request)
    {
        $data      = $request->except('_token');
        $data['survey'] = json_decode($request->survey, true);
        $validator = Validator::make($data, [
            'image'                        => ['required', 'image', new FileTypeValidate(['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])],
            'category_id'                  => 'required|integer|exists:categories,id',
            'survey_people'                => 'required|numeric|min:1',
            'survey_money'                 => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
            'survey.title'                 => 'required|string|max:255',
            'survey.questions'             => 'required|array|min:1',
            'survey.questions.*.id'        => 'required|integer|distinct',
            'survey.questions.*.type'      => 'required|in:mcq_single,mcq_multiple,written_input,written_textarea',
            'survey.questions.*.question'  => 'required|string',
            'survey.questions.*.options'   => 'sometimes|array|min:2',
            'survey.questions.*.options.*' => 'string'
        ]);

        // MCQ questions must have options
        foreach ($data['questions'] ?? [] as $q) {
            if (in_array($q['type'], ['mcq_single', 'mcq_multiple']) && empty($q['options'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Question ID {$q['id']} must have at least 2 options."
                ], 422);
            }
        }

        if (count($data["survey"]['questions']) < 0) {
            return response()->json([
                'status' => 'error',
                'message' => "Question must have at least 1."
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $survey                 = new Survey();
        $survey->category_id    = $request->category_id;
        $survey->author_id      = auth('admin')->id();
        $survey->author_type    = Admin::class;
        $survey->title          = $data['survey']['title'];
        $survey->form_data      = $data['survey'];
        $survey->survey_people  = $request->survey_people;
        $survey->survey_money   = $request->survey_money;
        $survey->total_question = count($data["survey"]['questions']);
        $survey->total_amount   = $request->survey_people * $request->survey_money * count($data["survey"]['questions']);
        $survey->status         = Status::SURVEY_ENABLE;
        if ($request->hasFile('image')) {
            try {
                $survey->image = fileUploader($request->image, getFilePath('survey'), getFileSize('survey'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $survey->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Survey form data saved successfully.'
        ]);
    }

    public function details($id)
    {
      
        $survey = Survey::where('id', $id)->first();
        if (!$survey) {
            $notify[] = ['error', 'Survey Not Found'];
            return back()->withNotify($notify);
        }
        $pageTitle = 'Survey Details';
        return view('Admin::survey.details', compact('pageTitle', 'survey'));
    }

    public function status($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->status = $survey->status == 1 ? 0 : 1;
        $survey->save();
        $notify[] = ['success', 'Survey Status has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function answerList(Request $request, $id)
    {
        $pageTitle = 'Survey Answer List';
        $status = $request->get('status', 'all');
        $query = SurveyAnswer::with('survey', 'user')->where('survey_id', $id)->latest();

        switch ($status) {
            case 'pending':
                $query->where('status', Status::SURVEY_ANSWER_PENDING);
                break;
            case 'approved':
                $query->where('status', Status::SURVEY_ANSWER_APPROVED);
                break;
            case 'reject':
                $query->where('status', Status::SURVEY_ANSWER_REJECTED);
                break;
            case 'all':
                $query->whereIn('status', [Status::SURVEY_ANSWER_PENDING, Status::SURVEY_ANSWER_APPROVED, Status::SURVEY_ANSWER_REJECTED]);
                break;
            default:
                break;
        }

        $surveyAnswers = $query->paginate(getPaginate());
        return view('Admin::survey.answer_user_list', compact('pageTitle', 'surveyAnswers'));
    }

    public function answerDetails($id)
    {

        $pageTitle = 'Survey Answer List';
        $surveyAnswerDetail = SurveyAnswer::with('survey', 'user')->where('id', $id)->first();
        return view('Admin::survey.answer_detail', compact('pageTitle', 'surveyAnswerDetail'));
    }


    public function answerStatus($status, $id)
    {
        $surveyAnswer = SurveyAnswer::with('survey', 'user')->whereHas('survey', function ($q) {
            $q->where('author_id', auth('admin')->id())
                ->where('author_type', Admin::class);
        })->where('id', $id)->first();

        if (!$surveyAnswer) {
            $notify[] = ['error', 'Survey answer is not valid'];
            return back()->withNotify($notify);
        }

        if ($status == Status::SURVEY_ANSWER_APPROVED) {
            $surveyAnswer->status = Status::SURVEY_ANSWER_APPROVED;
            $surveyAnswer->save();

            $surveyAnswer->user->balance +=  $surveyAnswer->survey->survey_money * $surveyAnswer->total_answer;
            $surveyAnswer->user->save();

            $surveyAnswer->survey->survey_people_answer +=  1;
            $surveyAnswer->survey->save();
            $notify[] = ['success', 'Survey answer has been approved.'];
        } else {
            $surveyAnswer->status = Status::SURVEY_ANSWER_REJECTED;
            $surveyAnswer->save();
            $notify[] = ['success', 'Survey answer has been rejected.'];
        }

        return back()->withNotify($notify);
    }
}
