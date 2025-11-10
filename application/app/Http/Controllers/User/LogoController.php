<?php

namespace App\Http\Controllers\User;

use App\Models\Logo;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    public function allLogo(Request $request)
    {
        $pageTitle  = "All Logo";
        $Logos = Logo::with(['user'])
            ->searchable(['title'])
            ->latest()->paginate(getPaginate());

        return view('UserTemplate::logo.all_logo', compact('pageTitle', 'Logos'));
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $logos = Logo::with('user')->searchable(['brand_name'])->where('user_id', auth()->id())->latest()->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Logos';
        return view('UserTemplate::logo.index', compact('logos', 'pageTitle'));
    }


    public function create()
    {
        $pageTitle = 'New Logo Create';
        $categories = Category::where('status', Status::CATEGORY_ENABLE)->get();
        return view('UserTemplate::logo.create', compact('pageTitle', 'categories'));
    }

    public function generate(Request $request)
    {
        $prompt = $request->input('prompt');
        $apiKey = gs()->open_ai_key;
        $elementCount = $request->input('element_count', 2);

        if ((gs()->credit_cost_per_question_prompt * $elementCount) > auth()->user()->credit) {

            return response()->json([
                'status' => 'error',
                'message' => 'You do not have enough credits.',
                'data' => null
            ]);
        }

        $response = $this->generateFormBuilderJson($apiKey, $elementCount, $prompt);

        if ($response['status'] == 'success' && count($response['data']['form']) > 0) {

            $user = auth()->user();
            $user->credit -= (gs()->credit_cost_per_question_prompt * count($response['data']['form']));
            $user->save();
        }

        return response()->json($response);
    }


    protected function generateFormBuilderJson($apiKey, $data, $prompt, $model = 'gpt-4o-mini', $temperature = 0.4)
    {
        $client = new Client();


        $messages = [
            [
                "role" => "system",
                "content" => "
                    Create {$data['logoCount']} unique logos for the brand '{$data['brandName']}' 
                    with {$data['color']} color, background removal: {$data['removeBackground']}, 
                    and font style: {$data['fontStyle']}. Provide only JSON in the required schema.
                    Generate logo with JSON data based on the user prompt. 
                    Always respond with **valid JSON only**, following exactly this schema — no markdown, no explanations.
                    Schema:
                    {
                    \"type\": \"object\",
                    \"properties\": {
                    \"title\": { \"type\": \"string\" },
                    \"logo\": {
                        \"type\": \"array\",
                        \"items\": {
                        \"type\": \"object\",
                        \"properties\": {
                            \"id\": { \"type\": \"string\", \"pattern\": \"^el_[a-z0-9]{7}$\" },
                            \"tagline\": { \"type\": \"string\" },
                            \"brand_name\": { \"type\": \"string\" },
                            \"color\": { \"type\": \"string\" },
                            \"is_remove_background\": { \"type\": \"boolean\", \"description\": \"True if user wants background removed, otherwise false. Optional.\" },
                            \"font_style\": { \"type\": \"string\", \"description\": \"Font style requested by the user. This field is required.\" }
                        },
                        \"required\": [\"id\", \"tagline\", \"brand_name\", \"color\", \"font_style\"]
                        },
                        \"uniqueItems\": true
                    }
                    },
                    \"required\": [\"title\", \"logo\"]
                }

                Rules:
                - If the user mentions removing background, set \"is_remove_background\": true; otherwise false.
                - Always include a \"font_style\" field (e.g., 'modern', 'serif', 'bold', etc.).
                - Return only pure JSON without any code fences or explanations.
                "
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

            $content = trim($result['choices'][0]['message']['content']);
            $content = preg_replace('/^```json|```$/m', '', $content);
            $json = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid JSON format received.',
                    'data' => $content
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Logo generated successfully.',
                'data' => $json
            ];
        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'An error occurred while generating the logo.',
                'data' => null
            ];
        }
    }


    public function store(Request $request)
    {
        $data      = $request->except('_token');
        $validator = Validator::make($data, [
            'image'      => ['required', 'image', new FileTypeValidate(['jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'])],
            'logo_count' => 'required|numeric|min:1',
            'title'      => 'required|string|max:255',
            'form_json'  => [
                'required',
                'json',
                function ($attribute, $value, $fail) {
                    $data = json_decode($value, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        return $fail('Invalid JSON format in form_json.');
                    }

                    if (empty($data['template'])) {
                        return $fail('The form_json.template field is required.');
                    }

                    if (empty($data['form']) || !is_array($data['form'])) {
                        return $fail('The form_json.form must be a non-empty array.');
                    }

                    foreach ($data['form'] as $index => $item) {
                        if (empty($item['id']) || empty($item['label']) || empty($item['tag'])) {
                            return $fail("Each form element must have id, label, and tag (error at index {$index}).");
                        }
                        if (in_array($item['tag'], ['select', 'radio', 'checkbox']) && empty($item['options'])) {
                            return $fail("The form element '{$item['label']}' must include options.");
                        }
                    }
                },
            ],
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        $formData = json_decode($request->form_json, true);
        $elementsCount = count($formData['form'] ?? []);

        if ($planSubscription->plan->input_limit < $elementsCount) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have exceeded your form builder limit for your current plan.',
            ], 403);
        }

        $formBuilder                   = new FormBuilder();
        $formBuilder->title            = $request->title;
        $formBuilder->user_id          = auth()->id();
        $formBuilder->submission_limit = $request->submission_limit;
        $formBuilder->question_limit   = $elementsCount;
        $formBuilder->form_data        = json_decode($request->form_json);
        $formBuilder->status           = Status::FORM_BUILDER_ENABLE;
        if ($request->hasFile('image')) {
            try {
                $formBuilder->image = fileUploader($request->image, getFilePath('form'), getFileSize('form'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $formBuilder->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Form data saved successfully.'
        ]);
    }

    public function view($id)
    {
        $logo = Logo::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$logo) {
            $notify[] = ['error', 'Logo Not Found'];
            return back()->withNotify($notify);
        }
        $pageTitle = 'logo Details';
        return view('UserTemplate::logo.details', compact('pageTitle', 'logo'));
    }
}
