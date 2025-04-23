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
                    @input="resetPagination"
                >
            </div>
            <div class="col-md-3">
                <select class="form-control" v-model="priceFilter" @change="resetPagination">
                    <option value="">All Prices</option>
                    <option value="0-100">$0 - $100</option>
                    <option value="100-500">$100 - $500</option>
                    <option value="500-1000">$500 - $1000</option>
                    <option value="1000-10000">$1000 - $10000</option>
                    <option value="10000+">$10000+</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" v-model="quantityFilter" @change="resetPagination">
                    <option value="">All Quantities</option>
                    <option value="0-10">1 - 10 items</option>
                    <option value="10-50">10 - 50 items</option>
                    <option value="50+">50+ items</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="perPage" @change="resetPagination">
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
                <tr v-for="(order, i) in paginatedOrders" :key="order.id">
                    <td>{{ (currentPage - 1) * perPage + ++i }}</td>
                    <td>
                        <button 
                            type="button" 
                            class="btn btn-link p-0" 
                            v-on:click="onClickShowDetails(order.id)"
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
                <tr v-if="filteredOrders.length === 0">
                    <td colspan="7" class="text-center">No orders found</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav v-if="filteredOrders.length > 0" class="mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button class="page-link" @click="currentPage--">Previous</button>
                </li>
                
                <li 
                    class="page-item" 
                    v-for="page in pages" 
                    :key="page"
                    :class="{ active: currentPage === page }"
                >
                    <button class="page-link" @click="currentPage = page">{{ page }}</button>
                </li>
                
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                    <button class="page-link" @click="currentPage++">Next</button>
                </li>
            </ul>
        </nav>

        <OrderModal 
            v-if="modalShow" 
            :order_items="order_items" 
            v-on:close="modalShow = false"
        />
        
        <div v-if="loading" class="text-center my-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
import OrderModal from './OrderModal.vue';

export default {
    data() {
        return {
            order_items: [],
            modalShow: false,
            loading: false,
            searchQuery: '',
            priceFilter: '',
            quantityFilter: '',
            currentPage: 1,
            perPage: 5
        }
    },
    components: {
        OrderModal
    },
    props: {
        order_lists: {
            type: Array,
            required: true
        }
    },
    computed: {
        filteredOrders() {
            let filtered = this.order_lists;
            
            // Apply search filter
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(order => 
                    (order.user?.name?.toLowerCase().includes(query) ||
                    (order.user?.phone?.includes(query)) ||
                    (order.user?.address?.toLowerCase().includes(query)) ||
                    (order.id.toString().includes(query))));
            }
            
            // Apply price filter
            if (this.priceFilter) {
                const [min, max] = this.priceFilter.split('-').map(Number);
                if (this.priceFilter.endsWith('+')) {
                    filtered = filtered.filter(order => order.total_price >= min);
                } else {
                    filtered = filtered.filter(order => 
                        order.total_price >= min && order.total_price <= max);
                }
            }
            
            // Apply quantity filter
            if (this.quantityFilter) {
                const [min, max] = this.quantityFilter.split('-').map(Number);
                if (this.quantityFilter.endsWith('+')) {
                    filtered = filtered.filter(order => order.total_quantity >= min);
                } else {
                    filtered = filtered.filter(order => 
                        order.total_quantity >= min && order.total_quantity <= max);
                }
            }
            
            return filtered;
        },
        paginatedOrders() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredOrders.slice(start, end);
        },
        totalPages() {
            return Math.ceil(this.filteredOrders.length / this.perPage);
        },
        pages() {
            const pages = [];
            // Show up to 5 page buttons around current page
            let start = Math.max(1, this.currentPage - 2);
            let end = Math.min(this.totalPages, start + 4);
            
            // Adjust if we're near the start
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
        onClickShowDetails(id) {
            this.loading = true;
            this.modalShow = true;
            
            // Fetch order items for this order ID
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
        resetPagination() {
            this.currentPage = 1;
        }
    },
    watch: {
        currentPage(newVal) {
            if (newVal < 1) this.currentPage = 1;
            if (newVal > this.totalPages) this.currentPage = this.totalPages;
        }
    }
}
</script>

<style scoped>
.page-link {
    cursor: pointer;
}
</style>