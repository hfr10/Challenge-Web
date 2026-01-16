<script setup>
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import ProductCard from '@/components/ProductCard.vue'

const router = useRouter()
const productsStore = useProductsStore()

onMounted(async () => {
  await productsStore.fetchProducts()
})

const goToProducts = () => {
  router.push('/products')
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl font-bold mb-4">Bienvenue sur E-Shop</h1>
          <p class="text-xl mb-8">
            Découvrez nos produits de qualité à des prix imbattables
          </p>
          <button
            @click="goToProducts"
            class="bg-white text-indigo-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors"
          >
            Voir tous les produits
          </button>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Produits en vedette</h2>
        <p class="text-gray-600">Découvrez notre sélection de produits populaires</p>
      </div>

      <div v-if="productsStore.loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        <p class="mt-4 text-gray-600">Chargement des produits...</p>
      </div>

      <div v-else-if="productsStore.error" class="text-center py-12">
        <p class="text-red-600">{{ productsStore.error }}</p>
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <ProductCard
          v-for="product in productsStore.products.slice(0, 4)"
          :key="product.id"
          :product="product"
        />
      </div>

      <div v-if="productsStore.products.length > 4" class="text-center mt-12">
        <button
          @click="goToProducts"
          class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors"
        >
          Voir tous les produits
        </button>
      </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="flex justify-center mb-4">
              <svg class="h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Qualité garantie</h3>
            <p class="text-gray-600">Tous nos produits sont soigneusement sélectionnés</p>
          </div>

          <div class="text-center">
            <div class="flex justify-center mb-4">
              <svg class="h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Livraison rapide</h3>
            <p class="text-gray-600">Recevez vos commandes sous 48-72h</p>
          </div>

          <div class="text-center">
            <div class="flex justify-center mb-4">
              <svg class="h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Paiement sécurisé</h3>
            <p class="text-gray-600">Vos transactions sont 100% sécurisées</p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
