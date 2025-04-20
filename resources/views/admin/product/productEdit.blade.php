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
            <h1>Edit Product</h1>
        </div>
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
        @if(session('message'))
            <div class="alert alert-success" >
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session('message') }}
            </div>
        @endif
            <form class="row g-3" method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" placeholder="Enter Product Name" class="form-control" id="name" value="{{ $product->name }}" required />
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="js-example-basic-multiple form-control" name="category_id" required>
                        @foreach($categories as $key => $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Enter Image">
                </div>
                <div class="col-12 mt-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" placeholder="Enter Description" class="form-control" id="description" value="{{ $product->description }}" required />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" placeholder="Enter Price" class="form-control" id="price" value="{{ $product->price }}" required />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" name="quantity" placeholder="Enter Quantity" class="form-control" id="quantity" value="{{ $product->quantity }}" required />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="discount_price" class="form-label">Discount Price</label>
                    <input type="text" name="discount_price" placeholder="Enter Discount Price" class="form-control" id="discount_price" value="{{ $product->discount_price }}" required />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select form-control" required>
                        <option value="">Select Status</option>
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="featured" class="form-label">Featured</label>
                    <select name="featured" id="featured" class="form-select form-control" required>
                        <option value="">Select Featured</option>
                        <option value="yes" {{ $product->featured == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $product->featured == 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="popular" class="form-label">Popular</label>
                    <select name="popular" id="popular" class="form-select form-control" required>
                        <option value="">Select Popular</option>
                        <option value="yes" {{ $product->popular == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $product->popular == 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
                
            </form>
    </div>
</div>
@endsection