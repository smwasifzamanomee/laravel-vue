<template>
    <div>
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
                <tr v-for="(order, i) in order_lists" :key="order.id">
                    <td>{{ ++i }}</td>
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
            </tbody>
        </table>

        <OrderModal 
            v-if="modalShow" 
            :order_items="order_items" 
            v-on:close="modalShow = false"
        />
    </div>
</template>

<script>
import OrderModal from './OrderModal.vue';

export default {
    data() {
        return {
            order_items: [],
            modalShow: false,
            loading: false
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
    methods: {
        onClickShowDetails(id) {
            this.loading = true;
            this.modalShow = true;
            
            // Fetch order items for this order ID
            axios.get(`/orders/items/${id}`)
                .then(response => {
                    this.order_items = response.data;
                    this.loading = false;
                    console.log(this.order_items);
                })
                .catch(error => {
                    console.error("Error fetching order items:", error);
                    this.loading = false;
                });
        }
    },
}
</script>