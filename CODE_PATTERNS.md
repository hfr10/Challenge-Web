# 💻 PATTERNS - Comment Modifier le Code

## 🎯 Pattern Frontend Vue.js

### Ajouter une Nouvelle Page
1. Créer un fichier en `frontend/src/views/NomView.vue`
2. Ajouter la route dans `frontend/src/router/index.js`
3. Ajouter le lien dans `frontend/src/components/Navbar.vue`

**Example**:
```vue
<script setup>
import { ref } from 'vue'

const message = ref('Hello')
</script>

<template>
  <div class="container">
    <h1>{{ message }}</h1>
  </div>
</template>
```

---

### Ajouter un Nouveau Endpoint API

Utiliser le store:
```javascript
// frontend/src/stores/mystore.js
import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'

export const useMyStore = defineStore('mystore', () => {
  const data = ref([])
  
  const fetchData = async () => {
    try {
      const response = await api.get('/my-endpoint')
      data.value = response.data.data || []
    } catch (err) {
      console.error('Error:', err)
    }
  }
  
  return { data, fetchData }
})
```

---

## 🎯 Pattern Backend PHP

### Ajouter un Nouvel Endpoint
1. Ouvrir `backend/config/api-routes.php`
2. Ajouter une route:

```php
$router->get('/my-endpoint', function() {
    try {
        // Votre logique
        echo json_encode(['success' => true, 'data' => []]);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
});
```

### Ajouter un Nouvel Contrôleur
1. Créer `backend/src/Controllers/NomController.php`
2. Implémenter les méthodes
3. Appeler depuis les routes

```php
<?php
namespace App\Controllers;

class MonController {
    public function __construct() {
        header('Content-Type: application/json');
    }
    
    public function index(): void {
        echo json_encode(['success' => true, 'data' => []]);
    }
}
```

---

## 🔄 Pattern Requête API

### Dans Vue.js
```javascript
// Faire un appel API
const response = await api.get('/products')
console.log(response.data)

// Avec token automatique (login required)
const response = await api.get('/orders')
```

### Depuis PHP
```php
// Retourner JSON
echo json_encode(['success' => true, 'data' => $data]);

// Erreur
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Erreur']);
```

---

## 📦 Pattern Store Pinia

### Structure Standard
```javascript
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'

export const useMyStore = defineStore('mystore', () => {
  // State
  const items = ref([])
  const loading = ref(false)
  
  // Computed
  const itemCount = computed(() => items.value.length)
  
  // Actions
  const fetchItems = async () => {
    loading.value = true
    try {
      const res = await api.get('/items')
      items.value = res.data.items || []
    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }
  
  const addItem = (item) => {
    items.value.push(item)
  }
  
  return {
    items,
    loading,
    itemCount,
    fetchItems,
    addItem
  }
})
```

---

## 🎨 Pattern Component Vue

### Composant Simple
```vue
<script setup>
import { ref } from 'vue'

const props = defineProps({
  title: String,
  items: Array
})

const emit = defineEmits(['click'])

const handleClick = (item) => {
  emit('click', item)
}
</script>

<template>
  <div class="component">
    <h2>{{ title }}</h2>
    <ul>
      <li v-for="item in items" :key="item.id" @click="handleClick(item)">
        {{ item.name }}
      </li>
    </ul>
  </div>
</template>

<style scoped>
.component {
  padding: 20px;
  border: 1px solid #ccc;
}
</style>
```

---

## 🛣️ Pattern Route Vue Router

### Ajouter une Route
```javascript
// frontend/src/router/index.js
{
  path: '/ma-page',
  name: 'MonPage',
  component: () => import('@/views/MonPageView.vue'),
  meta: {
    requiresAuth: true  // ou guest: true
  }
}
```

### Redirection Conditionnelle
```javascript
router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})
```

---

## 🔐 Pattern Authentification

### Login
```javascript
// Dans le store auth
const login = async (email, password) => {
  const response = await api.post('/auth/login', { email, password })
  
  if (response.data.success) {
    token.value = response.data.token
    user.value = response.data.user
    localStorage.setItem('token', token.value)
    return { success: true }
  }
  
  return { success: false, message: response.data.message }
}
```

### Vérifier Auth
```javascript
// Dans un composant
const authStore = useAuthStore()

const isLoggedIn = computed(() => authStore.isAuthenticated)
```

---

## 📲 Pattern Formulaire

### Formulaire Réactif
```vue
<script setup>
import { ref } from 'vue'

const form = ref({
  email: '',
  password: ''
})

const error = ref('')

const handleSubmit = async () => {
  error.value = ''
  
  if (!form.value.email || !form.value.password) {
    error.value = 'Tous les champs sont requis'
    return
  }
  
  // Soumettre
  const result = await authStore.login(form.value)
  
  if (result.success) {
    router.push('/')
  } else {
    error.value = result.message
  }
}
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <div v-if="error" class="error">{{ error }}</div>
    
    <input v-model="form.email" type="email" placeholder="Email" />
    <input v-model="form.password" type="password" placeholder="Password" />
    
    <button type="submit">Soumettre</button>
  </form>
</template>
```

---

## 🔄 Pattern Liste avec Filtres

### Afficher et Filtrer
```vue
<script setup>
import { computed } from 'vue'
import { useProductsStore } from '@/stores/products'

const store = useProductsStore()

const filteredProducts = computed(() => {
  return store.products.filter(p => 
    p.name.toLowerCase().includes(store.filters.search.toLowerCase())
  )
})
</script>

<template>
  <div>
    <input 
      v-model="store.filters.search" 
      placeholder="Rechercher..."
    />
    
    <div class="products-grid">
      <div v-for="product in filteredProducts" :key="product.id">
        {{ product.name }}
      </div>
    </div>
  </div>
</template>
```

---

## 💾 Pattern Sauvegarde localStorage

### Sauvegarder
```javascript
// Automatique avec Pinia
const data = ref([])

watch(data, (newVal) => {
  localStorage.setItem('mydata', JSON.stringify(newVal))
}, { deep: true })
```

### Charger au Démarrage
```javascript
onMounted(() => {
  const saved = localStorage.getItem('mydata')
  if (saved) {
    data.value = JSON.parse(saved)
  }
})
```

---

## ❌ Patterns À ÉVITER

### ❌ Pas de SQL Injection (PHP)
```php
// MAUVAIS
$sql = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";

// BON
// Utiliser prepared statements ou ORM
```

### ❌ Pas d'Erreurs Sans Gestion
```javascript
// MAUVAIS
const res = await api.get('/data')
console.log(res.data)  // Peut crasher

// BON
try {
  const res = await api.get('/data')
  data.value = res.data
} catch (err) {
  error.value = 'Erreur de chargement'
}
```

### ❌ Pas d'État dans le Global
```javascript
// MAUVAIS
window.myGlobalState = {}

// BON
// Utiliser Pinia store
```

---

## ✅ BONNES PRATIQUES

- ✅ Toujours utiliser `try-catch` pour les API calls
- ✅ Toujours retourner JSON depuis le backend
- ✅ Toujours vérifier `response.data.success`
- ✅ Toujours gérer les erreurs dans les formulaires
- ✅ Toujours mettre à jour le store après une action
- ✅ Toujours rajouter `@submit.prevent` aux forms
- ✅ Toujours vérifier l'authentification avant une requête admin

---

**Bon codage! 💻**
