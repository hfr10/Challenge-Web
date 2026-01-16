<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'

const router = useRouter()
const authStore = useAuthStore()
const cartStore = useCartStore()

const isAuthenticated = computed(() => authStore.isAuthenticated)
const user = computed(() => authStore.user)
const cartItemCount = computed(() => cartStore.itemCount)

const handleLogout = () => {
  authStore.logout()
  router.push('/login')
}
</script>

<template>
  <nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex">
          <!-- Logo -->
          <router-link to="/" class="flex items-center">
            <span class="text-2xl font-bold text-indigo-600">E-Shop</span>
          </router-link>

          <!-- Navigation Links -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <router-link
              to="/"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-colors"
              active-class="border-indigo-500"
            >
              Accueil
            </router-link>
            <router-link
              to="/products"
              class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900 border-b-2 border-transparent hover:border-indigo-500 transition-colors"
              active-class="border-indigo-500"
            >
              Produits
            </router-link>
          </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center space-x-4">
          <!-- Cart -->
          <router-link
            to="/cart"
            class="relative p-2 text-gray-700 hover:text-indigo-600 transition-colors"
          >
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>
            <span
              v-if="cartItemCount > 0"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
            >
              {{ cartItemCount }}
            </span>
          </router-link>

          <!-- User Menu -->
          <div v-if="isAuthenticated" class="flex items-center space-x-4">
            <router-link
              to="/orders"
              class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
              Mes commandes
            </router-link>
            <router-link
              to="/profile"
              class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
              Profil
            </router-link>
            <router-link
              v-if="authStore.isAdmin"
              to="/admin"
              class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
              Admin
            </router-link>
            <button
              @click="handleLogout"
              class="text-sm font-medium text-gray-700 hover:text-red-600 transition-colors"
            >
              Déconnexion
            </button>
          </div>

          <!-- Guest Links -->
          <div v-else class="flex items-center space-x-4">
            <router-link
              to="/login"
              class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors"
            >
              Connexion
            </router-link>
            <router-link
              to="/register"
              class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors"
            >
              Inscription
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
