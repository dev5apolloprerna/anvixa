@extends('layouts.app')
  @section('title', 'Sub Category')

@section('content')
 
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
 
            {{-- Alert Messages --}}
            @include('common.alert')
 
            <div class="row">
                <!-- Left side - Add Form -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Add Sub Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.sub-category.store') }}" id="subCategoryForm">
                                @csrf
 
                                <div class="mb-3">
                                    <label for="iCategoryId" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="iCategoryId" id="iCategoryId" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
 
                                <div class="mb-3">
                                    <label for="strSubCategoryName" class="form-label">Sub Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="strSubCategoryName" name="strSubCategoryName" maxlength="50" required>
                                </div>
 
                                <!-- <div class="mb-3">
                                    <label for="strSlug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="strSlug" name="strSlug" maxlength="50" required>
                                </div> -->
 
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-light">Clear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
 
                <!-- Right side - Listing -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title mb-0">Sub Category Listing</h4>
                            <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete All
                            </button>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="bulkDeleteForm" action="{{ route('admin.sub-category.bulk-delete') }}">
                                @csrf
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Category</th>
                                            <th>Sub Category Name</th>
                                            <!-- <th>Slug</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($subcategories as $subcategory)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ids[]" value="{{ $subcategory->iSubCategoryId }}">
                                            </td>
                                            <td>{{ $subcategory->category->strCategoryName ?? '-' }}</td>
                                            <td>{{ $subcategory->strSubCategoryName }}</td>
                                            <!-- <td>{{ $subcategory->strSlug }}</td> -->
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                    data-id="{{ $subcategory->iSubCategoryId }}"
                                                    data-category="{{ $subcategory->iCategoryId }}"
                                                    data-name="{{ $subcategory->strSubCategoryName }}"
                                                    data-slug="{{ $subcategory->strSlug }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.sub-category.destroy', $subcategory->iSubCategoryId) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this record?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">No records found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </form>
 
                            {{ $subcategories->links() }}
                        </div>
                    </div>
                </div>
            </div>
 
        </div> <!-- container-fluid -->
    </div> <!-- page-content -->
</div> <!-- main-content -->
 
 <div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-labelledby="editSubCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editSubCategoryForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
 
                    <input type="hidden" name="id" id="editSubCategoryId">
 
                    <div class="mb-3">
                        <label for="editICategoryId" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="iCategoryId" id="editICategoryId" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
 
                    <div class="mb-3">
                        <label for="editStrSubCategoryName" class="form-label">Sub Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editStrSubCategoryName" name="strSubCategoryName" maxlength="50" required>
                    </div>
 
                   <!--  <div class="mb-3">
                        <label for="editStrSlug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editStrSlug" name="strSlug" maxlength="50" required>
                    </div> -->
 
                </div>
                <div class="modal-footer d-flex ">
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
    // Edit button click
    $('.edit-btn').on('click', function() {
        let id = $(this).data('id');
        let category = $(this).data('category');
        let name = $(this).data('name');
        let slug = $(this).data('slug');
 
        $('#editSubCategoryId').val(id);
        $('#editICategoryId').val(category);
        $('#editStrSubCategoryName').val(name);
        $('#editStrSlug').val(slug);
 
        $('#editSubCategoryForm').attr('action', '/admin/sub-category/' + id);
        $('#editSubCategoryModal').modal('show');
    });
 
    // Bulk delete
    $('#bulkDeleteBtn').on('click', function() {
        if(confirm('Are you sure you want to delete selected records?')) {
            $('#bulkDeleteForm').submit();
        }
    });
 
    // Select all checkbox
    $('#selectAll').on('click', function() {
        $('input[name="ids[]"]').prop('checked', this.checked);
    });


(function () {
  function toSlug(s) {
    return (s || '')
      .toString()
      .normalize('NFKD')
      .replace(/[\u0300-\u036f]/g, '')
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .substring(0, 50);
  }

  // Create form elements
  const nameEl = document.getElementById('strSubCategoryName');
  const slugEl = document.getElementById('strSlug');

  // Edit modal elements
  const editNameEl = document.getElementById('editStrSubCategoryName');
  const editSlugEl = document.getElementById('editStrSlug');

  let userEditedCreateSlug = false;
  let userEditedEditSlug = false;

  slugEl?.addEventListener('input', () => userEditedCreateSlug = true);
  editSlugEl?.addEventListener('input', () => userEditedEditSlug = true);

  nameEl?.addEventListener('input', function () {
    if (!userEditedCreateSlug) slugEl.value = toSlug(this.value);
  });

  editNameEl?.addEventListener('input', function () {
    if (!userEditedEditSlug) editSlugEl.value = toSlug(this.value);
  });

  // If slug empty on load, prime it from name once
  if (nameEl && slugEl && !slugEl.value) slugEl.value = toSlug(nameEl.value);
})();

</script>
@endsection
 