<script setup>
import { onMounted, computed } from 'vue'
import { useOrdersStore } from '@/stores/orders'

const ordersStore = useOrdersStore()

const orders = computed(() => ordersStore.orders)

onMounted(async () => {
  await ordersStore.fetchOrders()
})

const getStatusColor = (status) => {
  switch (status) {
    case 'pending':
      return 'bg-yellow-100 text-yellow-800'
    case 'completed':
      return 'bg-green-100 text-green-800'
    case 'cancelled':
      return 'bg-red-100 text-red-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}

const getStatusText = (status) => {
  switch (status) {
    case 'pending':
      return 'En attente'
    case 'completed':
      return 'Complétée'
    case 'cancelled':
      return 'Annulée'
    default:
      return status
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Mes Commandes</h1>

      <!-- Loading State -->
      <div v-if="ordersStore.loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        <p class="mt-4 text-gray-600">Chargement des commandes...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="ordersStore.error" class="text-center py-12">
        <p class="text-red-600 text-lg">{{ ordersStore.error }}</p>
        <button
          @click="ordersStore.fetchOrders()"
          class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors"
        >
          Réessayer
        </button>
      </div>

      <!-- No Orders -->
      <div v-else-if="orders.length === 0" class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Aucune commande</h2>
        <p class="text-gray-600 mb-6">Vous n'avez pas encore passé de commande</p>
        <router-link
          to="/products"
          class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition-colors"
        >
          Voir les produits
        </router-link>
      </div>

      <!-- Orders List -->
      <div v-else class="space-y-6">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white rounded-lg shadow-md p-6"
        >
          <!-- Order Header -->
          <div class="flex justify-between items-start mb-4 pb-4 border-b">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">
                Commande #{{ order.id }}
              </h3>
              <p class="text-sm text-gray-600 mt-1">
                {{ formatDate(order.created_at) }}
              </p>
            </div>
            <span
              :class="getStatusColor(order.status)"
              class="px-3 py-1 rounded-full text-sm font-semibold"
            >
              {{ getStatusText(order.status) }}
            </span>
          </div>

          <!-- Order Items -->
          <div class="space-y-3 mb-4">
            <div
              v-for="item in order.items"
              :key="item.id"
              class="flex justify-between items-center"
            >
              <div class="flex items-center space-x-3">
                <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                  <img
                    v-if="item.product?.image"
                    :src="item.product.image"
                    :alt="item.product.name"
                    class="w-full h-full object-cover"
                  />
                </div>
                <div>
                  <p class="font-medium text-gray-900">
                    {{ item.product?.name || 'Produit' }}
                  </p>
                  <p class="text-sm text-gray-600">
                    Quantité: {{ item.quantity }} × {{ item.price.toFixed(2) }} EUR
                  </p>
                </div>
              </div>
              <p class="font-semibold text-gray-900">
                {{ (item.quantity * item.price).toFixed(2) }} EUR
              </p>
            </div>
          </div>

          <!-- Order Total -->
          <div class="pt-4 border-t flex justify-between items-center">
            <span class="text-lg font-semibold text-gray-900">Total</span>
            <span class="text-2xl font-bold text-indigo-600">
              {{ order.total.toFixed(2) }} EUR
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
