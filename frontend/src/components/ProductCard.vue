<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const router = useRouter()
const cartStore = useCartStore()

const isInCart = computed(() => cartStore.isInCart(props.product.id))
const inStock = computed(() => props.product.stock > 0)

const addToCart = () => {
  if (inStock.value) {
    cartStore.addItem(props.product)
  }
}

const goToDetail = () => {
  router.push(`/products/${props.product.id}`)
}
</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <!-- Product Image -->
    <div class="relative h-48 bg-gray-200 cursor-pointer" @click="goToDetail">
      <img
        v-if="product.image"
        :src="product.image"
        :alt="product.name"
        class="w-full h-full object-cover"
      />
      <div v-else class="flex items-center justify-center h-full">
        <svg class="h-20 w-20 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
          <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>

      <!-- Out of stock badge -->
      <div
        v-if="!inStock"
        class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold"
      >
        Rupture de stock
      </div>
    </div>

    <!-- Product Info -->
    <div class="p-4">
      <h3
        class="text-lg font-semibold text-gray-900 mb-2 cursor-pointer hover:text-indigo-600 transition-colors"
        @click="goToDetail"
      >
        {{ product.name }}
      </h3>

      <p class="text-gray-600 text-sm mb-4 line-clamp-2">
        {{ product.description }}
      </p>

      <div class="flex items-center justify-between">
        <div>
          <span class="text-2xl font-bold text-indigo-600">
            {{ product.price.toFixed(2) }}
          </span>
          <span class="text-gray-600 ml-1">EUR</span>
        </div>

        <button
          @click="addToCart"
          :disabled="!inStock"
          :class="[
            'px-4 py-2 rounded-md text-sm font-medium transition-colors',
            inStock
              ? isInCart
                ? 'bg-green-500 text-white hover:bg-green-600'
                : 'bg-indigo-600 text-white hover:bg-indigo-700'
              : 'bg-gray-300 text-gray-500 cursor-not-allowed'
          ]"
        >
          {{ !inStock ? 'Indisponible' : isInCart ? 'Dans le panier' : 'Ajouter au panier' }}
        </button>
      </div>

      <!-- Stock indicator -->
      <div v-if="inStock" class="mt-2 text-xs text-gray-500">
        Stock: {{ product.stock }} unités
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
