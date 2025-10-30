<?php
// app/Http/Controllers/Admin/VideoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PodcastEpisode;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PodcastController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $categoryId = (int)$request->get('category_id', 0);
        $subcatId   = (int)$request->get('subcategory_id', 0);

        $categories = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');

        // Always pass all subcategories (not just filtered ones)
        $subcategories = SubCategory::orderBy('strSubCategoryName')
            ->pluck('strSubCategoryName', 'iSubCategoryId');

        $list = PodcastEpisode::with(['category', 'subcategory'])
            ->when($q !== '', function ($x) use ($q) {
                $x->where(function ($w) use ($q) {
                    $w->where('podcast_title', 'like', "%{$q}%")
                      ->orWhere('video_link', 'like', "%{$q}%");
                });
            })
            ->when($categoryId > 0, fn($x) => $x->where('category_id', $categoryId))
            ->when($subcatId > 0, fn($x) => $x->where('subcategory_id', $subcatId))
            ->orderByDesc('podcast_id')
            ->paginate(15);

        return view('admin.podcast.index', compact('list', 'q', 'categoryId', 'subcatId', 'categories', 'subcategories'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category','iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category','iSubCategoryId')],
            'podcast_title'    => ['required', 'string', 'max:200'],
            'video_link'     => ['required', 'string', 'max:200'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'iStatus'        => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($request->hasFile('image')) {
            // store under public/videos; requires `php artisan storage:link`
            $data['image'] = $request->file('image')->store('videos', 'public');
        }

        $data['iStatus']  = (int)($data['iStatus'] ?? 1);
        $data['isDelete'] = 0;

        PodcastEpisode::create($data);

        return redirect()->route('admin.podcast.index')->with('success', 'Podcast Episode added.');
    }

    public function update(Request $request, PodcastEpisode $podcast)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category','iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category','iSubCategoryId')],
            'podcast_title'    => ['required', 'string', 'max:200'],
            'video_link'     => ['required', 'string', 'max:200'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'iStatus'        => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($request->hasFile('image')) {
            // delete old image if present
            if ($podcast->image && Storage::disk('public')->exists($podcast->image)) {
                Storage::disk('public')->delete($podcast->image);
            }
            $data['image'] = $request->file('image')->store('videos', 'public');
        }

        $data['iStatus'] = (int)($data['iStatus'] ?? $podcast->iStatus);

        $podcast->update($data);

        return redirect()->route('admin.podcast.index')->with('success', 'Podcast Episode updated.');
    }

    public function toggleStatus(PodcastEpisode $podcast)
    {
        $podcast->iStatus = (int)!$podcast->iStatus;
        $podcast->save();

        return back()->with('success', 'Status updated.');
    }

    public function destroy(PodcastEpisode $podcast)
    {
        // soft delete flag
        $podcast->isDelete = 1;
        $podcast->save();

        return back()->with('success', 'Podcast Episode deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Select at least one row.');
        }

        PodcastEpisode::withoutGlobalScope('notDeleted')
            ->whereIn('podcast_id', $ids)
            ->update(['isDelete' => 1]);

        return back()->with('success', 'Selected Podcast Episode deleted.');
    }
}
