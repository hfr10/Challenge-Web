<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const user = computed(() => authStore.user)
const isEditing = ref(false)

const form = ref({
  name: '',
  email: '',
})

const successMessage = ref('')
const errorMessage = ref('')

onMounted(() => {
  if (user.value) {
    form.value.name = user.value.name
    form.value.email = user.value.email
  }
})

const toggleEdit = () => {
  if (isEditing.value) {
    // Cancel editing
    form.value.name = user.value.name
    form.value.email = user.value.email
  }
  isEditing.value = !isEditing.value
  successMessage.value = ''
  errorMessage.value = ''
}

const updateProfile = async () => {
  successMessage.value = ''
  errorMessage.value = ''

  if (!form.value.name || !form.value.email) {
    errorMessage.value = 'Veuillez remplir tous les champs'
    return
  }

  const result = await authStore.updateProfile(form.value)

  if (result.success) {
    successMessage.value = 'Profil mis à jour avec succès'
    isEditing.value = false
  } else {
    errorMessage.value = result.message || 'Erreur de mise à jour'
  }
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Mon Profil</h1>

      <div class="bg-white rounded-lg shadow-md p-8">
        <!-- Success Message -->
        <div v-if="successMessage" class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
          {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          {{ errorMessage }}
        </div>

        <!-- User Info -->
        <div v-if="!isEditing" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <p class="text-lg text-gray-900">{{ user?.name }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <p class="text-lg text-gray-900">{{ user?.email }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
            <span
              :class="[
                'inline-block px-3 py-1 rounded-full text-sm font-semibold',
                user?.role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'
              ]"
            >
              {{ user?.role === 'admin' ? 'Administrateur' : 'Client' }}
            </span>
          </div>

          <button
            @click="toggleEdit"
            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors"
          >
            Modifier le profil
          </button>
        </div>

        <!-- Edit Form -->
        <form v-else @submit.prevent="updateProfile" class="space-y-6">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
              Nom
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Email
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>

          <div class="flex space-x-4">
            <button
              type="submit"
              :disabled="authStore.loading"
              class="flex-1 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed"
            >
              {{ authStore.loading ? 'Enregistrement...' : 'Enregistrer' }}
            </button>
            <button
              type="button"
              @click="toggleEdit"
              class="flex-1 bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition-colors"
            >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
