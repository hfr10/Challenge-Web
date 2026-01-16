import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'
import { useCartStore } from './cart'

export const useOrdersStore = defineStore('orders', () => {
  const orders = ref([])
  const currentOrder = ref(null)
  const loading = ref(false)
  const error = ref(null)

  // Computed
  const orderCount = computed(() => orders.value.length)

  const pendingOrders = computed(() => {
    return orders.value.filter((order) => order.status === 'pending')
  })

  const completedOrders = computed(() => {
    return orders.value.filter((order) => order.status === 'completed')
  })

  // Actions
  const fetchOrders = async () => {
    try {
      loading.value = true
      error.value = null

      const response = await api.get('/orders')

      if (response.data.success) {
        orders.value = response.data.orders || []
      } else {
        error.value = response.data.message || 'Erreur de chargement'
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de chargement des commandes'
      console.error('Error fetching orders:', err)
    } finally {
      loading.value = false
    }
  }

  const fetchOrderById = async (id) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.get(`/orders/${id}`)

      if (response.data.success) {
        currentOrder.value = response.data.order
        return response.data.order
      } else {
        error.value = response.data.message || 'Commande introuvable'
        return null
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de chargement de la commande'
      console.error('Error fetching order:', err)
      return null
    } finally {
      loading.value = false
    }
  }

  const createOrder = async (orderData) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.post('/orders', orderData)

      if (response.data.success) {
        const cartStore = useCartStore()
        cartStore.clearCart() // Clear cart after successful order

        await fetchOrders() // Refresh orders list

        return { success: true, order: response.data.order }
      } else {
        error.value = response.data.message || 'Erreur de création de commande'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de création de commande'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  const updateOrderStatus = async (id, status) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.put(`/orders/${id}/status`, { status })

      if (response.data.success) {
        await fetchOrders() // Refresh orders list
        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur de mise à jour'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de mise à jour de la commande'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  const cancelOrder = async (id) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.delete(`/orders/${id}`)

      if (response.data.success) {
        await fetchOrders() // Refresh orders list
        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur d\'annulation'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur d\'annulation de la commande'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    orders,
    currentOrder,
    loading,
    error,
    orderCount,
    pendingOrders,
    completedOrders,
    fetchOrders,
    fetchOrderById,
    createOrder,
    updateOrderStatus,
    cancelOrder,
  }
})
