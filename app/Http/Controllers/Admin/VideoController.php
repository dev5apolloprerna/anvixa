<?php
// app/Http/Controllers/Admin/VideoController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VideoController extends Controller
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

        $list = Video::with(['category', 'subcategory'])
            ->when($q !== '', function ($x) use ($q) {
                $x->where(function ($w) use ($q) {
                    $w->where('video_title', 'like', "%{$q}%")
                      ->orWhere('video_link', 'like', "%{$q}%");
                });
            })
            ->when($categoryId > 0, fn($x) => $x->where('category_id', $categoryId))
            ->when($subcatId > 0, fn($x) => $x->where('subcategory_id', $subcatId))
            ->orderByDesc('video_id')
            ->paginate(15);

        return view('admin.video.index', compact('list', 'q', 'categoryId', 'subcatId', 'categories', 'subcategories'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category','iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category','iSubCategoryId')],
            'video_title'    => ['required', 'string', 'max:200'],
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

        Video::create($data);

        return redirect()->route('admin.video.index')->with('success', 'Video added.');
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category','iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category','iSubCategoryId')],
            'video_title'    => ['required', 'string', 'max:200'],
            'video_link'     => ['required', 'string', 'max:200'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'iStatus'        => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($request->hasFile('image')) {
            // delete old image if present
            if ($video->image && Storage::disk('public')->exists($video->image)) {
                Storage::disk('public')->delete($video->image);
            }
            $data['image'] = $request->file('image')->store('videos', 'public');
        }

        $data['iStatus'] = (int)($data['iStatus'] ?? $video->iStatus);

        $video->update($data);

        return redirect()->route('admin.video.index')->with('success', 'Video updated.');
    }

    public function toggleStatus(Video $video)
    {
        $video->iStatus = (int)!$video->iStatus;
        $video->save();

        return back()->with('success', 'Status updated.');
    }

    public function destroy(Video $video)
    {
        // soft delete flag
        $video->isDelete = 1;
        $video->save();

        return back()->with('success', 'Video deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Select at least one row.');
        }

        Video::withoutGlobalScope('notDeleted')
            ->whereIn('video_id', $ids)
            ->update(['isDelete' => 1]);

        return back()->with('success', 'Selected videos deleted.');
    }
}
