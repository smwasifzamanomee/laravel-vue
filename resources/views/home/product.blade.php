<section class="product_section layout_padding">
    <div class="container">
    <div class="heading_container heading_center">
        <h2>
            Our <span>products</span>
        </h2>
    </div>
    <div class="row">
        @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-4">
                <div class="box">
                    <div class="option_container">
                    <div class="options">
                        <a href="" class="option1">
                        {{ $product->name }}
                        </a>
                        <a href="" class="option2">
                        Buy Now
                        </a>
                    </div>
                    </div>
                    <div class="img-box">
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/p1.png') }}" alt="Default Image">
                        @endif
                    </div>
                    <div class="detail-box">
                    <h5>
                        {{ $product->name }}
                    </h5>
                    <h6>
                        ${{ $product->price }}
                    </h6>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>
    <div class="btn-box">
        <a href="">
        View All products
        </a>
    </div>
    </div>
</section>