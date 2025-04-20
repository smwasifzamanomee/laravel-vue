<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Product List</h1>
            <!-- Add Product Button -->
            <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Popular</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>   
                @php
                    $i = 1;
                @endphp
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ url('storage/'.$product->image) }}" alt="product->image" width="100" height="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->featured }}</td>
                        <td>{{ $product->popular }}</td>
                        <td>
                            <a href="{{ url('products/edit/'.$product->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ url('products/delete/'.$product->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach          
            </tbody>
        </table>
    </div>
</div>
</body>
</html>