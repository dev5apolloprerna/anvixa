@extends('layouts.app')
@section('title', 'Podcast')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                @include('common.alert')

                <div class="row">
                    {{-- ===== Left: Add Form ===== --}}
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add Podcast</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.podcast.store') }}"
                                    enctype="multipart/form-data" id="podcastForm">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}" @selected(old('category_id') == $id)>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                        <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                            <option value="">Select Sub Category</option>
                                            @foreach ($subcategories as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="podcast_title" maxlength="200"
                                            required value="{{ old('podcast_title') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Video Link <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="video_link" maxlength="200"
                                            required placeholder="https://…" value="{{ old('video_link') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Thumbnail (jpg/png/webp, max 2MB)</label>
                                        <input type="file" class="form-control" name="image"
                                            accept=".jpg,.jpeg,.png,.webp">
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="reset" class="btn btn-light">Clear</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ===== Right: Listing ===== --}}
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <form method="GET" class="row g-2 align-items-center"
                                    action="{{ route('admin.podcast.index') }}">
                                    <div class="col-md-3">
                                        <select class="form-control" name="category_id" id="filter_category">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}" @selected($categoryId == $id)>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="subcategory_id" id="filter_subcategory">
                                            <option value="">All Sub Categories</option>
                                            @foreach ($subcategories as $id => $name)
                                                <option value="{{ $id }}" @selected($subcatId == $id)>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="q"
                                            value="{{ $q }}" placeholder="Search title/link">
                                    </div>
                                    <div class="col-md-2 d-flex gap-2">
                                        <button class="btn btn-primary w-100">Search</button>
                                        <a href="{{ route('admin.podcast.index') }}" class="btn btn-light w-100">Reset</a>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end mb-2">
                                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete All
                                    </button>
                                </div>

                                {{-- NO bulk form; JS will call the endpoint --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width:32px">
                                                    <input type="checkbox" id="selectAll">
                                                </th>
                                                <th>Thumb</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Link</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($list as $row)
                                                <tr data-row-id="{{ $row->podcast_id }}">
                                                    <td><input type="checkbox" class="row-check"
                                                            value="{{ $row->podcast_id }}"></td>
                                                    <td>
                                                        @if ($row->image)
                                                            <img src="{{ asset('anvixa/' . $row->image) }}"
                                                                style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                    <td>{{ $row->podcast_title }}</td>
                                                    <td>{{ $row->category->strCategoryName ?? '-' }}</td>
                                                    <td>{{ $row->subcategory->strSubCategoryName ?? '-' }}</td>
                                                    <td><a href="{{ $row->video_link }}" target="_blank">Open</a></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                            data-id="{{ $row->podcast_id }}"
                                                            data-category="{{ $row->category_id }}"
                                                            data-subcategory="{{ $row->subcategory_id }}"
                                                            data-title="{{ $row->podcast_title }}"
                                                            data-link="{{ $row->video_link }}"
                                                            data-image="{{ $row->image }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        {{-- single delete form (server deletes image too) --}}
                                                        <form method="POST"
                                                            action="{{ route('admin.podcast.destroy', $row->podcast_id) }}"
                                                            class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Delete this record?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7">No records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{ $list->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

        {{-- ===== Right: Listing ===== --}}
        <div class="col-lg-8">
          <div class="card">
            <div class="card-header">
              <form method="GET" class="row g-2 align-items-center" action="{{ route('admin.podcast.index') }}">
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
                    @foreach($subcategories as $id => $name)
                      <option value="{{ $id }}" @selected($subcatId == $id)>{{ $name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Search title/link">
                </div>
                <div class="col-md-2 d-flex gap-2">
                  <button class="btn btn-primary w-100">Search</button>
                  <a href="{{ route('admin.podcast.index') }}" class="btn btn-light w-100">Reset</a>
                </div>
              </form>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-end mb-2">
                <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i> Delete All
                </button>
              </div>

              {{-- NO bulk form; JS will call the endpoint --}}
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                  <thead>
                    <tr>
                      <th style="width:32px">
                        <input type="checkbox" id="selectAll">
                      </th>
                      <th>Thumb</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Sub Category</th>
                      <th>Link</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($list as $row)
                      <tr data-row-id="{{ $row->podcast_id }}">
                        <td><input type="checkbox" class="row-check" value="{{ $row->podcast_id }}"></td>
                        <td>
                          @if($row->image)
                            <img src="{{ asset('anvixa/'.$row->image) }}" style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                          @else — @endif
                        </td>
                        <td>{{ $row->podcast_title }}</td>
                        <td>{{ $row->category->strCategoryName ?? '-' }}</td>
                        <td>{{ $row->subcategory->strSubCategoryName ?? '-' }}</td>
                        <td><a href="{{ $row->video_link }}" target="_blank">Open</a></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning edit-btn"
                                  data-id="{{ $row->podcast_id }}"
                                  data-category="{{ $row->category_id }}"
                                  data-subcategory="{{ $row->subcategory_id }}"
                                  data-title="{{ $row->podcast_title }}"
                                  data-link="{{ $row->video_link }}"
                                  data-image="{{ $row->image }}">
                            <i class="fas fa-edit"></i>
                          </button>

                          {{-- single delete form (server deletes image too) --}}
                          <form method="POST" action="{{ route('admin.podcast.destroy', $row->podcast_id) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this record?')">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="7">No records found.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              {{ $list->withQueryString()->links() }}
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

{{-- ===== Edit Modal ===== --}}
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editpodcastForm" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Podcast</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editPodcastId">

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
                @foreach(\App\Models\SubCategory::orderBy('strSubCategoryName')->pluck('strSubCategoryName','iSubCategoryId') as $sid => $sname)
                  <option value="{{ $sid }}">{{ $sname }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Title</label>
              <input type="text" class="form-control" id="editTitle" name="podcast_title" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Video Link</label>
              <input type="text" class="form-control" id="editLink" name="video_link" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Replace Thumbnail</label>
              <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
              <small class="text-muted">Leave empty to keep current.</small>
            </div>
          </div>
        </div>
        <div class="modal-footer d-flex">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
@include('common.footerjs')
<script>
  // ===== util: CSRF token from meta =====
  function csrfToken() {
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

  // ===== Edit button -> fill modal =====
  $('.edit-btn').on('click', function () {
    const id    = $(this).data('id');
    const cat   = $(this).data('category');
    const sub   = $(this).data('subcategory');
    const title = $(this).data('title');
    const link  = $(this).data('link');

    $('#editPodcastId').val(id);
    $('#editCategoryId').val(cat);
    $('#editSubcategoryId').val(sub);
    $('#editTitle').val(title);
    $('#editLink').val(link);

    $('#editpodcastForm').attr('action', '{{ url('admin/podcast') }}/' + id);
    $('#editVideoModal').modal('show');
  });

  // ===== Bulk delete via JS (no form) =====
  document.getElementById('bulkDeleteBtn').addEventListener('click', async function () {
    const ids = selectedIds();
    if (ids.length === 0) {
      alert('Please select at least one podcast.');
      return;
    }
    if (!confirm('Delete selected podcast(s)?')) return;

    try {
      const res = await fetch('{{ route('admin.podcast.bulk-delete') }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken(),
          'Accept': 'application/json'
        },
        body: JSON.stringify({ ids })
      });

      const data = await res.json();
      if (!res.ok || data.status !== 'ok') {
        throw new Error(data.message || 'Bulk delete failed');
      }

      // Remove from DOM without reload
      removeRows(data.deleted_ids || ids);
    } catch (e) {
      console.error(e);
      alert('Failed to delete selected podcasts. Please try again.');
    }
  });

  // ===== Select all / sync =====
  document.getElementById('selectAll').addEventListener('change', function () {
    const checked = this.checked;
    document.querySelectorAll('input.row-check').forEach(cb => cb.checked = checked);
  });
  document.addEventListener('change', function (e) {
    if (e.target && e.target.classList.contains('row-check')) {
      const total = document.querySelectorAll('input.row-check').length;
      const sel   = document.querySelectorAll('input.row-check:checked').length;
      document.getElementById('selectAll').checked = (total > 0 && sel === total);
    }
  });

  // ===== Cascade subcategories (Add form) =====
  $('#category_id').on('change', function() {
    const catId = $(this).val();
    $('#subcategory_id').html('<option value="">Loading...</option>');
    if (!catId) return $('#subcategory_id').html('<option value="">Select Sub Category</option>');

    fetch(`/admin/fetch-subcategories/${catId}`)
      .then(res => res.json())
      .then(data => {
        let options = '<option value="">Select Sub Category</option>';
        data.forEach(sc => options += `<option value="${sc.iSubCategoryId}">${sc.strSubCategoryName}</option>`);
        $('#subcategory_id').html(options);
      });
  });
</script>
@endsection
