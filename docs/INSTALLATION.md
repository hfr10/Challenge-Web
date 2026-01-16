##  Challenge-Web – Site E-Commerce

Ce projet est une application e-commerce complète composée d'une API REST en PHP et d'une interface client moderne en Vue.js.




# Prérequis

Assurez-vous que les outils suivants sont installés sur votre machine :
PHP 8.2
Composer (Gestionnaire de dépendances PHP)
Node.js & npm (Gestionnaire de dépendances JavaScript)
PostgreSQL (Ou un autre SGBD compatible)
Serveur local : XAMPP, Laragon ou PHP CLI




# Partie 1 : Backend (API PHP)

# 1. Entrer dans le dossier

      Windows (PowerShell) :
Remove-Item -Recurse -Force .\vendor

# Linux/Mac :
rm -rf vendor

# 3. Installer les librairies PHP
composer install --no-interaction

# 4. Configurer l'environnement (Copie le fichier exemple)
cp .env.example .env

# 5. Lancer l'API
php -S localhost:8000 -t public
Point d'accès : http://localhost:8000Vérification : Une réponse JSON ou une page de bienvenue indique que l'API tourne.




# 2. Nettoyer les anciennes dépendances (si nécessaire)

Ouvre un deuxième terminal (garde celui du backend ouvert) :

# 1. Entrer dans le dossier
cd frontend

# 2. Installer les paquets JavaScript
npm install

# 3. Lancer le serveur de développement
npm run dev




# Partie 2 : Frontend (Vue.js)
Rôle : Interface utilisateur dynamique et interactive.
1. Prérequis spécifiquesNode.js (version LTS recommandée)npm ou yarn
2.  Procédure d'installation
3.  Ouvre un deuxième terminal (garde celui du backend ouvert) :

   
# 1. Entrer dans le dossier
cd frontend

# 2. Installer les paquets JavaScript
npm install

# 3. Lancer le serveur de développement
npm run dev

Point d'accès : http://localhost:5173

Vérification : Ton navigateur devrait s'ouvrir automatiquement sur l'interface du site. 

# Résumé de l'architecture

Service     Commande de lancement   Adresse localeBackendphp 
BackEnd  -S localhost:8000 -t public  http://localhost:8000
Frontend        npm run dev           http://localhost:5173