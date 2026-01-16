# 🔧 Troubleshooting - Dépannage Complet

## ⚠️ Problèmes Courants et Solutions

---

## 1️⃣ Le Frontend Affiche une Page Blanche

### Symptômes
- Page blanche à http://localhost:5173
- Aucun contenu visible
- Pas d'erreur dans la console

### Solutions (dans l'ordre)

#### ✅ Solution 1: Vérifier que le Backend Démarre
```bash
# Terminal 1: Frontend
npm run dev

# Terminal 2: Backend (MANQUANT?)
php -S localhost:8000 -t public
```

**Erreur**: Si vous ne voyez pas `Listening on http://localhost:8000` → Le backend n'est pas lancé

#### ✅ Solution 2: Vérifier la Console du Navigateur
- Ouvrez le navigateur (F12 → Console)
- Cherchez des erreurs rouges:
  - `ERR_CONNECTION_REFUSED` → Backend ne répond pas
  - `404 on /` → API ne trouve pas la route
  - CORS error → Vérifiez `VITE_API_URL`

#### ✅ Solution 3: Vérifier le .env Frontend
```bash
# frontend/.env
VITE_API_URL=http://localhost:8000
```

Si ce fichier n'existe pas:
```bash
cp frontend/.env.example frontend/.env
# Puis modifiez la valeur de VITE_API_URL si nécessaire
```

#### ✅ Solution 4: Rafraîchir le Navigateur
- Appuyez sur `Ctrl+Shift+R` (vidage du cache)
- Ou ouvrez en mode incognito
- Ou changez le port: `npm run dev -- --port 5174`

#### ✅ Solution 5: Réinstaller les dépendances
```bash
cd frontend
rm -rf node_modules package-lock.json
npm install
npm run dev
```

---

## 2️⃣ Erreur CORS / Cannot Read Backend

### Symptômes
```
Access to XMLHttpRequest at 'http://localhost:8000/products'
from origin 'http://localhost:5173' has been blocked by CORS policy
```

### Causes
- Backend n'envoie pas les headers CORS
- Mauvaise URL du backend

### Solutions

#### ✅ Solution 1: Vérifier que le Backend Envoie les CORS Headers
Le fichier `backend/public/index.php` doit contenir:
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
```

#### ✅ Solution 2: Vérifier l'URL de l'API
Dans `frontend/.env`:
```
VITE_API_URL=http://localhost:8000
```

**PAS**:
```
VITE_API_URL=http://127.0.0.1:8000    ❌ Peut causer des CORS
VITE_API_URL=http://localhost:8001     ❌ Mauvais port
VITE_API_URL=http://192.168.1.x:8000   ⚠️ Fonctionne sauf localhost
```

#### ✅ Solution 3: Redémarrer le Backend
```bash
# Terminez le process (Ctrl+C)
# Relancez:
php -S localhost:8000 -t public
```

---

## 3️⃣ Port 5173 ou 8000 Déjà Utilisé

### Symptômes
```
Error: listen EADDRINUSE: address already in use :::5173
```
ou
```
PHP Fatal error: Address already in use
```

### Solutions

#### ✅ Solution 1: Changer de Port

**Frontend**:
```bash
npm run dev -- --port 5174
# Ou si l'app demande, entrez un autre port
```

**Backend**:
```bash
php -S localhost:8001 -t public
```

**Puis mettre à jour `frontend/.env`**:
```
VITE_API_URL=http://localhost:8001
```

#### ✅ Solution 2: Tuer le Processus qui Utilise le Port

**Windows**:
```powershell
# Trouver les process
netstat -ano | findstr :5173
netstat -ano | findstr :8000

