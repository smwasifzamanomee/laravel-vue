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
        <form class="row g-3">
            <div class="col-md-6">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Product Name" required>
            </div>
            <div class="col-md-3">
                <label for="inputCategory" class="form-label">Category</label>            
                <select class="js-example-basic-multiple form-control" name="categories">
                    @foreach($categories as $key => $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="inputImage" class="form-label">Image</label>
                <input type="file" name="image" class="form-control" placeholder="Enter Image" required>
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
                <input type="text" name="status" class="form-control" placeholder="Enter Status" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputFeatured" class="form-label">Featured</label>
                <input type="text" name="featured" class="form-control" placeholder="Enter Featured" required>
            </div>
            <div class="col-md-4 mt-3">
                <label for="inputPopular" class="form-label">Popular</label>
                <input type="text" name="popular" class="form-control" placeholder="Enter Popular" required>
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