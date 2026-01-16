# Guide de Démarrage Rapide

## Installation en 5 minutes

### Étape 1: Prérequis
Assurez-vous d'avoir installé:
- PHP 8.1+ (`php --version`)
- PostgreSQL 14+ (`psql --version`)
- Composer (`composer --version`)
- Node.js 20+ (`node --version`)

### Étape 2: Configuration de la base de données

```bash
# Se connecter à PostgreSQL
psql -U postgres

# Dans psql, créer la base de données
CREATE DATABASE ecommerce_db;

# Quitter psql
\q
```

### Étape 3: Configuration du backend

```bash
# Copier le fichier d'environnement
cp backend/.env.example backend/.env

# Éditer backend/.env et modifier si nécessaire:
# DB_PASSWORD=votre_mot_de_passe
```

### Étape 4: Exécuter les migrations

```bash
php backend/migrate.php
```

Vous devriez voir:
```
✓ Connexion à la base de données réussie
✓ Migration exécutée avec succès
✓ Tables créées: users, categories, products, orders, order_items
✓ Données de test insérées
```

### Étape 5: Lancer l'application

#### Option A: Automatique (Windows)
```bash
start.bat
```

#### Option B: Automatique (Linux/Mac)
```bash
chmod +x start.sh
./start.sh
```

#### Option C: Manuel

**Terminal 1 - Backend:**
```bash
cd backend
php -S localhost:8000 -t public
```

**Terminal 2 - Frontend:**
```bash
cd frontend
npm install  # Première fois seulement
npm run dev
```

### Étape 6: Accéder à l'application

- **Frontend:** http://localhost:5173
- **Backend API:** http://localhost:8000

## Comptes de test

### Administrateur
- Email: `admin@ecommerce.com`
- Mot de passe: `admin123`

### Utilisateur
- Email: `john@example.com`
- Mot de passe: `password123`

## Tester l'API

```bash
# Récupérer les produits
curl http://localhost:8000/products

# Inscription
curl -X POST http://localhost:8000/auth/register \
  -H "Content-Type: application/json" \
  -d '{"email":"test@test.com","password":"test123","first_name":"Test","last_name":"User"}'

# Connexion
curl -X POST http://localhost:8000/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@ecommerce.com","password":"admin123"}'
```

## Structure de l'application

```
http://localhost:5173/              # Page d'accueil
http://localhost:5173/products      # Catalogue
http://localhost:5173/cart          # Panier
http://localhost:5173/login         # Connexion
http://localhost:5173/register      # Inscription
http://localhost:5173/orders        # Mes commandes (authentifié)
http://localhost:5173/profile       # Profil (authentifié)
http://localhost:5173/admin         # Admin (admin uniquement)
```

## Dépannage

### Problème: "Connection refused" lors de l'accès au backend
**Solution:** Vérifiez que le serveur PHP est lancé sur le port 8000

### Problème: Erreur de connexion à PostgreSQL
**Solution:**
1. Vérifiez que PostgreSQL est démarré
2. Vérifiez les identifiants dans `backend/.env`
3. Vérifiez que la base de données `ecommerce_db` existe

### Problème: Les dépendances npm ne s'installent pas
**Solution:**
```bash
cd frontend
rm -rf node_modules package-lock.json
npm install
```

### Problème: Erreur PSR-4 autoload
**Solution:**
```bash
cd backend
composer dump-autoload
```

### Problème: CORS errors dans le navigateur
**Solution:** Assurez-vous que:
1. Le backend tourne sur `http://localhost:8000`
2. Le frontend tourne sur `http://localhost:5173`
3. Le fichier `frontend/.env` contient `VITE_API_URL=http://localhost:8000`

## Commandes utiles

### Backend
```bash
# Regénérer l'autoload
cd backend && composer dump-autoload

# Réexécuter les migrations (WARNING: efface les données)
php backend/migrate.php

# Vérifier la syntaxe PHP
php -l backend/public/index.php
```

### Frontend
```bash
# Lancer en mode dev
npm run dev

# Build pour production
npm run build

# Preview du build
npm run preview

# Linter le code
npm run lint
```

## Prochaines étapes

1. Connectez-vous avec le compte admin
2. Explorez le dashboard admin
3. Ajoutez des produits au panier
4. Passez une commande
5. Consultez vos commandes

Pour plus de détails, consultez le [README.md](README.md) complet.

## Support

En cas de problème:
1. Vérifiez les logs dans la console du navigateur (F12)
2. Vérifiez les logs du serveur PHP
3. Consultez le README.md
4. Ouvrez une issue sur GitHub

---

Bon développement! 🚀
