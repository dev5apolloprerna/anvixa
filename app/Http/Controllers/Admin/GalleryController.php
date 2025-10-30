<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Gallery;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
     public function index(Request $request)
    {
        $q = trim($request->get('q',''));
        $categoryId = (int) $request->get('category_id', 0);
        $subcatId   = (int) $request->get('subcategory_id', 0);

        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        $list = Gallery::with(['category','subcategory'])
            ->when($q !== '', fn($x)=>$x->where(function($w) use ($q) {
                $w->where('title','like',"%{$q}%")
                  ->orWhere('slug','like',"%{$q}%");
            }))
            ->when($categoryId>0, fn($x)=>$x->where('category_id',$categoryId))
            ->when($subcatId>0,   fn($x)=>$x->where('subcategory_id',$subcatId))
            ->orderByDesc('gallery_id')
            ->paginate(15);

        return view('admin.gallery.index', compact('list','q','categoryId','subcatId','categories','subcategories'));
    }

    public function show(int $id)
    {
        $row = Gallery::where('gallery_id', $id)->where('isDelete', 0)->firstOrFail();
        $row->image_url = anx_url($row->image);
        return response()->json($row);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'  => ['required', 'string', 'max:200'],
            'slug'   => ['nullable', 'string', 'max:200', Rule::unique('gallery', 'slug')],
            'iStatus'=> ['nullable', 'integer', 'in:0,1'],
            'image'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:51200'],
            'file'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:51200'], // allow either field name
        ]);

        $slug = $data['slug'] ?? Str::slug($data['title']);
        // ensure unique slug
        if (Gallery::where('slug', $slug)->exists()) {
            $slug .= '-' . substr(uniqid(), -5);
        }

        $imageRel = null;
        $uploadFile = $request->file('image') ?: $request->file('file');
        if ($uploadFile) {
            $meta = anx_upload($uploadFile, 'gallery');
            $imageRel = $meta['relative']; // store relative path
        }

        $row = Gallery::create([
            'title'    => $data['title'],
            'slug'     => $slug,
            'image'    => $imageRel,
            'iStatus'  => $data['iStatus'] ?? 1,
            'isDelete' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $row->image_url = anx_url($row->image);

        return redirect()->route('admin.gallery.index')->with('success','Image added to gallery.');
    }

    public function update(Request $request, int $id)
    {
        $row = Gallery::where('gallery_id', $id)->where('isDelete', 0)->firstOrFail();

        $data = $request->validate([
            'title'  => ['sometimes', 'required', 'string', 'max:200'],
            'slug'   => ['nullable', 'string', 'max:200', Rule::unique('gallery', 'slug')->ignore($row->gallery_id, 'gallery_id')],
            'iStatus'=> ['nullable', 'integer', 'in:0,1'],
            'image'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:51200'],
            'file'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:51200'],
        ]);

        if (array_key_exists('title', $data)) $row->title = $data['title'];
        if (array_key_exists('slug', $data))  $row->slug  = $data['slug'] ?: Str::slug($row->title);
        if (array_key_exists('iStatus', $data)) $row->iStatus = (int)$data['iStatus'];

        $uploadFile = $request->file('image') ?: $request->file('file');
        if ($uploadFile) {
            // delete old file if present
            anx_delete($row->image);

            $meta = anx_upload($uploadFile, 'gallery');
            $row->image = $meta['relative'];
        }

        $row->updated_at = now();
        $row->save();

        $row->image_url = anx_url($row->image);

               return redirect()->route('admin.gallery.index')->with('success','Gallery updated.');

    }

    public function destroy(int $id)
    {
        $row = Gallery::where('gallery_id', $id)->where('isDelete', 0)->firstOrFail();
        $row->isDelete = 1;
        $row->updated_at = now();
        $row->save();

        // If you prefer hard delete & physical file removal, uncomment:
        // anx_delete($row->image);
        // $row->delete();

        return back()->with('success','Gallery deleted.');
    }
}
