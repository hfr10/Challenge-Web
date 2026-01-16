import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)
  const loading = ref(false)
  const error = ref(null)

  // Computed
  const isAuthenticated = computed(() => !!token.value)
  const isAdmin = computed(() => user.value?.role === 'admin')

  // Initialize from localStorage
  const initAuth = () => {
    const storedToken = localStorage.getItem('token')
    const storedUser = localStorage.getItem('user')

    if (storedToken && storedUser) {
      token.value = storedToken
      user.value = JSON.parse(storedUser)
    }
  }

  // Login
  const login = async (credentials) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.post('/auth/login', credentials)

      if (response.data.success) {
        token.value = response.data.token
        user.value = response.data.user

        localStorage.setItem('token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))

        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur de connexion'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de connexion'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  // Register
  const register = async (userData) => {
    try {
      loading.value = true
      error.value = null

      // Séparer le nom complet en prénom et nom
      const nameParts = userData.name?.split(' ') || []
      const first_name = nameParts[0] || ''
      const last_name = nameParts.slice(1).join(' ') || ''

      const payload = {
        email: userData.email,
        password: userData.password,
        first_name,
        last_name,
      }

      const response = await api.post('/auth/register', payload)

      if (response.data.success) {
        token.value = response.data.token
        user.value = response.data.user

        localStorage.setItem('token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))

        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur d\'inscription'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur d\'inscription'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  // Logout
  const logout = () => {
    user.value = null
    token.value = null

    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  // Get current user
  const getCurrentUser = async () => {
    try {
      const response = await api.get('/user')
      if (response.data.success) {
        user.value = response.data.user
        localStorage.setItem('user', JSON.stringify(response.data.user))
      }
    } catch (err) {
      console.error('Error fetching user:', err)
    }
  }

  // Update profile
  const updateProfile = async (profileData) => {
    try {
      loading.value = true
      error.value = null

      const response = await api.put('/user/profile', profileData)

      if (response.data.success) {
        user.value = response.data.user
        localStorage.setItem('user', JSON.stringify(response.data.user))
        return { success: true }
      } else {
        error.value = response.data.message || 'Erreur de mise à jour'
        return { success: false, message: error.value }
      }
    } catch (err) {
      error.value = err.response?.data?.message || 'Erreur de mise à jour'
      return { success: false, message: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    isAdmin,
    initAuth,
    login,
    register,
    logout,
    getCurrentUser,
    updateProfile,
  }
})
