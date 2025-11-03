<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Inquiry;
use App\Models\PodcastEpisode;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        try {
            $Video = Video::orderBy('video_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->get();

            return view('frontview.index', compact('Video'));
        } catch (\Throwable $th) {
            Log::error('Home Page Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to load homepage. Please try again.');
        }
    }

    public function about(Request $request)
    {
        try {
            return view('frontview.about');
        } catch (\Throwable $th) {
            Log::error('About Page Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to load about page.');
        }
    }

    public function contactus(Request $request)
    {
        try {
            return view('frontview.contact');
        } catch (\Throwable $th) {
            Log::error('Contact Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load contact page. Please try again.');
        }
    }

    public function contact_us_store(Request $request)
    {
        // try {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
                'captcha' => 'required|captcha'
            ],
            [
                'captcha.captcha' => 'Invalid captcha code.'
            ]
        );

        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            "strIp" => $request->ip(),
            "created_at" => now()
        );
        Inquiry::create($data);

        $SendEmailDetails = DB::table('sendemaildetails')->where(['id' => 4])->first();

        if ($SendEmailDetails) {
            $msg = [
                'FromMail' => $SendEmailDetails->strFromMail,
                'Title' => $SendEmailDetails->strTitle,
                'ToEmail' => $SendEmailDetails->ToMail,
                'Subject' => $SendEmailDetails->strSubject
            ];

            // ✅ Send email
            Mail::send('emails.contactemail', ['data' => $data], function ($message) use ($msg) {
                $message->from($msg['FromMail'], $msg['Title']);
                $message->to($msg['ToEmail'])->subject($msg['Subject']);
            });
        }

        return redirect()->route('contactthankyou');
        // } catch (\Throwable $th) {
        //     Log::error('Contact Form Submission Error: ' . $th->getMessage(), [
        //         'request_data' => $request->all(),
        //         'exception' => $th
        //     ]);

        //     return redirect()->back()
        //         ->withInput()
        //         ->with('error', 'Something went wrong while submitting the form. Please try again later.');
        // }
    }

    public function contactthankyou()
    {
        try {
            return view('frontview.contactthankyou');
        } catch (\Throwable $th) {
            Log::error('Contact Thank You Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Unable to load the thank you page. Please try again.');
        }
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function services(Request $request)
    {
        try {
            return view('frontview.services');
        } catch (\Throwable $th) {
            Log::error('Contact Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load contact page. Please try again.');
        }
    }

    public function gallery(Request $request)
    {
        try {
            $sub_categories = SubCategory::where(['iStatus' => 1, 'isDelete' => 0])->get();

            $galleries =  Gallery::orderBy('gallery_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->take(9)
                ->get();

            $totalGallery = Gallery::where(['iStatus' => 1, 'isDelete' => 0])->count();

            return view('frontview.gallery', compact('sub_categories', 'galleries', 'totalGallery'));
        } catch (\Throwable $th) {
            Log::error('Gallery Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load gallery page. Please try again.');
        }
    }

    public function loadMoreGallery(Request $request)
    {
        $skip = $request->get('skip', 0);
        $limit = $request->get('limit', 6);
        $subcategoryId = $request->get('subcategory_id');

        $query = Gallery::orderBy('gallery_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0]);

        if ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }

        $galleries = $query->skip($skip)->take($limit)->get();

        return response()->json(['galleries' => $galleries]);
    }

    public function filterGallery(Request $request)
    {
        try {
            $subcategoryId = $request->get('subcategory_id');
            $skip = $request->get('skip', 0);
            $limit = $request->get('limit', 6);

            $query = Gallery::orderBy('gallery_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0]);

            if ($subcategoryId) {
                $query->where('subcategory_id', $subcategoryId);
            }

            $galleries = $query->skip($skip)->take($limit)->get();

            return response()->json(['galleries' => $galleries]);
        } catch (\Throwable $th) {
            Log::error('Gallery Filter Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);
            return response()->json(['error' => 'Failed to filter galleries.'], 500);
        }
    }

    public function video(Request $request)
    {
        try {
            $videos = Video::orderBy('video_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->take(9)
                ->get();

            $totalVideos = Video::where(['iStatus' => 1, 'isDelete' => 0])->count();

            return view('frontview.video', compact('videos', 'totalVideos'));
        } catch (\Throwable $th) {
            Log::error('Video Page Load Error: ' . $th->getMessage(), ['exception' => $th]);

            return redirect()->back()
                ->with('error', 'Failed to load video page. Please try again.');
        }
    }

    public function loadMoreVideos(Request $request)
    {
        try {
            // Fetch videos based on the offset (pagination)
            $skip = $request->input('skip', 0);
            $limit = 6; // Number of videos to load per request

            // Fetch videos
            $videos = Video::orderBy('video_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->skip($skip)
                ->take($limit)
                ->get();

            return response()->json(['videos' => $videos]);
        } catch (\Throwable $th) {
            Log::error('Load More Videos Error: ' . $th->getMessage(), ['exception' => $th]);
            return response()->json(['error' => 'Failed to load more videos. Please try again.'], 500);
        }
    }

    public function document(Request $request)
    {
        try {
            $sub_categories = SubCategory::where(['iStatus' => 1, 'isDelete' => 0])->get();

            $documents = Document::orderBy('document_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->take(9)
                ->get();

            $total_documents = Document::where(['iStatus' => 1, 'isDelete' => 0])->count();

            return view('frontview.documents', compact('documents', 'total_documents', 'sub_categories'));
        } catch (\Throwable $th) {
            Log::error('Contact Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load contact page. Please try again.');
        }
    }

    public function loadMoreDocuments(Request $request)
    {
        try {
            $skip = $request->get('skip', 0);
            $limit = $request->get('limit', 6);
            $subcategoryId = $request->get('subcategory_id');

            $query = Document::orderBy('document_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0]);

            if (!empty($subcategoryId)) {
                $query->where('subcategory_id', $subcategoryId);
            }

            $documents = $query->skip($skip)->take($limit)->get();

            return response()->json(['documents' => $documents]);
        } catch (\Throwable $th) {
            Log::error('Load More Documents Error: ' . $th->getMessage(), ['exception' => $th]);
            return response()->json(['error' => 'Failed to load more documents.'], 500);
        }
    }

    public function filterDocuments(Request $request)
    {
        try {
            $subcategoryId = $request->get('subcategory_id');
            $skip = $request->get('skip', 0);
            $limit = $request->get('limit', 6);

            $query = Document::orderBy('document_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0]);

            if (!empty($subcategoryId)) {
                $query->where('subcategory_id', $subcategoryId);
            }

            $documents = $query->skip($skip)->take($limit)->get();

            return response()->json(['documents' => $documents]);
        } catch (\Throwable $th) {
            Log::error('Filter Documents Error: ' . $th->getMessage(), ['exception' => $th]);
            return response()->json(['error' => 'Failed to filter documents.'], 500);
        }
    }

    public function podcast(Request $request)
    {
        try {
            $podcast_episodes = PodcastEpisode::orderBy('podcast_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->take(9)
                ->get();

            $totalPodcast_episode = PodcastEpisode::where(['iStatus' => 1, 'isDelete' => 0])->count();

            return view('frontview.podcast', compact('podcast_episodes', 'totalPodcast_episode'));
        } catch (\Throwable $th) {
            Log::error('Podcast Page Load Error: ' . $th->getMessage(), [
                'exception' => $th
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to load podcast page. Please try again.');
        }
    }

    /** AJAX Loader for "Listen More Episodes" */
    public function loadMorePodcasts(Request $request)
    {
        $skip = $request->get('skip', 0);
        $limit = $request->get('limit', 6);

        $podcasts = PodcastEpisode::orderBy('podcast_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0])
            ->skip($skip)
            ->take($limit)
            ->get(); // include these fields as needed

        return response()->json(['podcasts' => $podcasts]);
    }
}
