<template>
  <Header></Header>
  <main class="lg:px-96 py-10">
    <router-view></router-view>
  </main>
</template>
<script setup>
import Header from './layout/Header.vue';

</script>
