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
                                <a href="javascript:void(0);" class="option2 add-to-cart" data-id="{{ $product->id }}">
                                    Add To Cart
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
    .add-to-cart.disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }   
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');

            if (this.classList.contains('disabled')) return;

            const originalText = this.innerText;
            this.innerText = 'Adding...';
            this.disabled = true;

            fetch(`/cart/add/${productId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'include'
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = '/login/?next=' + encodeURIComponent(window.location.pathname);
                    return;
                }
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                if (!data) return;

                const cartCountEl = document.querySelector('.cart-count');
                if (cartCountEl && data.cart_count !== undefined) {
                    cartCountEl.textContent = data.cart_count;
                    cartCountEl.style.display = 'inline-block';
                }

                if (data.status === 'success') {
                    this.innerText = 'Added!';
                    this.classList.add('disabled');
                    this.disabled = true;
                } else if (data.status === 'error') {
                    this.innerText = 'Already Added';
                    this.classList.add('disabled');
                    this.disabled = true;
                }

                console.log('Cart response:', data);
            })
            .catch(err => {
                console.error('Error:', err);
                this.innerText = 'Error!';
                setTimeout(() => {
                    this.innerText = originalText;
                    this.disabled = false;
                }, 1000);
            });
        });
    });
});
</script>

