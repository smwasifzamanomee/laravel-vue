<template>
    <div>
        <!-- Search and Filter Controls -->
        <div class="row mb-3">
            <div class="col-md-4">
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="Search by name, phone, or address" 
                    v-model="searchQuery"
                    @input="debouncedSearch"
                >
            </div>
            <div class="col-md-3">
                <select class="form-control" v-model="priceFilter" @change="fetchOrders">
                    <option value="">All Prices</option>
                    <option value="0-100">$0 - $100</option>
                    <option value="100-500">$100 - $500</option>
                    <option value="500-1000">$500 - $1000</option>
                    <option value="1000-10000">$1000 - $10000</option>
                    <option value="10000+">$10000+</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" v-model="quantityFilter" @change="fetchOrders">
                    <option value="">All Quantities</option>
                    <option value="0-10">1 - 10 items</option>
                    <option value="10-50">10 - 50 items</option>
                    <option value="50+">50+ items</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="perPage" @change="fetchOrders">
                    <option value="5">5 per page</option>
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>

        <!-- Order Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL. No</th>
                    <th>Order ID</th>
                    <th>User Name</th>
                    <th>User Phone</th>
                    <th>User Address</th>
                    <th>Total Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>   
                <tr v-for="(order, i) in orders.data" :key="order.id">
                    <td>{{ orders.from + i }}</td>
                    <td>
                        <button 
                            type="button" 
                            class="btn btn-link p-0" 
                            @click="onClickShowDetails(order.id)"
                        >
                            {{ order.id }}
                        </button>
                    </td>
                    <td>{{ order.user ? order.user.name : '' }}</td>
                    <td>{{ order.user ? order.user.phone : '' }}</td>
                    <td>{{ order.user ? order.user.address : '' }}</td>
                    <td>{{ order.total_quantity }}</td>
                    <td>{{ order.total_price }}</td>
                </tr>   
                <tr v-if="loading">
                    <td colspan="7" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tr>
                <tr v-else-if="orders.data.length === 0">
                    <td colspan="7" class="text-center">No orders found</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav v-if="orders.data.length > 0" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: orders.current_page === 1 }">
                    <button class="page-link" @click="changePage(orders.current_page - 1)">Previous</button>
                </li>
                
                <li 
                    class="page-item" 
                    v-for="page in pages" 
                    :key="page"
                    :class="{ active: orders.current_page === page }"
                >
                    <button class="page-link" @click="changePage(page)">{{ page }}</button>
                </li>
                
                <li class="page-item" :class="{ disabled: orders.current_page === orders.last_page }">
                    <button class="page-link" @click="changePage(orders.current_page + 1)">Next</button>
                </li>
            </ul>
        </nav>

        <OrderModal 
            v-if="modalShow" 
            :order_items="order_items" 
            @close="modalShow = false"
        />
    </div>
</template>

<script>
import OrderModal from './OrderModal.vue';
import _ from 'lodash';

export default {
    name:'OrderList',
    data() {
        return {
            orders: {
                data: [],
                current_page: 1,
                from: 1,
                last_page: 1,
                per_page: 5,
                total: 0
            },
            order_items: [],
            modalShow: false,
            loading: false,
            searchQuery: '',
            priceFilter: '',
            quantityFilter: '',
            perPage: 5
        }
    },
    components: {
        OrderModal
    },
    created() {
        this.fetchOrders();
    },
    computed: {
        pages() {
            const pages = [];
            let start = Math.max(1, this.orders.current_page - 2);
            let end = Math.min(this.orders.last_page, start + 4);
            
            if (end - start < 4 && start > 1) {
                start = Math.max(1, end - 4);
            }
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            
            return pages;
        }
    },
    methods: {
        fetchOrders() {
            this.loading = true;
            
            const params = {
                page: this.orders.current_page,
                per_page: this.perPage,
                search: this.searchQuery,
                price_filter: this.priceFilter,
                quantity_filter: this.quantityFilter
            };
            
            axios.get('/order', { params })
                .then(response => {
                    this.orders = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error("Error fetching orders:", error);
                    this.loading = false;
                });
        },
        onClickShowDetails(id) {
            this.loading = true;
            this.modalShow = true;
            
            axios.get(`/orders/items/${id}`)
                .then(response => {
                    this.order_items = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error("Error fetching order items:", error);
                    this.loading = false;
                });
        },
        changePage(page) {
            if (page >= 1 && page <= this.orders.last_page) {
                this.orders.current_page = page;
                this.fetchOrders();
            }
        },
        debouncedSearch: _.debounce(function() {
            this.fetchOrders();
        }, 500)
    },
    watch: {
        perPage() {
            this.fetchOrders();
        }
    }
}
</script>

<style scoped>
.page-link {
    cursor: pointer;
}
</style>