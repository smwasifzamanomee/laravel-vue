<template>
    <div class="container">
      <div>About</div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">SL No.</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in products" :key="item.id">
            <td scope="row">{{ index + 1 }}</td>
            <td scope="row">{{ item.id }}</td>
            <td scope="row">{{ item.name }}</td>
            <td scope="row">{{ item.description }}</td>
          </tr>
        </tbody>    
      </table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
    products: {
      type: Array,
      required: true
    }
    },
    mounted() {
        console.log('Component mounted.', this.products);
    }
  }
  </script>
  