# Tuer (remplacer PID)
taskkill /PID 12345 /F
```

**Mac/Linux**:
```bash
# Trouver et tuer
lsof -ti :5173 | xargs kill -9
lsof -ti :8000 | xargs kill -9
```

---

## 4️⃣ npm: Command Not Found

### Symptômes
```
bash: npm: command not found
```

### Solutions

#### ✅ Solution 1: Installer Node.js
1. Allez sur https://nodejs.org
2. Téléchargez la version **LTS** (Long Term Support)
3. Installez
4. **Redémarrez VS Code** ou le terminal
5. Vérifiez: `node --version` et `npm --version`

#### ✅ Solution 2: Ajouter Node.js au PATH
Si déjà installé mais pas reconnu:

**Windows**:
1. Trouvez où Node.js est installé (ex: `C:\Program Files\nodejs`)
2. Ajoutez-le à la variable d'environnement `PATH`
3. Redémarrez le terminal

**Mac/Linux**:
```bash
# Vérifiez où Node est installé
which node

# Si rien, installez avec Homebrew
brew install node
```

---

## 5️⃣ php: Command Not Found

### Symptômes
```
bash: php: command not found
```

### Solutions

#### ✅ Solution 1: Installer PHP
1. Allez sur https://www.php.net/downloads
2. Téléchargez **PHP 8.0+**
3. Installez
4. **Redémarrez VS Code** ou le terminal
5. Vérifiez: `php --version`

#### ✅ Solution 2: Utiliser XAMPP/WAMP/MAMP
Si vous préférez un setup tout-en-un:

**Windows**: XAMPP (https://www.apachefriends.org/)
```bash
# Dans le dossier XAMPP
C:\xampp\php\php -S localhost:8000 -t public
```

**Mac**: MAMP (https://www.mamp.info/)

**Linux**: php.net ou gestionnaire de paquets

---

## 6️⃣ La Connexion Échoue / Mauvais Identifiants

### Symptômes
```
Erreur de connexion / Email ou mot de passe incorrect
```

### Solutions

#### ✅ Solution 1: Utiliser le Compte Test
Compte pré-créé dans le backend:
```
Email: test@example.com
Mot de passe: password123
```

#### ✅ Solution 2: Vérifier la Réponse du Serveur
Ouvrez la console (F12 → Network tab):
1. Cliquez sur "Se connecter"
2. Regardez la requête POST `/auth/login`
3. Vérifiez la réponse (Response tab)
4. Elle devrait avoir: `"success": true` et un token

Si vous voyez `"success": false`:
- Le serveur retourne une erreur
- Vérifiez que le backend tourne correctement

#### ✅ Solution 3: S'inscrire au Lieu de Se Connecter
Si le compte test ne marche pas:
1. Allez sur `/register`
2. Créez un nouveau compte
3. Utilisez ce compte pour vous connecter

---

## 7️⃣ Le Panier est Vide après Rechargement

### Symptômes
- Vous ajoutez un article au panier
- Vous rafraîchissez la page
- Le panier est vide

### Solutions

#### ✅ Solution 1: Vérifier que localStorage Fonctionne
Ouvrez la console (F12 → Application → Local Storage):
- Cherchez une clé `cart`
- Elle devrait contenir votre panier en JSON

Si elle n'existe pas:
- Essayez d'ajouter à nouveau un article
- Vérifiez que le navigateur stocke bien les données

#### ✅ Solution 2: Vérifier les Erreurs JavaScript
Ouvrez la console (F12 → Console):
- Cherchez des erreurs rouges
- Regardez l'onglet Network pour voir si les requêtes passent

#### ✅ Solution 3: Désactiver le Mode Incognito
En mode incognito, localStorage est souvent désactivé.

**Mode Normal** → localStorage fonctionne ✅
**Mode Incognito** → localStorage peut ne pas marcher ❌

---

## 8️⃣ Les Produits ne Chargent Pas

### Symptômes
- Page "Produits" affiche rien
- Le page affiche un message d'erreur
- Pas de 6 produits

### Solutions

#### ✅ Solution 1: Vérifier que le Backend Répond
```bash
# Dans un terminal séparé, testez l'API:
curl http://localhost:8000/products

