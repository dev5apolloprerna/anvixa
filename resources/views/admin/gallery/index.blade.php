@extends('layouts.app')
@section('title','Gallery')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      @include('common.alert')

      <div class="row">
        {{-- LEFT: ADD FORM --}}
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header"><h4 class="mb-0">Add Gallery Image</h4></div>
            <div class="card-body">
              <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" id="galleryForm">
                @csrf

                <div class="mb-3">
                  <label class="form-label">Category <span class="text-danger">*</span></label>
                  <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $id => $name)
                      <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                  <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                    <option value="">Select Sub Category</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" id="title" class="form-control" maxlength="200" required>
                  <small class="text-muted">Slug: <span id="slugPreview"></span></small>
                </div>

                <div class="mb-3">
                  <label class="form-label">Image <span class="text-danger">*</span></label>
                  <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                  <small class="text-muted">Recommended: 1200×800 (or similar aspect ratio)</small>
                </div>

                <div class="d-flex gap-2">
                  <button class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-light">Clear</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- RIGHT: LIST --}}
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <form method="GET" class="row g-2 align-items-center" action="{{ route('admin.gallery.index') }}">
                <div class="col-md-3">
                  <select class="form-control" name="category_id" id="filter_category">
                    <option value="">All Categories</option>
                    @foreach($categories as $id => $name)
                      <option value="{{ $id }}" @selected($categoryId == $id)>{{ $name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="subcategory_id" id="filter_subcategory">
                    <option value="">All Sub Categories</option>
                    @foreach($subcategories as $sid => $sname)
                      <option value="{{ $sid }}" @selected($subcatId == $sid)>{{ $sname }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Search title / slug">
                </div>
                <div class="col-md-2 d-flex gap-2">
                  <button class="btn btn-primary w-100">Search</button>
                  <a href="{{ route('admin.gallery.index') }}" class="btn btn-light w-100">Reset</a>
                </div>
              </form>
            </div>

            <div class="card-body">
              <div class="d-flex justify-content-end mb-2">
                {{-- JS-only bulk delete; no form --}}
                <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn">
                  <i class="fas fa-trash"></i> Delete Selected
                </button>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                  <thead>
                    <tr>
                      <th style="width:32px"><input type="checkbox" id="selectAll"></th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Slug</th>
                      <th>Category</th>
                      <th class="text-end">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($list as $row)
                      <tr data-row-id="{{ $row->gallery_id }}">
                        <td><input type="checkbox" class="row-check" value="{{ $row->gallery_id }}"></td>
                        <td>
                          @if($row->image)
                            <img src="{{ asset('anvixa/'.$row->image) }}" style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                          @else — @endif
                        </td>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->slug }}</td>
                        <td>
                          {{ $row->category->strCategoryName ?? '-' }}
                          @if($row->subcategory) <br><small class="text-muted">{{ $row->subcategory->strSubCategoryName }}</small> @endif
                        </td>
                        <td class="text-end">
                          <button type="button" class="btn btn-sm btn-warning edit-btn"
                                  data-id="{{ $row->gallery_id }}"
                                  data-title="{{ $row->title }}"
                                  data-category="{{ $row->category_id }}"
                                  data-subcategory="{{ $row->subcategory_id }}"
                                  data-status="{{ $row->iStatus }}">
                            <i class="fas fa-edit"></i>
                          </button>

                          <form method="POST" action="{{ route('admin.gallery.destroy', $row->gallery_id) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="7" class="text-center text-muted">No records found</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              {{ $list->withQueryString()->links() }}
            </div>
          </div>
        </div>
      </div>

      {{-- EDIT MODAL --}}
      <div class="modal fade" id="editGalleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <form method="POST" id="editGalleryForm" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="editId">

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" id="editCategoryId" class="form-control" required>
                      <option value="">Select Category</option>
                      @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Sub Category</label>
                    <select name="subcategory_id" id="editSubcategoryId" class="form-control" required>
                      <option value="">Select Sub Category</option>
                      @foreach($subcategories as $sid => $sname)
                        <option value="{{ $sid }}">{{ $sname }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" id="editTitle" name="title" class="form-control" required>
                    <small class="text-muted">Slug: <span id="editSlugPreview"></span></small>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Replace Image</label>
                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Leave empty to keep existing.</small>
                  </div>
                </div>
              </div>
              <div class="modal-footer d-flex">
                <button class="btn btn-primary" type="submit">Update</button>
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
@include('common.footerjs')
<script>
(function () {
  // ===== helpers =====
  function getMetaCsrf() {
    const el = document.querySelector('meta[name="csrf-token"]');
    return el ? el.getAttribute('content') : '';
  }
 
  function selectedIds() {
    return Array.from(document.querySelectorAll('input.row-check:checked')).map(e => e.value);
  }
  function removeRows(ids) {
    ids.forEach(id => {
      const tr = document.querySelector(`tr[data-row-id="${id}"]`);
      if (tr) tr.remove();
    });
    const total = document.querySelectorAll('input.row-check').length;
    const sel   = document.querySelectorAll('input.row-check:checked').length;
    const sa    = document.getElementById('selectAll');
    if (sa) sa.checked = (total > 0 && sel === total);
  }

  // Slug preview (create)
  document.getElementById('title')?.addEventListener('input', function(){
    const s = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
    const t = document.getElementById('slugPreview'); if (t) t.textContent = s;
  });

  // Dependent subcategory (create)
  $('#category_id').on('change', function(){
    const cid = $(this).val(), sub = $('#subcategory_id');
    sub.html('<option value="">Loading...</option>');
    if (!cid) return sub.html('<option value="">Select Sub Category</option>');
    fetch(`{{ route('admin.fetch-subcategories', ':id') }}`.replace(':id', cid))
      .then(r=>r.json()).then(data=>{
        let opt = '<option value="">Select Sub Category</option>';
        data.forEach(sc => opt += `<option value="${sc.iSubCategoryId}">${sc.strSubCategoryName}</option>`);
        sub.html(opt);
      }).catch(()=> sub.html('<option value="">Select Sub Category</option>'));
  });

  // Select all
  $('#selectAll').on('click', function(){ $('input.row-check').prop('checked', this.checked); });

  // Edit modal open
  $(document).on('click', '.edit-btn', function(){
    const id  = $(this).data('id');
    $('#editId').val(id);
    $('#editTitle').val($(this).data('title'));
    $('#editCategoryId').val($(this).data('category')).trigger('change');
    $('#editSubcategoryId').val($(this).data('subcategory'));
    $('#editSlugPreview').text(
      String($(this).data('title')||'').toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'')
    );
    $('#editGalleryForm').attr('action', `{{ url('admin/gallery') }}/${id}`);
    $('#editGalleryModal').modal('show');
  });

  // Slug preview (edit)
  document.getElementById('editTitle')?.addEventListener('input', function(){
    const s = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
    const t = document.getElementById('editSlugPreview'); if (t) t.textContent = s;
  });

  // Dependent subcategory (edit)
  $('#editCategoryId').on('change', function(){
    const cid = $(this).val(), sub = $('#editSubcategoryId');
    sub.html('<option value="">Loading...</option>');
    if (!cid) return sub.html('<option value="">Select Sub Category</option>');
    fetch(`{{ route('admin.fetch-subcategories', ':id') }}`.replace(':id', cid))
      .then(r=>r.json()).then(data=>{
        let opt = '<option value="">Select Sub Category</option>';
        data.forEach(sc => opt += `<option value="${sc.iSubCategoryId}">${sc.strSubCategoryName}</option>`);
        sub.html(opt);
      }).catch(()=> sub.html('<option value="">Select Sub Category</option>'));
  });

  // ===== JS bulk delete (no form) =====
  document.getElementById('bulkDeleteBtn').addEventListener('click', async function () {
    const ids = selectedIds();
    if (ids.length === 0) { alert('Please select at least one image.'); return; }
    if (!confirm('Delete selected images?')) return;

    try {
      const res = await fetch('{{ route('admin.gallery.bulk-delete') }}', {
        method: 'POST',
        credentials: 'same-origin', // include session cookie
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': getMetaCsrf(),
        },
        body: JSON.stringify({ ids }),
      });

      let data = {};
      try { data = await res.json(); } catch (_) {}

      if (!res.ok || data.status !== 'ok') {
        if (res.status === 419 || (data && /csrf/i.test(data.message || ''))) {
          throw new Error('CSRF token mismatch. Refresh and try again.');
        }
        throw new Error(data.message || 'Bulk delete failed.');
      }

      removeRows(data.deleted_ids || ids);
    } catch (e) {
      console.error(e);
      alert(e.message || 'Failed to delete selected images. Please try again.');
    }
  });
})();
</script>
@endsection
