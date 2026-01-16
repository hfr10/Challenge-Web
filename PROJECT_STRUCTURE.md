# 🏗️ Structure du Projet - Challenge Web

```
Challenge-Web/
│
├── 📄 README.md                    # Documentation du projet
├── 📄 LIRE-MOI.md                  # Guide rapide de démarrage ⭐ LIRE EN PREMIER
├── 📄 STARTUP.md                   # Documentation complète
├── 📄 CORRECTIONS_APPLIQUEES.md    # Résumé des modifications
├── 📄 API_REFERENCE.md             # Documentation complète de l'API
├── 🎯 STATUS.txt                   # Statut du projet
├── 🔄 CHANGELOG.md                 # Historique des changements
│
├── 🚀 start.bat                    # Démarrer (Windows)
├── 🚀 start.sh                     # Démarrer (Linux/Mac)
├── 🚀 start-all.bat                # Démarrer backend + frontend (Windows)
│
├── 📁 backend/                     # Serveur PHP REST API
│   │
│   ├── 📄 composer.json            # Dépendances PHP
│   ├── 📄 migrate.php              # (Non utilisé - démo)
│   ├── 📄 test.php                 # Test script
│   │
│   ├── 📁 public/                  # Racine web
│   │   └── 📄 index.php            # ⭐ Point d'entrée principal
│   │
│   ├── 📁 config/                  # Configuration
│   │   ├── 📄 api-routes.php       # ⭐ Routes API (30+ endpoints)
│   │   ├── 📄 database.php         # Config DB (non utilisé)
│   │   └── 📄 routes.php           # (Ancien)
│   │
│   ├── 📁 src/                     # Code source
│   │   │
│   │   ├── 📁 Controllers/         # Contrôleurs (logique métier)
│   │   │   ├── AuthController.php       # Login/Register
│   │   │   ├── ProductController.php    # 📦 6 produits démo
│   │   │   ├── CartController.php       # Panier
│   │   │   ├── OrderController.php      # Commandes
│   │   │   ├── UserController.php       # Profils
│   │   │   └── AdminController.php      # Admin dashboard
│   │   │
│   │   ├── 📁 Core/                # Classes système
│   │   │   ├── Router.php          # ⭐ Moteur routing custom
│   │   │   ├── Request.php         # Gestion requêtes HTTP
│   │   │   ├── Response.php        # Gestion réponses
│   │   │   ├── Validator.php       # Validation données
│   │   │   └── Database.php        # (Stub - non utilisé)
│   │   │
│   │   ├── 📁 Middleware/          # Middleware HTTP
│   │   │   ├── AuthMiddleware.php       # Vérifier token
│   │   │   ├── AdminMiddleware.php      # Vérifier admin
│   │   │   └── CorsMiddleware.php       # CORS headers
│   │   │
│   │   ├── 📁 Models/              # Modèles de données
│   │   │   ├── User.php
│   │   │   ├── Product.php
│   │   │   ├── Order.php
│   │   │   └── OrderItem.php
│   │   │
│   │   └── 📁 Repositories/        # (Non utilisé - données démo)
│   │       ├── UserRepository.php
│   │       ├── ProductRepository.php
│   │       └── OrderRepository.php
│   │
│   ├── 📁 migrations/              # (Non utilisé - pas de DB)
│   │   ├── 001_create_tables.sql
│   │   └── Database.sql
│   │
│   ├── 📁 vendor/                  # Dépendances Composer
│   │   └── (autoload, etc)
│   │
│   └── .env                        # Variables environnement
│
├── 📁 frontend/                    # Application Vue.js
│   │
│   ├── 📄 package.json             # Dépendances npm
│   ├── 📄 index.html               # ⭐ HTML principal
│   ├── 📄 vite.config.js           # Configuration Vite
│   ├── 📄 jsconfig.json            # Config JavaScript
│   ├── 📄 postcss.config.js        # Config PostCSS
│   ├── 📄 eslint.config.js         # Config Linter
│   │
│   ├── .env                        # ⭐ Variables: VITE_API_URL
│   ├── .env.example                # Exemple .env
│   │
│   ├── 📁 public/                  # Assets statiques
│   │   └── (images, etc)
│   │
│   ├── 📁 src/                     # Code source Vue.js
│   │   │
│   │   ├── 📄 main.js              # ⭐ Point d'entrée (Pinia + Router)
│   │   ├── 📄 App.vue              # ⭐ Composant root (Navbar + RouterView)
│   │   │
│   │   ├── 📁 router/              # Vue Router
│   │   │   └── 📄 index.js         # ⭐ Routes (/, /products, /cart, etc)
│   │   │
│   │   ├── 📁 services/            # Services
│   │   │   └── 📄 api.js           # ⭐ Axios instance avec intercepteurs
│   │   │
│   │   ├── 📁 stores/              # Pinia stores (state mgmt)
│   │   │   ├── 📄 auth.js          # Login/Register/User state
│   │   │   ├── 📄 products.js      # Produits + filters
│   │   │   ├── 📄 cart.js          # Panier items
│   │   │   ├── 📄 orders.js        # Commandes user
│   │   │   └── 📄 counter.js       # (Example)
│   │   │
│   │   ├── 📁 views/               # Pages (route components)
│   │   │   ├── 📄 HomeView.vue           # Accueil
│   │   │   ├── 📄 ProductsView.vue       # Boutique (liste)
│   │   │   ├── 📄 ProductDetailView.vue  # Détail produit
│   │   │   ├── 📄 CartView.vue           # Panier + checkout
│   │   │   ├── 📄 LoginView.vue          # Formulaire login
│   │   │   ├── 📄 RegisterView.vue       # Formulaire register
│   │   │   ├── 📄 OrdersView.vue         # Historique commandes
│   │   │   ├── 📄 ProfileView.vue        # Profil utilisateur
│   │   │   └── 📄 AdminView.vue          # Dashboard admin
│   │   │
│   │   ├── 📁 components/          # Composants réutilisables
│   │   │   ├── 📄 Navbar.vue            # Navigation bar
│   │   │   └── 📄 ProductCard.vue       # Carte produit
│   │   │
│   │   ├── 📁 assets/              # Assets CSS/images
│   │   │   └── 📄 main.css              # Styles Tailwind
│   │   │
│   │   └── 📄 App.vue              # Root component
│   │
│   └── 📁 node_modules/            # Dépendances npm
│
├── 📁 docs/                        # Documentation
│   ├── README.md
│   ├── API.md                      # Ancienne doc API
│   ├── INSTALLATION.md
│   ├── architecture.md
│
└── 📁 .vscode/                     # Configuration VS Code
    └── (settings)
```

