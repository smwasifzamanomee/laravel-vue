<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="text-success">Category List</h1>
            
            <!-- Add Category Button -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle"></i> Add Category
            </button>
        </div>
        
        <!-- Search and Filter Form -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('category.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('category.index') }}" class="btn btn-outline-danger">
                                        <i class="bi bi-x"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <select name="date_filter" class="form-select" onchange="this.form.submit()">
                                <option value="">Filter by date</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <select name="per_page" class="form-select" onchange="this.form.submit()">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 per page</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Categories Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary edit-btn" 
                                                data-id="{{ $category->id }}" 
                                                data-name="{{ $category->name }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" 
                                                data-id="{{ $category->id }}"
                                                data-name="{{ $category->name }}">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No categories found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                    </div>
                    <div>
                        {{ $categories->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('category.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" id="categoryName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('category.update') }}">
                @csrf
                <input type="hidden" name="id" id="editCategoryId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" id="editCategoryName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category "<span id="categoryNameToDelete"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="GET" action="">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Edit button click handler
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        $('#editCategoryId').val(id);
        $('#editCategoryName').val(name);
        $('#editCategoryModal').modal('show');
    });
    // Delete button click handler
    $('.delete-btn').click(function() {
        var categoryId = $(this).data('id');
        var categoryName = $(this).data('name');
        
        // Set the category name in the modal
        $('#categoryNameToDelete').text(categoryName);
        
        // Set the form action URL
        $('#deleteForm').attr('action', '/category/delete/' + categoryId);
        
        // Show the modal
        $('#deleteConfirmationModal').modal('show');
    });
    
    // Clear search when clicking the X button
    $('.btn-outline-danger').click(function() {
        window.location.href = "{{ route('category.index') }}";
    });
    
    // Auto close success message after 3 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 3000);
});
</script>
</body>
</html>