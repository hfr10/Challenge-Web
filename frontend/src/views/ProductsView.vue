<script setup>
import { onMounted, computed } from 'vue'
import { useProductsStore } from '@/stores/products'
import ProductCard from '@/components/ProductCard.vue'

const productsStore = useProductsStore()

const filteredProducts = computed(() => productsStore.filteredProducts)
const categories = computed(() => productsStore.categories)

onMounted(async () => {
  await productsStore.fetchProducts()
})

const updateSearch = (event) => {
  productsStore.setFilters({ search: event.target.value })
}

const updateCategory = (event) => {
  productsStore.setFilters({ category: event.target.value })
}

const clearFilters = () => {
  productsStore.clearFilters()
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Nos Produits</h1>
        <p class="text-gray-600">Découvrez notre catalogue complet</p>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Search -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Rechercher
            </label>
            <input
              type="text"
              :value="productsStore.filters.search"
              @input="updateSearch"
              placeholder="Nom ou description..."
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <!-- Category -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Catégorie
            </label>
            <select
              :value="productsStore.filters.category"
              @change="updateCategory"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">Toutes les catégories</option>
              <option v-for="category in categories" :key="category" :value="category">
                {{ category }}
              </option>
            </select>
          </div>

          <!-- Clear Filters -->
          <div class="flex items-end">
            <button
              @click="clearFilters"
              class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors"
            >
              Réinitialiser les filtres
            </button>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="productsStore.loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        <p class="mt-4 text-gray-600">Chargement des produits...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="productsStore.error" class="text-center py-12">
        <p class="text-red-600 text-lg">{{ productsStore.error }}</p>
        <button
          @click="productsStore.fetchProducts()"
          class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors"
        >
          Réessayer
        </button>
      </div>

      <!-- Products Grid -->
      <div v-else-if="filteredProducts.length > 0">
        <div class="mb-4 text-gray-600">
          {{ filteredProducts.length }} produit(s) trouvé(s)
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <ProductCard
            v-for="product in filteredProducts"
            :key="product.id"
            :product="product"
          />
        </div>
      </div>

      <!-- No Products -->
      <div v-else class="text-center py-12">
        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <p class="mt-4 text-gray-600 text-lg">Aucun produit trouvé</p>
        <button
          @click="clearFilters"
          class="mt-4 text-indigo-600 hover:text-indigo-700 font-medium"
        >
          Réinitialiser les filtres
        </button>
      </div>
    </div>
  </div>
</template>
