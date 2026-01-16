<script setup>
import { onMounted } from 'vue'
import { RouterView } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'

const authStore = useAuthStore()
const cartStore = useCartStore()

onMounted(() => {
  // Initialize auth and cart from localStorage
  authStore.initAuth()
  cartStore.initCart()
})
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar />
    <RouterView />
  </div>
</template>

<style scoped>
</style>