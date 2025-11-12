<?php

namespace App\Http\Controllers\User;

use App\Models\Logo;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Constants\Status;
use App\Models\LogoImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LogoController extends Controller
{
    public function allLogo(Request $request)
    {
        $pageTitle  = "All Logo";
        $Logos = Logo::with(['user','logo_images'])
            ->searchable(['title'])
            ->latest()->paginate(getPaginate());

        return view('UserTemplate::logo.all_logo', compact('pageTitle', 'Logos'));
    }

    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $logos = Logo::with('user','logo_images')
        ->searchable(['brand_name'])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(getPaginate());
        $pageTitle = ucfirst($status) . ' Logos';
        return view('UserTemplate::logo.index', compact('logos', 'pageTitle'));
    }


    public function create()
    {
        $pageTitle = 'New Logo Create';
        $categories = Category::where('status', Status::CATEGORY_ENABLE)->get();
        $path  = resource_path('views/presets/default/user/font-family/font.json');
        $jsonData = file_get_contents($path);
        $fonts = json_decode($jsonData, true);
        return view('UserTemplate::logo.create', compact('pageTitle', 'categories', 'fonts'));
    }

    public function generate(Request $request)
    {

        $apiKey = gs()->open_ai_key;
        $category = Category::where('id', $request->categoryId)->where('status', Status::CATEGORY_ENABLE)->first();

        if (!$category) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Category is not found.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'brandName'        => 'required|string',
            'colorCode'        => 'required|string',
            'logoCount'        => 'required|numeric|min:1',
            'fontName'         => 'required|string',
            'categoryId'       => 'required|numeric',
            'removeBackground' => 'nullable|in:true,false,1,0',
            'prompt'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = [
            'brandName'        => $request->brandName,
            'logoCount'        => (int) $request->logoCount,
            'fontStyle'        => $request->fontName,
            'categoryName'     => $category->name,
            'colorCode'        => $request->colorCode,
            'removeBackground' => $request->removeBackground ?? false
        ];

        if ((gs()->credit_cost_per_question_prompt * $request->input('logoCount')) > auth()->user()->credit) {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have enough credits.',
                'data' => null
            ]);
        }

        //  Base structured prompt + user prompt 
        $prompt = "Create {$data['logoCount']} modern, professional logo"
            . ($data['logoCount'] > 1 ? 's' : '')
            . " for brand '{$data['brandName']}' "
            . "using color {$data['colorCode']} and font style {$data['fontStyle']}. "
            . "Tagline: '{$data['categoryName']}'.";
        if (!empty($request->prompt)) {
            $prompt .= " Additional details: {$request->prompt}";
        }

        // if background remove 
        if ($request->removeBackground) {
            $prompt .= " Please make the logo with a transparent background.";
        }

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'API key is missing for the selected engine.',
            ]);
        }


        $response = $this->generateLogoFromGemini($apiKey, $prompt);

        if (isset($response['status']) && $response['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => $response['message'],
            ]);
        }

        $basePath = getFilePath('generate_logo');
        
        $images = [];

        foreach ($response['logos'] as $base64) {
            $imageData = base64_decode($base64);
            $filename  = 'image_' . time() . '_' . rand(9999, 100000) . '.png';
            file_put_contents($basePath . $filename, $imageData);
            $images[] = $filename;
        }


        $logo                       = new Logo();
        $logo->user_id              = auth()->id();
        $logo->category_id          = $category->id;
        $logo->brand_name           = $data['brandName'];
        $logo->logo_count           = $data['logoCount'];
        $logo->font_style           = $data['fontStyle'];
        $logo->tagline              = $data['categoryName'];
        $logo->color                = $data['colorCode'];
        $logo->is_remove_background = $data['removeBackground'] == "true" ? 1 : 0;
        $logo->save();

        
        foreach ($images ?? [] as $value) {
            $logo_image = new LogoImage();
            $logo_image->logo_id = $logo->id;
            $logo_image->image = $value;
            $logo_image->save();
        }
        
;
        if ($response['status'] == 'success' && count($images) > 0) {
            $user = auth()->user();
            $user->credit -= (gs()->credit_cost_per_logo * count($images)); // adjust cost per logo if needed
            $user->save();
        }

        return response()->json([
            'status'  => 'success',
            'message' => ['success' => 'Logo generated successfully'],
            'data'    => $images,
            'path'    => asset($basePath)
        ]);
    }

    protected function generateLogoFromGemini($apiKey, $prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-image-preview:generateContent";

        try {
            $client = new Client();
            $result = $client->post(
                $url,
                [
                    'headers' => [
                        'Content-Type'   => 'application/json',
                        'x-goog-api-key' => $apiKey,
                    ],
                    'json' => [
                        "contents" => [
                            [
                                "parts" => [
                                    ["text" => $prompt]
                                ]
                            ]
                        ]
                    ]
                ]
            );

            $result = json_decode($result->getBody());

            if (empty($result->candidates[0]->content->parts)) {
                return [
                    'status' => 'error',
                    'message' => 'Invalid error from API request'
                ];
            }

            $images = collect($result->candidates[0]->content->parts)
                ->filter(fn($p) => isset($p->inlineData->data))
                ->map(fn($p) => $p->inlineData->data)
                ->values()
                ->toArray();

            if (empty($images)) {
                return [
                    'status' => 'error',
                    'message' => 'No images generated'
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Logos generated successfully!',
                'logos' => $images
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Gemini API request failed: ' . $e->getMessage(),
                'logos' => []
            ];
        }
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
