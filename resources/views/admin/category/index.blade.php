@extends('layouts.app')
 
 @section('title', 'Category')

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
                            <h4 class="card-title mb-0">Add Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.category.store') }}" id="categoryForm">
                                @csrf
 
                                <div class="mb-3">
                                    <label for="strCategoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="strCategoryName" name="strCategoryName" maxlength="50" required>
                                </div>
 
                                <div class="mb-3">
                                    <label for="strSlug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="strSlug" name="strSlug" maxlength="50" required>
                                </div>
 
                                <div class="d-flex justify-content-between">
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
                            <h4 class="card-title mb-0">Category Listing</h4>
                            <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete All
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- <form method="POST" id="bulkDeleteForm" action="{{ route('admin.category.bulk-delete') }}">
                                @csrf -->
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Category Name</th>
                                            <th>Slug</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="ids[]" value="{{ $category->iCategoryId }}">
                                            </td>
                                            <td>{{ $category->strCategoryName }}</td>
                                            <td>{{ $category->strSlug }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                    data-id="{{ $category->iCategoryId }}"
                                                    data-name="{{ $category->strCategoryName }}"
                                                    data-slug="{{ $category->strSlug }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" action="{{ route('admin.category.destroy', $category->iCategoryId) }}" style="display:inline;">
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
                                            <td colspan="4">No records found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            <!-- </form> -->
 
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
 
        </div> <!-- container-fluid -->
    </div> <!-- page-content -->
</div> <!-- main-content -->
 
<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editCategoryForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
 
                    <input type="hidden" name="id" id="editCategoryId">
 
                    <div class="mb-3">
                        <label for="editStrCategoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editStrCategoryName" name="strCategoryName" maxlength="50" required>
                    </div>
 
                    <div class="mb-3">
                        <label for="editStrSlug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editStrSlug" name="strSlug" maxlength="50" required>
                    </div>
 
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
        let name = $(this).data('name');
        let slug = $(this).data('slug');
 
        $('#editCategoryId').val(id);
        $('#editStrCategoryName').val(name);
        $('#editStrSlug').val(slug);
 
        $('#editCategoryForm').attr('action', '/admin/category/' + id);
        $('#editCategoryModal').modal('show');
    });
 
    // Bulk delete
    /*$('#bulkDeleteBtn').on('click', function() {
        if(confirm('Are you sure you want to delete selected records?')) {
            $('#bulkDeleteForm').submit();
        }
    });*/
 
    $('#bulkDeleteBtn').on('click', function() {
    var ids = $('input[name="ids[]"]:checked').map(function(){
        return $(this).val();
    }).get();

    if (ids.length === 0) {
        alert("Please select at least one record to delete.");
        return;
    }

    if(confirm('Are you sure you want to delete selected records?')) {
        $.ajax({
            url: "{{ route('admin.category.bulk-delete') }}",
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                ids: ids
            },
            success: function(response) {
                alert('Deleted successfully.');
                location.reload();
            },
            error: function(xhr) {
                alert('An error occurred.');
            }
        });
    }
});


    // Select all checkbox
    $('#selectAll').on('click', function() {
        $('input[name="ids[]"]').prop('checked', this.checked);
    });
</script>
@endsection
 
 