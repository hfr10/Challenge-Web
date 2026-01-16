<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import { useCartStore } from '@/stores/cart'

const route = useRoute()
const router = useRouter()
const productsStore = useProductsStore()
const cartStore = useCartStore()

const quantity = ref(1)
const product = computed(() => productsStore.currentProduct)
const inStock = computed(() => product.value && product.value.stock > 0)

onMounted(async () => {
  await productsStore.fetchProductById(route.params.id)
})

const incrementQuantity = () => {
  if (quantity.value < product.value.stock) {
    quantity.value++
  }
}

const decrementQuantity = () => {
  if (quantity.value > 1) {
    quantity.value--
  }
}

const addToCart = () => {
  if (product.value && inStock.value) {
    cartStore.addItem(product.value, quantity.value)
    router.push('/cart')
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Loading State -->
      <div v-if="productsStore.loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        <p class="mt-4 text-gray-600">Chargement du produit...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="productsStore.error" class="text-center py-12">
        <p class="text-red-600 text-lg">{{ productsStore.error }}</p>
        <button
          @click="router.push('/products')"
          class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors"
        >
          Retour aux produits
        </button>
      </div>

      <!-- Product Details -->
      <div v-else-if="product" class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
          <!-- Product Image -->
          <div>
            <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
              <img
                v-if="product.image"
                :src="product.image"
                :alt="product.name"
                class="w-full h-full object-cover"
              />
              <div v-else class="flex items-center justify-center h-96">
                <svg class="h-32 w-32 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
          </div>

          <!-- Product Info -->
          <div class="flex flex-col">
            <div class="mb-4">
              <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ product.name }}</h1>
              <p v-if="product.category" class="text-sm text-gray-500">
                Catégorie: {{ product.category }}
              </p>
            </div>

            <div class="mb-6">
              <div class="flex items-baseline">
                <span class="text-4xl font-bold text-indigo-600">
                  {{ product.price.toFixed(2) }}
                </span>
                <span class="text-gray-600 ml-2">EUR</span>
              </div>
            </div>

            <div class="mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-2">Description</h2>
              <p class="text-gray-700 leading-relaxed">{{ product.description }}</p>
            </div>

            <div class="mb-6">
              <div class="flex items-center">
                <span class="text-gray-700 font-medium mr-2">Stock:</span>
                <span :class="inStock ? 'text-green-600' : 'text-red-600'" class="font-semibold">
                  {{ inStock ? `${product.stock} unités disponibles` : 'Rupture de stock' }}
                </span>
              </div>
            </div>

            <!-- Quantity Selector -->
            <div v-if="inStock" class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
              <div class="flex items-center space-x-4">
                <button
                  @click="decrementQuantity"
                  class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors"
                >
                  -
                </button>
                <span class="text-xl font-semibold">{{ quantity }}</span>
                <button
                  @click="incrementQuantity"
                  class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors"
                >
                  +
                </button>
              </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="flex space-x-4 mt-auto">
              <button
                @click="addToCart"
                :disabled="!inStock"
                :class="[
                  'flex-1 py-3 rounded-md font-semibold transition-colors',
                  inStock
                    ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                    : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                ]"
              >
                {{ inStock ? 'Ajouter au panier' : 'Indisponible' }}
              </button>

              <button
                @click="router.push('/products')"
                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors font-semibold"
              >
                Retour
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
