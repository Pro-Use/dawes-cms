<template>
    <section class="k-cache-control-section">
    <header class="k-section-header">
      <h2 class="k-headline">{{ label }}</h2>
    </header>
    <k-button 
        class="deploy-btn" size="xlg" variant="filled" 
        :icon="icon" :disabled="refreshing" @click="refresh()"
    >
        Refresh Cache
    </k-button>
  </section>

</template>

<script>
export default {
  data() {
    return {
        label: null,
        icon: 'refresh',
        refreshing: false,
        refreshed: false,
    }
  },
  created() {
    this.load().then(response => {
      this.label  = response.label;
    });
  },
  methods: {
    async refresh(){
        this.refreshing = true
        this.icon = "loader"
        const res = await this.$api.get('/refresh-cache')
        console.log(res)
        this.refreshing = false
        this.icon = "refresh"
    }
  }
};
</script>
<style scoped>
.deploy-btn {
  padding: 14px;
  background: var(--color-white);
  border-radius: var(--rounded);
  box-shadow: var(--shadow);
}
</style>