# 🚀 Lancement du projet

## Backend (PHP)

```bash
cd backend
php -S localhost:8000 -t public
```

L'API sera disponible sur: **http://localhost:8000**

## Frontend (Vue.js)

```bash
cd frontend
npm install  # Si vous n'avez pas encore installé les dépendances
npm run dev
```

Le site sera disponible sur: **http://localhost:5173**

## Fonctionnalités disponibles

✅ **Accueil** - Page d'accueil avec produits en vedette
✅ **Boutique** - Tous les produits avec filtres
✅ **Détail produit** - Voir les informations complètes d'un produit
✅ **Panier** - Ajouter/supprimer des produits
✅ **Authentification** - Inscription/Connexion/Déconnexion
✅ **Profil** - Voir et modifier le profil utilisateur
✅ **Commandes** - Voir l'historique des commandes
✅ **Admin** - Dashboard administrateur

## Routes API disponibles

- `GET /` - Accueil API
- `GET /test` - Test simple
- `GET /products` - Tous les produits
- `GET /products/{id}` - Détail d'un produit
- `POST /auth/register` - Inscription
- `POST /auth/login` - Connexion
- `GET /cart` - Panier
- `POST /cart/add` - Ajouter au panier
- `GET /orders` - Commandes
- `GET /users/{id}` - Profil utilisateur
- `GET /admin/*` - Routes admin

Tous les détails dans la documentation API: `/docs/API.md`
