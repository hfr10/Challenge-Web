import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref([])

  // Computed
  const itemCount = computed(() => {
    return items.value.reduce((total, item) => total + item.quantity, 0)
  })

  const subtotal = computed(() => {
    return items.value.reduce((total, item) => total + item.price * item.quantity, 0)
  })

  const tax = computed(() => {
    return subtotal.value * 0.2 // 20% TVA
  })

  const total = computed(() => {
    return subtotal.value + tax.value
  })

  // Initialize from localStorage
  const initCart = () => {
    const storedCart = localStorage.getItem('cart')
    if (storedCart) {
      try {
        items.value = JSON.parse(storedCart)
      } catch (err) {
        console.error('Error parsing cart from localStorage:', err)
        items.value = []
      }
    }
  }

  // Save to localStorage
  const saveCart = () => {
    localStorage.setItem('cart', JSON.stringify(items.value))
  }

  // Add item to cart
  const addItem = (product, quantity = 1) => {
    const existingItem = items.value.find((item) => item.id === product.id)

    if (existingItem) {
      existingItem.quantity += quantity
    } else {
      items.value.push({
        id: product.id,
        name: product.name,
        price: product.price,
        image: product.image,
        stock: product.stock,
        quantity: quantity,
      })
    }

    saveCart()
  }

  // Remove item from cart
  const removeItem = (productId) => {
    items.value = items.value.filter((item) => item.id !== productId)
    saveCart()
  }

  // Update item quantity
  const updateQuantity = (productId, quantity) => {
    const item = items.value.find((item) => item.id === productId)

    if (item) {
      if (quantity <= 0) {
        removeItem(productId)
      } else if (quantity <= item.stock) {
        item.quantity = quantity
        saveCart()
      } else {
        // Quantity exceeds stock
        item.quantity = item.stock
        saveCart()
      }
    }
  }

  // Increment item quantity
  const incrementQuantity = (productId) => {
    const item = items.value.find((item) => item.id === productId)
    if (item && item.quantity < item.stock) {
      item.quantity++
      saveCart()
    }
  }

  // Decrement item quantity
  const decrementQuantity = (productId) => {
    const item = items.value.find((item) => item.id === productId)
    if (item) {
      if (item.quantity > 1) {
        item.quantity--
        saveCart()
      } else {
        removeItem(productId)
      }
    }
  }

  // Clear cart
  const clearCart = () => {
    items.value = []
    localStorage.removeItem('cart')
  }

  // Check if product is in cart
  const isInCart = (productId) => {
    return items.value.some((item) => item.id === productId)
  }

  // Get item quantity
  const getItemQuantity = (productId) => {
    const item = items.value.find((item) => item.id === productId)
    return item ? item.quantity : 0
  }

  return {
    items,
    itemCount,
    subtotal,
    tax,
    total,
    initCart,
    addItem,
    removeItem,
    updateQuantity,
    incrementQuantity,
    decrementQuantity,
    clearCart,
    isInCart,
    getItemQuantity,
  }
})
