<section class="">
    <!-- Order Summary - Positioned Top Right -->
    @isset($cart)
        <div class="order-summary position-absolute top-0 end-0 p-3 bg-light rounded shadow-sm mt-5" style="width: 300px;">
            <h5 class="mb-3">Order Summary</h5>
            @php
                $totalQuantity = 0;
                $totalAmount = 0;
                foreach($cart as $item) {
                    $totalQuantity += $item['quantity'];
                    $totalAmount += $item['price'] * $item['quantity'];
                }
            @endphp

            <div class="d-flex justify-content-between">
                <span>Total Items:</span>
                <span>{{ count($cart) }}</span>
            </div>
            
            <div class="d-flex justify-content-between">
                <span>Total Quantity:</span>
                <span>{{ $totalQuantity }}</span>
            </div>
            <!-- line add -->
            <hr>
            <div class="d-flex justify-content-between mt-2">
                <span>Total Amount:</span>
                <span>${{ number_format($totalAmount, 2) }}</span>
            </div>
            
            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-success w-100">
                    Proceed to Checkout
                </button>
            </form>
        </div>
    @endisset
    <div class="container">
            <!-- Cart Items -->
            <div class="cart-items @isset($cart) mt-5 @endisset">
                @isset($cart)
                    @foreach($cart as $key => $item)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if(!empty($item['image']) && file_exists(public_path('storage/' . $item['image'])))
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="width: 250px; height: 150px;">
                                    @else
                                        <img src="{{ asset('images/p1.png') }}" alt="Default Image" class="img-fluid" style="width: 250px; height: 150px;">
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item['name'] }}</h5>
                                        <div class="d-flex align-items-center quantity-container">
                                            <form action="{{ route('cart.decrease', $key) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary quantity-btn">-</button>
                                            </form>
                                            <span class="mx-2 quantity-value">{{ $item['quantity'] }}</span>
                                            <form action="{{ route('cart.increase', $key) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary quantity-btn">+</button>
                                            </form>
                                        </div>
                                        <p class="card-text mt-2">Price: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body d-flex align-items-center h-100">
                                        <form action="{{ route('cart.delete', $key) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        Your cart is empty
                    </div>
                @endisset
            </div>
    </div>
</section>

<style>
    .quantity-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
    }
    .quantity-value {
        min-width: 30px;
        text-align: center;
    }
    
    .order-summary {
        z-index: 10;
        margin: 20px;
    }
    
    .cart-items {
        margin-top: 100px; /* Adjust based on your summary height */
    }
    
    @media (max-width: 1840px) {
        .order-summary {
            position: static !important;
            width: 100% !important;
            margin: 0 0 20px 0 !important;
        }
        
        .cart-items {
            margin-top: 0 !important;
        }
    }
</style>
