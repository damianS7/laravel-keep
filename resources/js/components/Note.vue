<template>
  <div class="col-sm-3">
    <div class="card text-white mb-3" :class="'bg-primary'" style="max-width: 20rem;">
      <div class="card-header">{{ title }}</div>
      <div class="card-body">
        <h4 class="card-title">{{ title }}</h4>
        <p class="card-text">{{ body }}</p>
      </div>
    </div>
  </div>
</template>
<script>
// Implementar cambio de color
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    body: {
      type: String,
      required: true
    }
  },
  mounted() {
    console.log("Component Note mounted.");
  }
};
</script>
