# 🚀 Guide de Démarrage - Challenge-Web E-Commerce

## Configuration Rapide

### 1️⃣ Démarrer le Backend (PHP)
```bash
cd backend
php -S localhost:8000 -t public
```
✅ Le serveur écoute sur: **http://localhost:8000**

### 2️⃣ Démarrer le Frontend (Vue.js)
```bash
cd frontend
npm install  # première fois seulement
npm run dev
```
✅ Le serveur écoute sur: **http://localhost:5173**

---

## 📋 Accès à l'Application

- **Interface Web**: http://localhost:5173
- **API Backend**: http://localhost:8000

### Routes Disponibles

#### Frontend (Navigation SPA)
- `/` - **Accueil** (Hero + produits à la une)
- `/products` - **Boutique** (Tous les produits avec filtres)
- `/products/:id` - **Détail Produit** (Voir un produit spécifique)
- `/cart` - **Panier** (Voir le panier et passer la commande)
- `/login` - **Connexion** (Email & mot de passe)
- `/register` - **Inscription** (Créer un compte)
- `/orders` - **Mes Commandes** (Historique des commandes)
- `/profile` - **Mon Profil** (Gérer le profil utilisateur)
- `/admin` - **Admin Dashboard** (Gérer produits & commandes)

#### API REST Backend
- `GET /` - Welcome message
- `GET /test` - Test endpoint

**Produits**
- `GET /products` - Tous les produits
- `GET /products/{id}` - Détail produit
- `POST /products` - Créer produit
- `PUT /products/{id}` - Mettre à jour produit
- `DELETE /products/{id}` - Supprimer produit

**Authentification**
- `POST /auth/register` - S'inscrire
- `POST /auth/login` - Se connecter
- `POST /auth/logout` - Se déconnecter
- `POST /auth/refresh` - Rafraîchir token

**Panier & Commandes**
- `GET /cart` - Récupérer panier
- `POST /cart/add` - Ajouter au panier
- `GET /orders` - Mes commandes
- `POST /orders` - Créer commande
- `GET /users/profile` - Profil utilisateur

---

## 🔐 Compte de Test

```
Email: test@example.com
Mot de passe: password123
```

---

## 📦 Produits de Démonstration

1. **Laptop Pro** - 1299.99€ (Electronics)
2. **Wireless Mouse** - 29.99€ (Accessories)
3. **Mechanical Keyboard** - 129.99€ (Accessories)
4. **USB-C Cable** - 9.99€ (Cables)
5. **Monitor 4K** - 499.99€ (Electronics)
6. **Webcam HD** - 79.99€ (Accessories)

---

## 🛠️ Architecture

### Backend (PHP Custom Framework)
- **Fichier d'entrée**: `backend/public/index.php`
- **Router**: `backend/src/Core/Router.php` (Custom routing engine)
- **Routes**: `backend/config/api-routes.php` (Toutes les routes API)
- **Contrôleurs**: `backend/src/Controllers/` (Demo data, pas de DB requise)
- **Stockage**: Données statiques dans les contrôleurs (pour démo)

### Frontend (Vue.js 3 + Vite)
- **Framework**: Vue 3 Composition API
- **Build Tool**: Vite
- **State Management**: Pinia
- **HTTP Client**: Axios
- **Routing**: Vue Router
- **Styling**: Tailwind CSS

---

## ⚙️ Configuration

### Variables d'Environnement Frontend
```env
VITE_API_URL=http://localhost:8000
```

### Variables d'Environnement Backend
```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=challenge_web
DB_USER=postgres
DB_PASSWORD=password
```

---

## 🧪 Tester l'Application

### Scenario 1️⃣: Consulter les produits
1. Allez sur http://localhost:5173
2. Cliquez sur "Produits" dans la navbar
3. Vous devriez voir 6 produits de démonstration

### Scenario 2️⃣: S'inscrire et se connecter
1. Cliquez sur "Inscription" (ou utilisez le compte test)
2. Remplissez le formulaire
3. Ou connectez-vous avec test@example.com / password123

### Scenario 3️⃣: Ajouter au panier et commander
1. Sur la page des produits, cliquez sur un produit
2. Cliquez "Ajouter au panier"
3. Allez sur "Panier" et finalisez la commande

### Scenario 4️⃣: Admin Dashboard
1. Connectez-vous avec test@example.com
2. Allez sur "Admin" (en bas à droite)
3. Vous pouvez voir les statistiques et gérer les produits

---

## 🐛 Dépannage

**Le frontend n'affiche rien?**
- Vérifiez que le backend est en cours d'exécution sur `localhost:8000`
- Ouvrez la console du navigateur (F12) pour voir les erreurs

**Erreur CORS?**
- Vérifiez que `VITE_API_URL=http://localhost:8000` est correct
- Le backend renvoie les headers CORS appropriés

**Erreur de connexion à la base de données?**
- C'est normal! L'appli utilise des données de démo
- Pas besoin de PostgreSQL pour tester

---

## 📝 Notes Importantes

✅ **Pas de base de données requise** - Toutes les données sont en mémoire (démo)
✅ **Token d'authentification** - Stocké dans `localStorage` avec préfixe `token`
✅ **Panier persistant** - Sauvegardé dans `localStorage` avec préfixe `cart`
✅ **API REST complète** - Tous les endpoints retournent du JSON

---

## 🎯 Prochaines Étapes (Optionnel)

Pour une vraie application:
1. Connecter une vraie base de données (PostgreSQL, MySQL)
2. Implémenter Stripe pour les paiements
3. Ajouter des emails transactionnels
4. Déployer sur un serveur de production
5. Ajouter des tests unitaires

---

**Bon développement! 🚀**
