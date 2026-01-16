<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useAuthStore } from '@/stores/auth'
import { useOrdersStore } from '@/stores/orders'

const router = useRouter()
const cartStore = useCartStore()
const authStore = useAuthStore()
const ordersStore = useOrdersStore()

const items = computed(() => cartStore.items)
const subtotal = computed(() => cartStore.subtotal)
const tax = computed(() => cartStore.tax)
const total = computed(() => cartStore.total)
const isEmpty = computed(() => items.value.length === 0)

const removeItem = (productId) => {
  cartStore.removeItem(productId)
}

const incrementQuantity = (productId) => {
  cartStore.incrementQuantity(productId)
}

const decrementQuantity = (productId) => {
  cartStore.decrementQuantity(productId)
}

const proceedToCheckout = async () => {
  if (!authStore.isAuthenticated) {
    router.push('/login?redirect=/cart')
    return
  }

  // Create order
  const orderData = {
    items: items.value.map(item => ({
      product_id: item.id,
      quantity: item.quantity,
      price: item.price
    })),
    total: total.value
  }

  const result = await ordersStore.createOrder(orderData)

  if (result.success) {
    router.push('/orders')
  } else {
    alert(result.message || 'Erreur lors de la création de la commande')
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Panier</h1>

      <!-- Empty Cart -->
      <div v-if="isEmpty" class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Votre panier est vide</h2>
        <p class="text-gray-600 mb-6">Découvrez nos produits et ajoutez-en à votre panier</p>
        <button
          @click="router.push('/products')"
          class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition-colors"
        >
          Voir les produits
        </button>
      </div>

      <!-- Cart Items -->
      <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Items List -->
        <div class="lg:col-span-2 space-y-4">
          <div
            v-for="item in items"
            :key="item.id"
            class="bg-white rounded-lg shadow-md p-6 flex items-center space-x-4"
          >
            <!-- Product Image -->
            <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-lg overflow-hidden">
              <img
                v-if="item.image"
                :src="item.image"
                :alt="item.name"
                class="w-full h-full object-cover"
              />
              <div v-else class="flex items-center justify-center h-full">
                <svg class="h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>

            <!-- Product Info -->
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
              <p class="text-gray-600">{{ item.price.toFixed(2) }} EUR</p>
            </div>

            <!-- Quantity Controls -->
            <div class="flex items-center space-x-3">
              <button
                @click="decrementQuantity(item.id)"
                class="bg-gray-200 text-gray-700 w-8 h-8 rounded-md hover:bg-gray-300 transition-colors"
              >
                -
              </button>
              <span class="font-semibold w-8 text-center">{{ item.quantity }}</span>
              <button
                @click="incrementQuantity(item.id)"
                class="bg-gray-200 text-gray-700 w-8 h-8 rounded-md hover:bg-gray-300 transition-colors"
              >
                +
              </button>
            </div>

            <!-- Subtotal -->
            <div class="text-right">
              <p class="text-lg font-bold text-gray-900">
                {{ (item.price * item.quantity).toFixed(2) }} EUR
              </p>
            </div>

            <!-- Remove Button -->
            <button
              @click="removeItem(item.id)"
              class="text-red-600 hover:text-red-700 transition-colors"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Résumé</h2>

            <div class="space-y-4 mb-6">
              <div class="flex justify-between text-gray-700">
                <span>Sous-total</span>
                <span>{{ subtotal.toFixed(2) }} EUR</span>
              </div>

              <div class="flex justify-between text-gray-700">
                <span>TVA (20%)</span>
                <span>{{ tax.toFixed(2) }} EUR</span>
              </div>

              <div class="border-t pt-4 flex justify-between text-xl font-bold text-gray-900">
                <span>Total</span>
                <span>{{ total.toFixed(2) }} EUR</span>
              </div>
            </div>

            <button
              @click="proceedToCheckout"
              :disabled="ordersStore.loading"
              class="w-full bg-indigo-600 text-white py-3 rounded-md font-semibold hover:bg-indigo-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
            >
              {{ ordersStore.loading ? 'Traitement...' : 'Passer la commande' }}
            </button>

            <button
              @click="router.push('/products')"
              class="w-full mt-3 bg-gray-200 text-gray-700 py-3 rounded-md font-semibold hover:bg-gray-300 transition-colors"
            >
              Continuer mes achats
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
