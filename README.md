# E-Commerce Platform - Groupe 6

Plateforme e-commerce complète avec backend PHP et frontend Vue.js.

## Architecture

```
Challenge-Web/
├── backend/           # API REST en PHP POO
│   ├── config/        # Configuration (database, routes)
│   ├── migrations/    # Scripts SQL de migration
│   ├── public/        # Point d'entrée (index.php)
│   ├── src/
│   │   ├── Core/      # Classes core (Router, Request, Response, Validator, Database)
│   │   ├── Controllers/ # Contrôleurs API
│   │   ├── Services/  # Logique métier
│   │   ├── Repositories/ # Accès aux données
│   │   ├── Models/    # Entités métier
│   │   └── Middleware/ # Middleware (CORS, Auth, Admin)
│   └── vendor/        # Dépendances Composer
│
└── frontend/          # Application Vue.js 3
    ├── src/
    │   ├── components/ # Composants réutilisables
    │   ├── views/      # Pages/Vues
    │   ├── stores/     # Stores Pinia (state management)
    │   ├── router/     # Configuration Vue Router
    │   └── services/   # Services API (axios)
    └── public/         # Assets statiques
```

## Technologies

### Backend
- **PHP 8.1+** - Langage backend
- **PostgreSQL 14+** - Base de données
- **Composer** - Gestionnaire de dépendances
- **PSR-4** - Autoloading
- **DotEnv** - Variables d'environnement

### Frontend
- **Vue.js 3** - Framework JavaScript
- **Pinia** - State management
- **Vue Router** - Routing
- **Axios** - Client HTTP
- **Tailwind CSS** - Framework CSS
- **Vite** - Build tool

## Prérequis

- PHP >= 8.1
- PostgreSQL >= 14
- Composer
- Node.js >= 20.19.0
- npm >= 10

## Installation

### 1. Cloner le projet

```bash
git clone <repository-url>
cd Challenge-Web
```

### 2. Configuration Backend

```bash
cd backend

# Installer les dépendances
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Modifier .env avec vos paramètres PostgreSQL
# DB_HOST=localhost
# DB_PORT=5432
# DB_NAME=ecommerce_db
# DB_USER=postgres
# DB_PASSWORD=votre_mot_de_passe
```

### 3. Créer la base de données

```bash
# Se connecter à PostgreSQL
psql -U postgres

# Créer la base de données
CREATE DATABASE ecommerce_db;

# Quitter psql
\q
```

### 4. Exécuter les migrations

```bash
# Depuis le dossier backend
php migrate.php
```

Cela va créer toutes les tables et insérer des données de test.

### 5. Configuration Frontend

```bash
cd ../frontend

# Installer les dépendances
npm install

# Copier le fichier d'environnement (déjà créé)
# Le fichier .env contient déjà: VITE_API_URL=http://localhost:8000
```

## Démarrage

### Lancer le backend

```bash
cd backend
php -S localhost:8000 -t public
```

L'API sera accessible sur http://localhost:8000

### Lancer le frontend

```bash
cd frontend
npm run dev
```

L'application sera accessible sur http://localhost:5173

## Comptes de test

Après migration, vous aurez accès à ces comptes:

### Administrateur
- **Email:** admin@ecommerce.com
- **Mot de passe:** admin123

### Utilisateurs
- **Email:** john@example.com / **Mot de passe:** password123
- **Email:** jane@example.com / **Mot de passe:** password123

## API Endpoints

### Authentication
```
POST   /auth/register        - Inscription
POST   /auth/login           - Connexion
```

### Products (Public)
```
GET    /products             - Liste des produits
GET    /products/{id}        - Détail d'un produit
```

### Cart
```
GET    /cart                 - Panier actuel
POST   /cart/add             - Ajouter au panier
DELETE /cart/remove/{id}     - Supprimer du panier
PUT    /cart/update/{id}     - Modifier quantité
POST   /cart/clear           - Vider le panier
```

### Orders (Authentifié)
```
POST   /orders               - Créer une commande
GET    /orders               - Mes commandes
GET    /orders/{id}          - Détail d'une commande
PUT    /orders/{id}/status   - Modifier le statut
```

### Users (Authentifié)
```
GET    /users/{id}           - Profil utilisateur
PUT    /users/{id}           - Modifier le profil
DELETE /users/{id}           - Supprimer le compte
```

### Admin (Admin uniquement)
```
GET    /admin/orders         - Toutes les commandes
GET    /admin/users          - Tous les utilisateurs
DELETE /admin/users/{id}     - Supprimer un utilisateur
PUT    /admin/products/{id}  - Modifier un produit
GET    /admin/dashboard      - Statistiques
```

## Fonctionnalités

### Client
- Inscription et connexion
- Navigation des produits avec filtres
- Panier d'achat persistant
- Passage de commande
- Historique des commandes
- Gestion du profil

### Administrateur
- Dashboard avec statistiques
- Gestion des produits (CRUD)
- Gestion des commandes (statuts)
- Gestion des utilisateurs
- Vue d'ensemble des ventes

## Structure de la base de données

### Tables principales
- **users** - Utilisateurs (clients et admins)
- **categories** - Catégories de produits
- **products** - Produits avec prix, stock, images
- **orders** - Commandes clients
- **order_items** - Articles des commandes

## Développement

### Backend

#### Créer un nouveau contrôleur
```php
<?php
namespace App\Controllers;

use App\Core\Response;

class MonController
{
    public function index(): void
    {
        Response::json(['message' => 'Hello World']);
    }
}
```

#### Ajouter une route
```php
// Dans backend/public/index.php
$router->get('/mon-endpoint', [$monController, 'index']);
```

### Frontend

#### Créer un nouveau composant
```vue
<template>
  <div>Mon Composant</div>
</template>

<script setup>
// Logic here
</script>
```

#### Utiliser un store
```javascript
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
authStore.login(email, password)
```

## Scripts disponibles

### Backend
```bash
composer install          # Installer les dépendances
php migrate.php          # Exécuter les migrations
php -S localhost:8000    # Démarrer le serveur
```

### Frontend
```bash
npm install              # Installer les dépendances
npm run dev              # Démarrer en mode développement
npm run build            # Build pour production
npm run preview          # Preview du build
npm run lint             # Linter le code
```

## Sécurité

- Mots de passe hashés avec `password_hash()`
- Validation des entrées côté serveur
- Protection CSRF
- Headers CORS configurés
- Authentication JWT (à implémenter)
- Middleware d'authentification et d'autorisation

## Améliorations futures

- [ ] Implémentation JWT pour l'authentification
- [ ] Upload d'images pour les produits
- [ ] Pagination des listes
- [ ] Système de recherche avancée
- [ ] Notifications en temps réel
- [ ] Export des commandes (PDF, Excel)
- [ ] Statistiques avancées pour admins
- [ ] Tests unitaires et d'intégration
- [ ] Docker compose pour déploiement
- [ ] CI/CD pipeline

## Contribution

1. Créer une branche pour votre fonctionnalité
2. Committer vos changements
3. Pousser vers la branche
4. Créer une Pull Request

## Licence

Projet éducatif - Groupe 6

## Support

Pour toute question ou problème:
- Ouvrir une issue sur GitHub
- Contacter l'équipe de développement

---

Développé avec ❤️ par Groupe 6
