<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Our <span>products</span></h2>
        </div>
        
        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="" class="option1">
                                    <!-- category name need but i have category id -->
                                    {{ $product->category->name }}
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
                            <h5>{{ $product->name }}</h5>
                            <h6>${{ $product->price }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination Links -->
        <div class="row mt-4">
            <!-- <form method="GET" action="{{ url()->current() }}" id="perPageForm">
                    <select name="per_page" id="per_page" class="form-control" onchange="document.getElementById('perPageForm').submit()">
                        <option value="1" {{ request('per_page') == 1 ? 'selected' : '' }}>1</option>
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
            </form> -->
            <div class="col-md-12">
                {{ $products->appends(['per_page' => request('per_page')])->links('pagination::bootstrap-4') }}
            </div>
        </div>
        
        <div class="btn-box">
            <a href="">View All products</a>
        </div>
    </div>
</section>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a, 
    .pagination li span {
        padding: 8px 16px;
        border: 1px solid #ddd;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .pagination li a:hover {
        background-color: #ddd;
    }

    .pagination li.disabled span {
        color: #aaa;
        pointer-events: none;
        cursor: not-allowed;
    }
</style>

<!-- pagination script not go to top -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add click event handler to pagination links
        $('.pagination li a').on('click', function(e) {
            e.preventDefault();
            var page = $(this).attr('href');
            window.location.href = page;
        });
    });
    // Handle per_page select change
    $('#per_page').change(function() {
        loadProducts($(this).val(), 1);
    });
    // Handle pagination clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        var perPage = $('#per_page').val();
        loadProducts(perPage, page);
    });

    function loadProducts(perPage, page) {
        $.ajax({
            url: '{{ url()->current() }}',
            type: 'GET',
            data: {
                per_page: perPage,
                page: page
            },
            success: function(data) {
                // Replace only the products container
                $('#products-container').html(
                    $(data).find('#products-container').html()
                );
                
                // Update the URL without reloading
                history.pushState(null, null, '?per_page=' + perPage + '&page=' + page);
            }
        });
    }
</script>