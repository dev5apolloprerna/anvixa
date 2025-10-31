<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $q          = trim($request->get('q', ''));
        $categoryId = (int) $request->get('category_id', 0);
        $subcatId   = (int) $request->get('subcategory_id', 0);

        $categories = Category::orderBy('strCategoryName')
            ->pluck('strCategoryName', 'iCategoryId');

        // Pass ALL subcategories (like GalleryController)
        $subcategories = SubCategory::orderBy('strSubCategoryName')
            ->pluck('strSubCategoryName', 'iSubCategoryId');

        $list = Video::with(['category', 'subcategory'])
            ->when($q !== '', function ($x) use ($q) {
                $x->where(function ($w) use ($q) {
                    $w->where('video_title', 'like', "%{$q}%")
                      ->orWhere('video_link', 'like', "%{$q}%");
                });
            })
            ->when($categoryId > 0, fn ($x) => $x->where('category_id', $categoryId))
            ->when($subcatId > 0, fn ($x) => $x->where('subcategory_id', $subcatId))
            ->orderByDesc('video_id')
            ->paginate(15);

        return view('admin.video.index', compact(
            'list',
            'q',
            'categoryId',
            'subcatId',
            'categories',
            'subcategories'
        ));
    }

    public function show(int $id)
    {
        $row = Video::where('video_id', $id)->where('isDelete', 0)->firstOrFail();
        // Mirror GalleryController pattern
        $row->image_url = $row->image ? anx_url($row->image) : null; // <-- uses anx_url()
        return response()->json($row);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category', 'iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category', 'iSubCategoryId')],
            'video_title'    => ['required', 'string', 'max:200'],
            'video_link'     => ['required', 'string', 'max:200'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'iStatus'        => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($request->hasFile('image')) {
                $file = $request->file('image');
                // If input name='image[]', take only the first one
                if (is_array($file)) {
                    $file = $file[0];
                }

                // Upload and return path string
                $path = anx_upload($file, 'videos');

                // Make sure it's a string
                if (is_array($path)) {
                    $path = $path['path'] ?? reset($path);
                }

                $data['image'] = (string) $path;
            }


        $data['iStatus']  = (int) ($data['iStatus'] ?? 1);
        $data['isDelete'] = 0;

        Video::create($data);

        return redirect()->route('admin.video.index')->with('success', 'Video added.');
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'category_id'    => ['required', 'integer', Rule::exists('category', 'iCategoryId')],
            'subcategory_id' => ['required', 'integer', Rule::exists('sub_category', 'iSubCategoryId')],
            'video_title'    => ['required', 'string', 'max:200'],
            'video_link'     => ['required', 'string', 'max:200'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'iStatus'        => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($request->hasFile('image')) {
                $file = $request->file('image');
                // If input name='image[]', take only the first one
                if (is_array($file)) {
                    $file = $file[0];
                }

                // Upload and return path string
                $path = anx_upload($file, 'videos');

                // Make sure it's a string
                if (is_array($path)) {
                    $path = $path['path'] ?? reset($path);
                }

                $data['image'] = (string) $path;
            }


        $data['iStatus'] = (int) ($data['iStatus'] ?? $video->iStatus);

        $video->update($data);

        return redirect()->route('admin.video.index')->with('success', 'Video updated.');
    }

    public function toggleStatus(Video $video)
    {
        $video->iStatus = (int) !$video->iStatus;
        $video->save();

        return back()->with('success', 'Status updated.');
    }

   public function destroy(Request $request, $id)
    {
        $video = Video::where('video_id', $id)->firstOrFail();

        // remove physical image if present
        if (!empty($video->image)) {
            anx_delete($video->image); // same helper as Gallery
        }

        $video->update([
            'isDelete'   => 1,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Video deleted.');
    }


    public function bulkDelete(Request $request)
    {
        // Accept ids from form-data OR JSON
        $ids = $request->input('ids', $request->json('ids', []));
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['status' => 'error', 'message' => 'No items selected'], 422);
        }

        // Delete images
        $rows = Video::whereIn('video_id', $ids)->get(['video_id','image']);
        foreach ($rows as $row) {
            if (!empty($row->image) && function_exists('anx_delete')) {
                try { anx_delete($row->image); } catch (\Throwable $e) {}
            }
        }

        // Soft delete rows
        Video::whereIn('video_id', $ids)->update([
            'isDelete'   => 1,
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'ok', 'deleted_ids' => $ids]);
    }

}
