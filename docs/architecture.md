ecommerce-project/
│
├── backend/                          # API PHP
│   ├── public/                       # Point d'entrée web
│   │   └── index.php                 # Front controller
│   │
│   ├── src/
│   │   ├── Controllers/              # Contrôleurs MVC
│   │   │   ├── ProductController.php
│   │   │   ├── UserController.php
│   │   │   ├── OrderController.php
│   │   │   ├── AuthController.php
│   │   │   └── AdminController.php
│   │   │
│   │   ├── Models/                   # Modèles métier (POO)
│   │   │   ├── Product.php
│   │   │   ├── User.php
│   │   │   ├── Order.php
│   │   │   ├── OrderItem.php
│   │   │   └── Category.php
│   │   │
│   │   ├── Core/                     # Classes système
│   │   │   ├── Database.php          # Connexion PDO PostgreSQL
│   │   │   ├── Router.php            # Routeur personnalisé
│   │   │   ├── Request.php           # Gestion des requêtes HTTP
│   │   │   ├── Response.php          # Gestion des réponses JSON
│   │   │   └── Validator.php         # Validation des données
│   │   │
│   │   ├── Repositories/             # Accès base de données
│   │   │   ├── ProductRepository.php
│   │   │   ├── UserRepository.php
│   │   │   └── OrderRepository.php
│   │   │
│   │   ├── Services/                 # Logique métier complexe
│   │   │   ├── AuthService.php       # Authentification
│   │   │   ├── CartService.php       # Gestion panier
│   │   │   └── OrderService.php      # Traitement commandes
│   │   │
│   │   └── Middleware/               # Middlewares
│   │       ├── AuthMiddleware.php
│   │       ├── AdminMiddleware.php
│   │       └── CorsMiddleware.php
│   │
│   ├── config/                       # Configuration
│   │   ├── database.php
│   │   └── routes.php
│   │
│   ├── migrations/                   # Scripts SQL
│   │   ├── 001_create_tables.sql
│   │   └── 002_seed_data.sql
│   │
│   ├── composer.json                 # Dépendances PHP
│   └── .env                          # Variables d'environnement
│
├── frontend/                         # Application Vue.js
│   ├── public/
│   │   └── index.html
│   │
│   ├── src/
│   │   ├── components/               # Composants réutilisables
│   │   │   ├── ProductCard.vue
│   │   │   ├── CartItem.vue
│   │   │   ├── Header.vue
│   │   │   └── Footer.vue
│   │   │
│   │   ├── views/                    # Pages principales
│   │   │   ├── Home.vue
│   │   │   ├── ProductList.vue
│   │   │   ├── ProductDetail.vue
│   │   │   ├── Cart.vue
│   │   │   ├── Checkout.vue
│   │   │   ├── Login.vue
│   │   │   ├── Register.vue
│   │   │   ├── Profile.vue
│   │   │   └── admin/
│   │   │       ├── Dashboard.vue
│   │   │       ├── Products.vue
│   │   │       └── Orders.vue
│   │   │
│   │   ├── router/                   # Vue Router
│   │   │   └── index.js
│   │   │
│   │   ├── store/                    # Vuex/Pinia (state management)
│   │   │   ├── index.js
│   │   │   ├── modules/
│   │   │   │   ├── auth.js
│   │   │   │   ├── cart.js
│   │   │   │   └── products.js
│   │   │
│   │   ├── services/                 # API calls
│   │   │   ├── api.js                # Axios config
│   │   │   ├── productService.js
│   │   │   ├── authService.js
│   │   │   └── orderService.js
│   │   │
│   │   ├── utils/                    # Utilitaires
│   │   │   └── formatters.js
│   │   │
│   │   ├── assets/                   # Styles, images
│   │   │   └── styles/
│   │   │       └── main.css
│   │   │
│   │   ├── App.vue                   # Composant racine
│   │   └── main.js                   # Point d'entrée
│   │
│   ├── package.json                  # Dépendances npm
│   └── vite.config.js                # Config Vite
│
├── docs/                             # Documentation
│   ├── README.md
│   ├── INSTALLATION.md
│   ├── API.md                        # Documentation des endpoints
│   └── architecture.md
│
└── .gitignore

┌─────────────────────────────────────────┐
│         FRONTEND (Vue.js)               │
│  ┌────────────────────────────────┐    │
│  │  Views → Components            │    │
│  │         ↓                       │    │
│  │    Router (Vue Router)         │    │
│  │         ↓                       │    │
│  │    Store (Pinia/Vuex)          │    │
│  │         ↓                       │    │
│  │    Services (Axios)            │    │
│  └────────────────────────────────┘    │
└─────────────────┬───────────────────────┘
                  │ HTTP/JSON (API REST)
                  ↓
┌─────────────────────────────────────────┐
│         BACKEND (PHP POO)               │
│  ┌────────────────────────────────┐    │
│  │    Router → Middleware         │    │
│  │         ↓                       │    │
│  │    Controllers                 │    │
│  │         ↓                       │    │
│  │    Services (logique métier)   │    │
│  │         ↓                       │    │
│  │    Repositories                │    │
│  │         ↓                       │    │
│  │    Models (entités)            │    │
│  └────────────────────────────────┘    │
└─────────────────┬───────────────────────┘
                  │ PDO
                  ↓
┌─────────────────────────────────────────┐
│         PostgreSQL                      │
└─────────────────────────────────────────┘