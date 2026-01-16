# 🎯 GUIDE RAPIDE DE DÉMARRAGE

## ⏱️ 2 Étapes = App Prête en 60 secondes

### ÉTAPE 1: Backend (30 secondes)
```bash
cd backend
php -S localhost:8000 -t public
```
✅ Vous devriez voir: `[<date>] Listening on http://localhost:8000`

### ÉTAPE 2: Frontend (30 secondes)
```bash
cd frontend
npm run dev
```
✅ Vous devriez voir: `Local: http://localhost:5173/`

### 🌐 RÉSULTAT
Le navigateur ouvre automatiquement: **http://localhost:5173**

---

## 🧪 Tester l'Application (1 minute)

### Test 1️⃣: Voir les Produits
1. Cliquez sur **"Produits"** dans le menu
2. Vous devriez voir **6 produits** ✅

### Test 2️⃣: Se Connecter
1. Cliquez sur le **🔑 Connexion** (en haut à droite)
2. Entrez:
   - Email: `test@example.com`
   - Mot de passe: `password123`
3. Cliquez **Se Connecter** ✅

### Test 3️⃣: Ajouter au Panier
1. Allez sur **Produits**
2. Cliquez sur un produit (ex: "Laptop Pro")
3. Cliquez **Ajouter au panier** ✅
4. Le badge du panier affiche "1" ✅

### Test 4️⃣: Voir le Panier
1. Cliquez sur le **🛒 panier** (en haut à droite)
2. Vous voyez vos articles ✅

---

## 📦 Avant de Commencer (Première Fois Seulement)

```bash
# Frontend - Installer les dépendances
cd frontend
npm install
# ⏳ Attend 2-3 minutes...

# Backend - Pas besoin d'installer (aucune dépendance requise)
# ✅ Prêt!
```

---

## ❌ Ça Ne Marche Pas?

### "Je vois une page blanche"
- [ ] Vérifiez que le **backend est lancé** (terminal affiche "Listening on...")
- [ ] Vérifiez que vous êtes sur http://localhost:**5173** (pas 8000)
- [ ] Appuyez sur `F5` (Refresh)

### "Erreur CORS / Cannot GET"
- [ ] Fermez les deux terminaux
- [ ] Relancez:
  - Backend: `php -S localhost:8000 -t public`
  - Frontend: `npm run dev`

### "Port 5173 ou 8000 utilisé"
- [ ] Trouvez quel process l'utilise et tuez-le
- **OU** changez le port:
  ```bash
  # Frontend - port 5174
  npm run dev -- --port 5174
  
  # Backend - port 8001
  php -S localhost:8001 -t public
  ```

### "npm: command not found"
- Installez Node.js: https://nodejs.org (LTS)
- Redémarrez VS Code après l'installation

### "php: command not found"
- Installez PHP: https://www.php.net/downloads
- Redémarrez VS Code après l'installation

---

## 🔑 Comptes Disponibles

**Utilisateur Test** (Déjà créé)
- Email: `test@example.com`
- Mot de passe: `password123`

**Créer un Nouveau Compte**
- Cliquez sur **"Pas encore de compte? Inscrivez-vous"**
- Remplissez le formulaire
- Vous recevez un token immédiatement

---

## 📱 URLs Importantes

| Nom | URL | Description |
|-----|-----|-------------|
| 🏠 Accueil | http://localhost:5173 | Page d'accueil |
| 🛍️ Boutique | http://localhost:5173/products | Tous les produits |
| 🛒 Panier | http://localhost:5173/cart | Votre panier |
| 🔑 Connexion | http://localhost:5173/login | Se connecter |
| ✏️ Inscription | http://localhost:5173/register | S'inscrire |
| 👤 Mon Profil | http://localhost:5173/profile | Profil utilisateur |
| 📦 Mes Commandes | http://localhost:5173/orders | Historique commandes |
| 🛡️ Admin | http://localhost:5173/admin | Dashboard admin |
| ⚙️ API Backend | http://localhost:8000 | Serveur API |

---

## 🚀 Bonus: Automatiser le Démarrage (Windows)

Double-cliquez sur **`start-all.bat`** pour lancer les deux serveurs automatiquement!

(Fonctionne aussi si vous fermez les fenêtres - les serveurs restent actifs)

---

## ✨ Faits Amusants

- 🆓 **Aucune base de données requise** - Tout est en mémoire
- 🚀 **Développement ultra rapide** - Modifiez le code, rafraîchissez
- 📦 **6 produits de démo** - Prêts à l'emploi
- 🔐 **Auth complète** - Login/Register/Logout/Token
- 💾 **Persistence** - Panier sauvegardé automatiquement
- 📱 **Responsive** - Fonctionne sur mobile/tablet/desktop

---

## 🎓 Architecture (Pour Les Curieux)

```
Backend (PHP)               Frontend (Vue.js)
  ↓                            ↓
localhost:8000              localhost:5173
  ↓                            ↓
REST API                    Single Page App
(30+ endpoints)            (9 pages)
  ↓                            ↓
Demo Data                   Pinia Stores
(No Database)              (State Mgmt)
  ↓                            ↓
JSON Responses             Axios Calls
  ↓                            ↓
CORS Headers               localStorage
  ↓                            ↓
 🔄 ← → ← → 🔄
```

---

## 📚 Prochaines Lectures

- `STARTUP.md` - Documentation complète
- `CORRECTIONS_APPLIQUEES.md` - Audit du projet
- `backend/config/api-routes.php` - Toutes les routes API
- `frontend/src/stores/` - État de l'application

---

**C'est tout! Bon développement! 🚀**
