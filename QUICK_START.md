# ⚡ TL;DR - Ultra-Rapide

## 🚀 Démarrer en 30 secondes

```bash
# Terminal 1
cd backend
php -S localhost:8000 -t public

# Terminal 2
cd frontend
npm run dev
```

→ Le navigateur ouvre http://localhost:5173 automatiquement

---

## 🧪 Test Rapide (30 secondes)

1. Cliquez **Produits** → Vous voyez 6 produits ✅
2. Cliquez sur un produit
3. Cliquez **Ajouter au panier**
4. Cliquez l'icône 🛒 → Vous voyez votre article ✅

---

## 🔐 Compte Test
```
Email: test@example.com
Mot de passe: password123
```

---

## 📁 Fichiers Clés

**Backend**:
- `backend/public/index.php` - Entry point
- `backend/config/api-routes.php` - Routes API
- `backend/src/Controllers/` - Logique métier

**Frontend**:
- `frontend/src/App.vue` - Root component
- `frontend/src/router/index.js` - Routes
- `frontend/src/stores/` - État (Pinia)
- `frontend/src/views/` - Pages

---

## 🔄 Modifier le Code

**Vue.js**: Modifiez un fichier .vue → Rafraîchir le navigateur (Hot reload)  
**PHP**: Modifiez un fichier .php → Rafraîchir le navigateur

---

## 🌐 URLs Importantes

| URL | Fonction |
|-----|----------|
| http://localhost:5173 | Application |
| http://localhost:8000 | API Backend |
| http://localhost:5173/products | Boutique |
| http://localhost:5173/cart | Panier |
| http://localhost:5173/login | Connexion |

---

## 🐛 Problème?

- **Page blanche** → Vérifier le backend lancé sur :8000
- **Port occupé** → Changer: `npm run dev -- --port 5174`
- **CORS error** → Vérifier `VITE_API_URL=http://localhost:8000` dans `.env`
- **npm not found** → Installer Node.js

→ Plus de dépannage: voir **TROUBLESHOOTING.md**

---

## 📚 Documentation

- **Démarrer**: [LIRE-MOI.md](LIRE-MOI.md)
- **Architecture**: [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md)
- **API**: [API_REFERENCE.md](API_REFERENCE.md)
- **Problèmes**: [TROUBLESHOOTING.md](TROUBLESHOOTING.md)

---

**Bon développement! 🚀**
