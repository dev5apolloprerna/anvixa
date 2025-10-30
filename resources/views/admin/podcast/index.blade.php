@extends('layouts.app')
@section('title','Podcast')

@section('content')
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
              <form method="POST" action="{{ route('admin.podcast.store') }}" enctype="multipart/form-data" id="podcastForm">
                @csrf

                <div class="mb-3">
                  <label class="form-label">Category <span class="text-danger">*</span></label>
                  <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $id => $name)
                      <option value="{{ $id }}" @selected(old('category_id')==$id)>{{ $name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                  <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                    <option value="">Select Sub Category</option>
                    @foreach($subcategories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>

                </div>

                <div class="mb-3">
                  <label class="form-label">Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="podcast_title" maxlength="200" required value="{{ old('podcast_title') }}">
                </div>

                <div class="mb-3">
                  <label class="form-label">Video Link <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="video_link" maxlength="200" required placeholder="https://…" value="{{ old('video_link') }}">
                </div>

                <div class="mb-3">
                  <label class="form-label">Thumbnail (jpg/png/webp, max 2MB)</label>
                  <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
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

              <form method="POST" id="bulkDeleteForm" action="{{ route('admin.podcast.bulk-delete') }}">
                @csrf
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
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($list as $row)
                        <tr>
                          <td><input type="checkbox" name="ids[]" value="{{ $row->podcast_id }}"></td>
                          <td>
                            @if($row->image)
                              <img src="{{ asset('storage/'.$row->image) }}" alt="" style="width:56px;height:40px;object-fit:cover;border-radius:4px">
                            @else
                              —
                            @endif
                          </td>
                          <td>{{ $row->podcast_title }}</td>
                          <td>{{ $row->category->strCategoryName ?? '-' }}</td>
                          <td>{{ $row->subcategory->strSubCategoryName ?? '-' }}</td>
                          <td>
                            <a href="{{ $row->video_link }}" target="_blank">Open</a>
                          </td>
                         <!--  <td>
                            @if((int)$row->iStatus===1)
                              <span class="badge bg-success">Active</span>
                            @else
                              <span class="badge bg-secondary">Inactive</span>
                            @endif
                          </td> -->
                          <td >
                            <button type="button" class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $row->podcast_id }}"
                                    data-category="{{ $row->category_id }}"
                                    data-subcategory="{{ $row->subcategory_id }}"
                                    data-title="{{ $row->podcast_title }}"
                                    data-link="{{ $row->video_link }}"
                                    data-status="{{ $row->iStatus }}"
                                    data-image="{{ $row->image }}">
                              <i class="fas fa-edit"></i>
                            </button>

                            <form method="POST" action="{{ route('admin.podcast.destroy', $row->podcast_id) }}" class="d-inline">
                              @csrf @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"
                                      onclick="return confirm('Delete this record?')">
                                <i class="fas fa-trash"></i>
                              </button>
                            </form>

                            <!-- <form method="POST" action="{{ route('admin.podcast.toggle-status', $row->podcast_id) }}" class="d-inline">
                              @csrf @method('PATCH')
                              <button class="btn btn-sm btn-outline-dark">
                                {{ (int)$row->iStatus===1 ? 'Deactivate' : 'Activate' }}
                              </button>
                            </form> -->
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="8">No records found.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </form>

              {{ $list->withQueryString()->links() }}
            </div>
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
                {{-- We’ll just set by JS; you can also dynamically filter based on category --}}
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

            <!-- <div class="col-md-6">
              <label class="form-label d-block">Status</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="editStatusSwitch">
                <label class="form-check-label" for="editStatusSwitch">Active</label>
              </div>
              <input type="hidden" name="iStatus" id="editStatus">
            </div> -->

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
  // Edit button -> fill modal
  $('.edit-btn').on('click', function () {
    const id     = $(this).data('id');
    const cat    = $(this).data('category');
    const sub    = $(this).data('subcategory');
    const title  = $(this).data('title');
    const link   = $(this).data('link');
    const status = parseInt($(this).data('status'), 10) === 1;

    $('#editPodcastId').val(id);
    $('#editCategoryId').val(cat);
    $('#editSubcategoryId').val(sub);
    $('#editTitle').val(title);
    $('#editLink').val(link);
    $('#editStatusSwitch').prop('checked', status);
    $('#editStatus').val(status ? 1 : 0);

    $('#editpodcastForm').attr('action', '{{ url('admin/podcast') }}/' + id);
    $('#editVideoModal').modal('show');
  });

  $('#editStatusSwitch').on('change', function () {
    $('#editStatus').val(this.checked ? 1 : 0);
  });

  // Bulk delete
  $('#bulkDeleteBtn').on('click', function(){
    if(confirm('Delete selected podcast episode?')) {
      $('#bulkDeleteForm').submit();
    }
  });

  // Select all
  $('#selectAll').on('click', function() {
    $('input[name="ids[]"]').prop('checked', this.checked);
  });

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

  // Optional: cascade subcategory filter on the left add form (if you want dynamic)
  // You can wire an endpoint to fetch subcategories by category if needed.
</script>
@endsection