---

## 🗂️ Fichiers Clés Expliqués

### Backend

#### `backend/public/index.php` ⭐⭐⭐
- **Point d'entrée** de toute l'application
- Charge les variables d'environnement
- Configure les headers CORS
- Charge les routes API
- Dispatch les requêtes HTTP

#### `backend/config/api-routes.php` ⭐⭐
- Définit tous les **30+ endpoints** de l'API
- Chaque route utilise un contrôleur
- Toutes les réponses sont en JSON
- Gestion des erreurs avec try-catch

#### `backend/src/Core/Router.php` ⭐⭐
- **Moteur de routing custom** (sans framework)
- Méthodes: `get()`, `post()`, `put()`, `delete()`, `dispatch()`
- Distingue les routes API des routes frontend

#### `backend/src/Controllers/*.php`
- Contiennent la **logique métier**
- **Données statiques** (pas de DB requise)
- Retournent JSON avec `success: true/false`

---

### Frontend

#### `frontend/src/main.js` ⭐⭐⭐
- Crée l'instance Vue
- Initialise Pinia (state management)
- Initialise Vue Router
- Monte l'app sur `#app`

#### `frontend/index.html` ⭐⭐⭐
- Fichier HTML principal
- Contient `<div id="app"></div>`
- Charge `src/main.js`

#### `frontend/src/App.vue` ⭐⭐
- **Composant root** de l'application
- Contient la Navbar
- Affiche `<RouterView>` pour les pages

#### `frontend/src/router/index.js` ⭐⭐
- Définit les **9 routes** principales
- Chaque route pointe à une vue
- Gère les redirects d'authentification

#### `frontend/src/services/api.js` ⭐⭐
- Instance **Axios** préconfigurée
- Ajoute automatiquement le token au headers
- Redirige 401 vers `/login`

#### `frontend/src/stores/*.js` (Pinia) ⭐⭐
- **State management** centralisé
- Chaque store gère un domaine:
  - `auth.js` - Utilisateur + authentification
  - `products.js` - Catalogue produits
  - `cart.js` - Articles du panier
  - `orders.js` - Historique commandes

#### `frontend/src/views/*.vue`
- **Pages** de l'application (9 total)
- Chaque vue utilise les stores Pinia
- Affiche les données et gère les interactions

#### `frontend/src/components/*.vue`
- **Composants réutilisables**
- Navbar, ProductCard, etc.
- Utilisés par les vues

---

## 🔄 Flux de Données

```
Utilisateur interagit
       ↓
Vue.js Component
       ↓
Pinia Store (state management)
       ↓
Axios API Service
       ↓
HTTP Request → Backend
       ↓
PHP Router
       ↓
Contrôleur
       ↓
JSON Response
       ↓
Axios Interceptor
       ↓
Pinia Store (update)
       ↓
Vue Component (re-render)
       ↓
Utilisateur voit le résultat
```

---

## 📊 Dépendances

### Backend
- **PHP 8.0+** (Core language)
- **Vlucas/DotEnv** (Environment variables) - optionnel
- **Graham Campbell/Result** (optionnel)
- Pas de dépendances critiques

### Frontend
- **Vue 3** - Framework UI
- **Vue Router** - Routing SPA
- **Pinia** - State management
- **Axios** - HTTP client
- **Tailwind CSS** - Styling
- **Vite** - Build tool

---

## 🎯 Points d'Entrée

### Pour les Développeurs
1. Lire **LIRE-MOI.md** (guide rapide)
2. Lancer `start-all.bat`
3. Aller sur http://localhost:5173
4. Modifier les fichiers Vue/JS et rafraîchir

### Pour les API Consumers
1. Lancer le backend: `php -S localhost:8000 -t public`
2. Consulter **API_REFERENCE.md**
3. Utiliser cURL/Postman pour tester les endpoints

### Pour les DevOps
1. Backend = Simple serveur PHP (peut tourner n'importe où)
2. Frontend = SPA statique (CDN friendly)
3. Aucune base de données requise pour démarrer

---

## 💾 Fichiers à Ignorer en Production

- `📁 backend/migrations/` - Non utilisé (pas de DB)
- `📁 backend/src/Repositories/` - Non utilisé (pas de DB)
- `📁 vendor/` - Dépendances (générées par composer)
- `📁 node_modules/` - Dépendances (générées par npm)
- `.env` - Variables sensibles
- `.vscode/` - Config IDE personnelle

---

## 🔒 Fichiers Sensibles

- `📄 .env` - Variables d'environnement (clés secrètes)
- `📄 backend/.env` - Config base de données
- `📄 frontend/.env` - Secrets frontend

→ **Ne jamais committer ces fichiers!**

---

**Besoin d'aide? Consulte LIRE-MOI.md! 🚀**
