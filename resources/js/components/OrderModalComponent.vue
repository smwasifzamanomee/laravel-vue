<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal">
      <h4>Order ID: {{ order.id }}</h4>
      <p><strong>User:</strong> {{ order.user.name }}</p>
      <p><strong>Phone:</strong> {{ order.user.phone }}</p>
      <p><strong>Address:</strong> {{ order.user.address }}</p>
      <p><strong>Total Quantity:</strong> {{ order.total_quantity }}</p>
      <p><strong>Total Price:</strong> {{ order.total_price }}</p>
      <button @click="visible = false">Close</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      visible: false,
      order: {}
    };
  },
  created() {
    this.$root.$on('show-order', (order) => {
      this.order = order;
      this.visible = true;
    });
  }
};
</script>

<style>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
}
</style>