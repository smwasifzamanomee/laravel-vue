<section class="arrival_section">
    <div class="container">
        <div class="box">
            <!-- Loop through cart items -->
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
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item['name'] }}</h5>
                                <p class="card-text">Quantity: {{ $item['quantity'] }}</p>
                                <p class="card-text">Price: ${{ $item['price'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
