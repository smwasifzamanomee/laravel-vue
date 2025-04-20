@extends('admin.layout')

@section('content')
<style> 
    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    min-height: 39px;
    user-select: none;
    background-color:#2A3038;
    border: 1px solid #2A3038;
    -webkit-user-select: none;
}
</style>
   

   
<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Add Product</h1>
        </div>
        {{-- ✅ Show all validation errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Show success message --}}
        @if(session('message'))
            <div class="alert alert-success" >
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
        <form class="row g-3" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Product Name" required>
            </div>
            <div class="col-md-3">
                <label for="inputCategory" class="form-label">Category</label>            
                <select class="js-example-basic-multiple form-control" name="category_id" required>
                    @foreach($categories as $key => $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="inputImage" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" placeholder="Enter Image">
            </div>

            <div class="col-12 mt-3">
                <label for="inputDescription" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" placeholder="Enter Description" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputPrice" class="form-label">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Enter Price" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputQuantity" class="form-label">Quantity</label>
                <input type="text" name="quantity" class="form-control" placeholder="Enter Quantity" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputDiscount" class="form-label">Discount Price</label>
                <input type="text" name="discount_price" class="form-control" placeholder="Enter Discount Price" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputStatus" class="form-label">Status</label>
                <select name="status" id="inputStatus" class="form-select form-control" required>
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="col-md-4 mt-3">
                <label for="inputFeatured" class="form-label">Featured</label>
                <select name="featured" id="inputFeatured" class="form-select form-control" required>
                    <option value="">Select Featured</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="col-md-4 mt-3">
                <label for="inputPopular" class="form-label">Popular</label>
                <select name="popular" id="inputPopular" class="form-select form-control" required>
                    <option value="">Select Popular</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary"> + Add Product</button>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>