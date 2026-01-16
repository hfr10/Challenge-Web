<script setup>
import { ref, onMounted, computed } from 'vue'
import { useProductsStore } from '@/stores/products'
import { useOrdersStore } from '@/stores/orders'

const productsStore = useProductsStore()
const ordersStore = useOrdersStore()

const activeTab = ref('products')
const showProductForm = ref(false)
const editingProduct = ref(null)

const productForm = ref({
  name: '',
  description: '',
  price: 0,
  stock: 0,
  category: '',
  image: '',
})

const products = computed(() => productsStore.products)
const orders = computed(() => ordersStore.orders)

onMounted(async () => {
  await Promise.all([
    productsStore.fetchProducts(),
    ordersStore.fetchOrders()
  ])
})

// Product Management
const openProductForm = (product = null) => {
  if (product) {
    editingProduct.value = product
    productForm.value = { ...product }
  } else {
    editingProduct.value = null
    productForm.value = {
      name: '',
      description: '',
      price: 0,
      stock: 0,
      category: '',
      image: '',
    }
  }
  showProductForm.value = true
}

const closeProductForm = () => {
  showProductForm.value = false
  editingProduct.value = null
}

const saveProduct = async () => {
  if (editingProduct.value) {
    await productsStore.updateProduct(editingProduct.value.id, productForm.value)
  } else {
    await productsStore.createProduct(productForm.value)
  }
  closeProductForm()
}

const deleteProduct = async (id) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce produit?')) {
    await productsStore.deleteProduct(id)
  }
}

// Order Management
const updateOrderStatus = async (orderId, status) => {
  await ordersStore.updateOrderStatus(orderId, status)
}

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
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Administration</h1>

      <!-- Tabs -->
      <div class="mb-8 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
          <button
            @click="activeTab = 'products'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'products'
                ? 'border-indigo-500 text-indigo-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Produits
          </button>
          <button
            @click="activeTab = 'orders'"
            :class="[
              'py-4 px-1 border-b-2 font-medium text-sm',
              activeTab === 'orders'
                ? 'border-indigo-500 text-indigo-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
            ]"
          >
            Commandes
          </button>
        </nav>
      </div>

      <!-- Products Tab -->
      <div v-if="activeTab === 'products'">
        <div class="mb-6 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-900">Gestion des produits</h2>
          <button
            @click="openProductForm()"
            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors"
          >
            Ajouter un produit
          </button>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="product in products" :key="product.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ product.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.category }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.price.toFixed(2) }} EUR</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ product.stock }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <button
                    @click="openProductForm(product)"
                    class="text-indigo-600 hover:text-indigo-900"
                  >
                    Modifier
                  </button>
                  <button
                    @click="deleteProduct(product.id)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Supprimer
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Orders Tab -->
      <div v-if="activeTab === 'orders'">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Gestion des commandes</h2>

        <div class="space-y-4">
          <div
            v-for="order in orders"
            :key="order.id"
            class="bg-white rounded-lg shadow-md p-6"
          >
            <div class="flex justify-between items-start mb-4">
              <div>
                <h3 class="text-lg font-semibold">Commande #{{ order.id }}</h3>
                <p class="text-sm text-gray-600">Client: {{ order.user?.name }}</p>
                <p class="text-sm text-gray-600">Total: {{ order.total.toFixed(2) }} EUR</p>
              </div>
              <div class="flex items-center space-x-2">
                <span :class="getStatusColor(order.status)" class="px-3 py-1 rounded-full text-sm font-semibold">
                  {{ getStatusText(order.status) }}
                </span>
                <select
                  @change="updateOrderStatus(order.id, $event.target.value)"
                  :value="order.status"
                  class="px-3 py-1 border border-gray-300 rounded-md text-sm"
                >
                  <option value="pending">En attente</option>
                  <option value="completed">Complétée</option>
                  <option value="cancelled">Annulée</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Form Modal -->
      <div
        v-if="showProductForm"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-lg shadow-xl p-8 max-w-md w-full">
          <h3 class="text-2xl font-bold mb-6">
            {{ editingProduct ? 'Modifier le produit' : 'Nouveau produit' }}
          </h3>

          <form @submit.prevent="saveProduct" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
              <input
                v-model="productForm.name"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea
                v-model="productForm.description"
                required
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              ></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
              <input
                v-model="productForm.category"
                type="text"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                <input
                  v-model.number="productForm.price"
                  type="number"
                  step="0.01"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                <input
                  v-model.number="productForm.stock"
                  type="number"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md"
                />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">URL Image</label>
              <input
                v-model="productForm.image"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md"
              />
            </div>

            <div class="flex space-x-4 mt-6">
              <button
                type="submit"
                class="flex-1 bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700"
              >
                Enregistrer
              </button>
              <button
                type="button"
                @click="closeProductForm"
                class="flex-1 bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300"
              >
                Annuler
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
