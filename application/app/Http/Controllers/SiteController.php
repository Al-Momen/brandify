<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Logo;
use App\Models\Page;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Constants\Status;
use App\Models\LogoImage;
use App\Models\Subscriber;
use App\Models\FormBuilder;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index()
    {
        if (isset($_GET['reference'])) {
            session()->put('reference', $_GET['reference']);
        }
        $pageTitle = 'Home';
        $sections = Page::where('slug', '/')->first();
        return view('Template::home', compact('pageTitle', 'sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view('Template::pages', compact('pageTitle', 'sections'));
    }


    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug, $id)
    {
        $policy = Frontend::where('id', $id)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view('Template::policy', compact('policy', 'pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blog(Request $request)
    {
        $pageTitle = 'Our Blog Posts';
        $blogs = Frontend::where('data_keys', 'blog.element')
            ->when($request->search, function ($query) use ($request) {
                $search = strtolower($request->search);
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(data_values, '$.title'))) LIKE ?", ["%$search%"]);
            })
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(9));
        $sections = Page::where('slug', 'blog')->first();
        return view('Template::blog', compact('pageTitle', 'blogs', 'sections'));
    }


    public function blogDetails($slug, $id)
    {
        $latests   = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->limit(6)->get();
        $blog      = Frontend::where('id', $id)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle = 'Blog Details';
        return view('Template::blog_details', compact('blog', 'pageTitle', 'latests'));
    }

    public function about()
    {
        $pageTitle = "About Us";
        $sections  = Page::where('slug', 'about')->first();
        return view('Template::about', compact('pageTitle', 'sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $sections  = Page::where('slug', 'contact')->first();
        return view('Template::contact', compact('pageTitle', 'sections'));
    }



    public function cookieAccept()
    {
        $general = gs();
        Cookie::queue('gdpr_cookie', $general->site_name, 43200);
        return back();
    }

    public function cookiePolicy()
    {
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        $general = gs();
        if ($general->maintenance_mode) {
            $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
            return view('Template::maintenance', compact('pageTitle', 'maintenance'));
        }
        return to_route('home');
    }

    public function placeholderImage($size = null)
    {
        $imgWidth = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:subscribers',
        ]);
        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();
        $notify[] = ['success', 'You have successfully subscribed to the Newsletter'];
        return back()->withNotify($notify);
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
}
