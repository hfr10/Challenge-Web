import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'

export const useProductsStore = defineStore('products', () => {
  const products = ref([])
  const currentProduct = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const filters = ref({
    search: '',
    category: '',
    minPrice: null,
    maxPrice: null,
  })

  // Computed
  const filteredProducts = computed(() => {
    let result = [...products.value]

    // Search filter
    if (filters.value.search) {
      const searchLower = filters.value.search.toLowerCase()
      result = result.filter(
        (p) =>
          p.name.toLowerCase().includes(searchLower) ||
          p.description.toLowerCase().includes(searchLower)
      )
    }

    // Category filter
    if (filters.value.category) {
      result = result.filter((p) => p.category === filters.value.category)
    }

    // Price range filter
    if (filters.value.minPrice !== null) {
      result = result.filter((p) => p.price >= filters.value.minPrice)
    }
    if (filters.value.maxPrice !== null) {
      result = result.filter((p) => p.price <= filters.value.maxPrice)
    }

    return result
  })

  const categories = computed(() => {
    const cats = new Set(products.value.map((p) => p.category))
    return Array.from(cats).filter(Boolean)
  })

  // Actions
  const fetchProducts = async () => {
    try {
      loading.value = true
      error.value = null

      const response = await api.get('/products')

      if (response.data.success) {
        products.value = response.data.products || []
      } else {
        error.value = response.data.message || 'Erreur de chargement'
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de chargement des produits'
      console.error('Error fetching products:', err)
    } finally {
      loading.value = false
    }
  }

  const fetchProductById = async (id) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.get(`/products/${id}`)

      if (response.data.success) {
        currentProduct.value = response.data.product
        return response.data.product
      } else {
        error.value = response.data.message || 'Produit introuvable'
        return null
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de chargement du produit'
      console.error('Error fetching product:', err)
      return null
    } finally {
      loading.value = false
    }
  }

  const createProduct = async (productData) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.post('/products', productData)

      if (response.data.success) {
        await fetchProducts() // Refresh list
        return { success: true, product: response.data.product }
      } else {
        error.value = response.data.message || 'Erreur de création'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de création du produit'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  const updateProduct = async (id, productData) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.put(`/products/${id}`, productData)

      if (response.data.success) {
        await fetchProducts() // Refresh list
        return { success: true, product: response.data.product }
      } else {
        error.value = response.data.message || 'Erreur de mise à jour'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de mise à jour du produit'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  const deleteProduct = async (id) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.delete(`/products/${id}`)

      if (response.data.success) {
        await fetchProducts() // Refresh list
        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur de suppression'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de suppression du produit'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  const setFilters = (newFilters) => {
    filters.value = { ...filters.value, ...newFilters }
  }

  const clearFilters = () => {
    filters.value = {
      search: '',
      category: '',
      minPrice: null,
      maxPrice: null,
    }
  }

  return {
    products,
    currentProduct,
    loading,
    error,
    filters,
    filteredProducts,
    categories,
    fetchProducts,
    fetchProductById,
    createProduct,
    updateProduct,
    deleteProduct,
    setFilters,
    clearFilters,
  }
})