# Vous devriez voir un JSON avec 6 produits
```

Si le backend ne répond pas:
1. Vérifiez qu'il est lancé: `php -S localhost:8000 -t public`
2. Vérifiez qu'il écoute bien sur le port 8000
3. Vérifiez qu'aucune erreur PHP n'apparaît

#### ✅ Solution 2: Vérifier la Réponse du Backend
Ouvrez F12 → Network:
1. Allez sur la page "Produits"
2. Cherchez une requête GET `/products`
3. Cliquez dessus → Response tab
4. Vous devriez voir:
```json
{
  "success": true,
  "products": [...]
}
```

Si ce n'est pas le cas:
- Le contrôleur ProductController a un problème
- Vérifiez les erreurs dans le terminal du backend

#### ✅ Solution 3: Vérifier la Console du Navigateur
F12 → Console:
- Cherchez des erreurs en rouge
- Elles indiquent souvent le problème

---

## 9️⃣ Les Filtres de Produits ne Marchent Pas

### Symptômes
- Vous entrez un texte de recherche → rien ne change
- Vous sélectionnez une catégorie → rien ne change

### Solutions

#### ✅ Solution 1: Vérifier que les Produits Sont Chargés
Avant de filtrer, assurez-vous que:
- La page affiche les 6 produits
- Les produits sont visibles

Si non → voir section "Les produits ne chargent pas"

#### ✅ Solution 2: Vérifier le Store Products
Ouvrez F12 → Console:
```javascript
// Copier-coller dans la console:
const { useProductsStore } = await import('@/stores/products');
const store = useProductsStore();
console.log(store.products);
console.log(store.filters);
```

Vous devriez voir:
- `products`: Array de 6 objets
- `filters`: Object avec les filtres actuels

#### ✅ Solution 3: Vérifier la Réactivité
Ouvrez l'onglet Network (F12 → Network):
- Tapez dans la barre de recherche
- Vous devriez **PAS** voir de nouvelles requêtes (le filtrage est local)
- La page se met à jour localement

---

## 🔟 Admin Dashboard Ne Marche Pas

### Symptômes
- Page Admin affiche rien
- Vous n'êtes pas admin
- Erreur 403 Forbidden

### Solutions

#### ✅ Solution 1: Vérifier que Vous Êtes Connecté
- Allez sur http://localhost:5173/admin
- Si vous êtes redirigé vers `/login` → vous n'êtes pas connecté

#### ✅ Solution 2: Utiliser le Compte Test
Le compte test est déjà créé dans le backend:
```
Email: test@example.com
Mot de passe: password123
```

Connectez-vous avec ce compte.

#### ✅ Solution 3: Vérifier que le Backend a les Routes Admin
Ouvrez `backend/config/api-routes.php` et vérifiez que:
- Les routes `/admin/*` existent
- Elles appellent `AdminController`

---

## 1️⃣1️⃣ Erreur 500 Internal Server Error

### Symptômes
```
HTTP 500
Internal Server Error
```

### Solutions

#### ✅ Solution 1: Vérifier les Logs du Backend
Dans le terminal du backend, vous devriez voir une erreur PHP:
```
PHP Fatal error: ...
PHP Parse error: ...
```

Lisez le message et corrigez l'erreur.

#### ✅ Solution 2: Vérifier le Fichier Coupable
L'erreur indique souvent un fichier et une ligne:
```
Fatal error in /path/to/file.php on line 42
```

Ouvrez ce fichier et vérifiez la ligne.

#### ✅ Solution 3: Vérifier que les Fichiers Existent
Assurez-vous que tous les fichiers requis existent:
```
✅ backend/public/index.php
✅ backend/config/api-routes.php
✅ backend/src/Controllers/*.php
✅ backend/src/Core/Router.php
```

---

## 1️⃣2️⃣ Erreur 404 Not Found

### Symptômes
```
404 Not Found
```

### Solutions

#### ✅ Solution 1: Vérifier l'URL
Assurez-vous que l'URL est correcte:
- Frontend: http://localhost:5173 (pas 8000)
- API Backend: http://localhost:8000 (pas 5173)

#### ✅ Solution 2: Vérifier que la Route Existe
Si c'est une API:
1. Ouvrez `backend/config/api-routes.php`
2. Cherchez la route (ex: `/products`)
3. Vérifiez qu'elle est définie avec `$router->get()`

#### ✅ Solution 3: Vérifier le Routing Frontend
Si c'est une page Vue:
1. Ouvrez `frontend/src/router/index.js`
2. Cherchez la route (ex: `/products`)
3. Vérifiez qu'elle pointe à une vue correcte

---

## 1️⃣3️⃣ Les Modifications du Code ne S'Appliquent Pas

### Symptômes
- Vous modifiez un fichier Vue
- Vous rafraîchissez la page
- Aucun changement

### Solutions

#### ✅ Solution 1: Attendre le Hot Reload
Vite a un système de hot reload:
- Sauvegardez le fichier (Ctrl+S)
- Attendez 1-2 secondes
- La page se met à jour automatiquement

**Si rien ne change** → Voir ci-dessous

#### ✅ Solution 2: Rafraîchir Manuellement
```
Ctrl+R (ou Cmd+R)
```

Ou pour un vidage complet du cache:
```
Ctrl+Shift+R (ou Cmd+Shift+R)
```

#### ✅ Solution 3: Relancer le Serveur Frontend
```bash
# Stoppez: Ctrl+C
# Relancez:
npm run dev
```

#### ✅ Solution 4: Vérifier que le Fichier est Sauvegardé
- VS Code affiche un point blanc sur les fichiers non sauvegardés
- Assurez-vous que le fichier modifié n'a pas ce point

---

## 1️⃣4️⃣ Erreur de Compilation Vite

### Symptômes
```
[vite] Internal server error: The requested module does not provide an export named ...
```

ou

```
SyntaxError: Unexpected token ...
```

### Solutions

#### ✅ Solution 1: Vérifier la Syntaxe
L'erreur indique souvent un problème de syntaxe JavaScript/Vue.

Vérifiez:
- Les imports (`import ... from ...`)
- Les exports (`export`)
- La syntaxe du composant Vue

#### ✅ Solution 2: Redémarrer Vite
```bash
# Stoppez: Ctrl+C
# Attendez 2 secondes
# Relancez:
npm run dev
```

#### ✅ Solution 3: Nettoyer les Dépendances
```bash
cd frontend
rm -rf node_modules
npm install
npm run dev
```

---

## 1️⃣5️⃣ Problème de Mémoire ou Lenteur

### Symptômes
- L'appli est très lente
- Le navigateur consomme beaucoup de RAM
- Le terminal montre des avertissements

### Solutions

#### ✅ Solution 1: Vérifier les Onglets Ouverts
- Fermez les onglets inutiles
- Limitez à 1-2 onglets de développement

#### ✅ Solution 2: Vider le Cache
**Navigateur**:
- F12 → Application → Clear Site Data
- Ou Ctrl+Shift+Delete

**VS Code**:
```bash
cd frontend
rm -rf .vite node_modules dist
npm install
npm run dev
```

#### ✅ Solution 3: Redémarrer l'Ordinateur
Parfois, un redémarrage simple règle les problèmes de ressources.

---

## 🔍 Debugging Avancé

### Ouvrir la Console Développeur
**Raccourci**: `F12` ou `Ctrl+Shift+I`

### Onglets Importants
- **Console** - Erreurs et logs JavaScript
- **Network** - Requêtes HTTP/API
- **Application** - localStorage, cookies
- **Source** - Debugger de code

### Utiliser console.log()
```javascript
// Dans un composant Vue:
const result = await authStore.login(form.value)
console.log('Login result:', result)  // Voir ce qu'il retourne
```

### Tester l'API avec cURL
```bash
# Lister les produits
curl http://localhost:8000/products

# Se connecter
curl -X POST http://localhost:8000/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'
```

---

## 📞 Besoin d'Aide?

Si aucune de ces solutions ne marche:

1. **Vérifiez les logs**:
   - Terminal backend (PHP errors)
   - Console frontend (F12)
   - Network tab (HTTP errors)

2. **Relancez tout**:
   ```bash
   # Backend
   php -S localhost:8000 -t public
   
   # Frontend (autre terminal)
   npm run dev
   ```

3. **Consultez la documentation**:
   - LIRE-MOI.md
   - API_REFERENCE.md
   - PROJECT_STRUCTURE.md

4. **Vérifiez que Node.js et PHP sont à jour**:
   ```bash
   node --version   # 20+
   php --version    # 8.0+
   ```

---

**Bon debugging! 🐛🔧**
