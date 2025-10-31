<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// import the global functions so we can call without backslash
use function anx_upload;
use function anx_delete;
use function anx_url;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $q          = trim($request->get('q', ''));
        $categoryId = (int) $request->get('category_id', 0);
        $subcatId   = (int) $request->get('subcategory_id', 0);

        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        $list = Document::with(['category', 'subcategory'])
            ->where('isDelete', 0)
            ->when($q !== '', fn($x) => $x->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                    ->orWhere('slug',  'like', "%{$q}%");
            }))
            ->when($categoryId > 0, fn($x) => $x->where('category_id', $categoryId))
            ->when($subcatId   > 0, fn($x) => $x->where('subcategory_id', $subcatId))
            ->orderByDesc('document_id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.document.index', compact(
            'list',
            'q',
            'categoryId',
            'subcatId',
            'categories',
            'subcategories'
        ));
    }

    public function create()
    {
        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');

        return view('admin.document.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'slug'           => ['nullable', 'string', 'max:200', 'unique:document,slug'],
            'category_id'    => ['required', Rule::exists('category', 'iCategoryId')],
            'subcategory_id' => ['required', Rule::exists('sub_category', 'iSubCategoryId')],
            'file'           => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,jpg,jpeg,png,webp,gif', 'max:102400'], // 100MB
            'iStatus'        => ['nullable', 'in:0,1'],
        ]);

        // upload via helper -> store relative path into `document`
        $meta = anx_upload($request->file('file'), 'documents');
        $data['document'] = $meta['relative'];

        // optional: auto-slug when not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
            if (Document::where('slug', $data['slug'])->exists()) {
                $data['slug'] .= '-' . substr(uniqid(), -5);
            }
        }

        $data['iStatus']  = (int) ($data['iStatus'] ?? 1);
        $data['isDelete'] = 0;

        Document::create($data);

        return redirect()
            ->route('admin.document.index')
            ->with('success', 'Document added.');
    }

    public function show(Document $document)
    {
        // For view convenience; you can also call anx_url() directly in Blade
        $fileUrl = anx_url($document->document);

        return view('admin.document.show', compact('document', 'fileUrl'));
    }

    public function edit(Document $document)
    {
        $categories    = Category::orderBy('strCategoryName')->pluck('strCategoryName', 'iCategoryId');
        $subcategories = SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName', 'iSubCategoryId');
        $fileUrl       = anx_url($document->document);

        return view('admin.document.edit', compact('document', 'categories', 'subcategories', 'fileUrl'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'title'          => ['required', 'string', 'max:200'],
            'slug'           => ['nullable', 'string', 'max:200', Rule::unique('document', 'slug')->ignore($document->document_id, 'document_id')],
            'category_id'    => ['required', Rule::exists('category', 'iCategoryId')],
            'subcategory_id' => ['required', Rule::exists('sub_category', 'iSubCategoryId')],
            'file'           => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,jpg,jpeg,png,webp,gif', 'max:102400'],
            'iStatus'        => ['nullable', 'in:0,1'],
        ]);

        if ($request->hasFile('file')) {
            // remove old file (if any), then upload new
            anx_delete($document->document);
            $meta = anx_upload($request->file('file'), 'documents');
            $data['document'] = $meta['relative'];
        }

        if (array_key_exists('iStatus', $data)) {
            $data['iStatus'] = (int) $data['iStatus'];
        }

        // slug: if set to empty string, regenerate from title
        if (array_key_exists('slug', $data) && $data['slug'] === '') {
            $data['slug'] = \Str::slug($data['title']);
            if (Document::where('slug', $data['slug'])->where('document_id', '!=', $document->document_id)->exists()) {
                $data['slug'] .= '-' . substr(uniqid(), -5);
            }
        }

        $document->update($data);

        return redirect()
            ->route('admin.document.index')
            ->with('success', 'Document updated.');
    }

    public function toggleStatus(Document $document)
    {
        $document->iStatus = (int)!$document->iStatus;
        $document->save();

        return back()->with('success', 'Status updated.');
    }

    public function destroy(Document $document)
    {
        // 1) delete file first (if any)
        if (!empty($document->document)) {
            try {
                anx_delete($document->document);
            } catch (\Throwable $e) {
            }
        }

        // 2) set soft-delete flag WITHOUT triggering updating hooks
        // Option A (Laravel 9+): saveQuietly
        $document->forceFill(['isDelete' => 1])->saveQuietly();

        // Option B: temporarily disable model events (any Laravel)
        // \Illuminate\Database\Eloquent\Model::withoutEvents(function () use ($document) {
        //     $document->update(['isDelete' => 1]);
        // });

        return back()->with('success', 'Document deleted.');
    }

    public function bulkDelete(Request $request)
    {
        // Accept ids from form-data OR JSON
        $ids = $request->input('ids', $request->json('ids', []));
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['status' => 'error', 'message' => 'No items selected'], 422);
        }

        // Delete images
        $rows = Document::whereIn('document_id', $ids)->get(['document_id', 'document']);
        foreach ($rows as $row) {
            if (!empty($row->document) && function_exists('anx_delete')) {
                try {
                    anx_delete($row->document);
                } catch (\Throwable $e) {
                }
            }
        }

        // Soft delete rows
        Document::whereIn('document_id', $ids)->update([
            'isDelete'   => 1,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Selected Document deleted.');

        return response()->json(['status' => 'ok', 'deleted_ids' => $ids]);
    }
}
