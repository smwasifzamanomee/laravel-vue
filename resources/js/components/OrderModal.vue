<template>
    <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;" aria-modal="true">
        <div role="document" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" @click="$emit('close')" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="loading" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <table v-else class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in order_items" :key="item.id">
                                <td>{{ item.product.name }}</td>
                                <td>{{ item.quantity }}</td>
                                <td>{{ item.price }}</td>
                                <td>{{ item.quantity * item.price }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">Total :</td>
                                <td>{{ order_items.reduce((acc, item) => acc + item.quantity, 0) }}</td>
                                <td></td>
                                <td>{{ order_items.reduce((acc, item) => acc + item.quantity * item.price, 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        order_items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            loading: false
        }
    }
}
</script>