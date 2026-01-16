@echo off
echo ====================================
echo   E-Commerce Platform - Groupe 6
echo ====================================
echo.

echo [1/3] Verification des dependances...
echo.

cd backend
if not exist "vendor\" (
    echo Installation des dependances Composer...
    composer install
)

cd ..\frontend
if not exist "node_modules\" (
    echo Installation des dependances npm...
    npm install
)

echo.
echo [2/3] Verification de la base de donnees...
echo.
echo IMPORTANT: Assurez-vous que PostgreSQL est lance et que la base de donnees 'ecommerce_db' existe.
echo Si ce n'est pas le cas, executez les commandes suivantes dans psql:
echo   CREATE DATABASE ecommerce_db;
echo.
echo Pour executer les migrations, lancez: php backend/migrate.php
echo.

echo [3/3] Demarrage des serveurs...
echo.
echo Backend: http://localhost:8000
echo Frontend: http://localhost:5173
echo.
echo Appuyez sur Ctrl+C pour arreter les serveurs
echo.

cd ..
start "Backend PHP" cmd /k "cd backend && php -S localhost:8000 -t public"
timeout /t 2 /nobreak >nul
start "Frontend Vue" cmd /k "cd frontend && npm run dev"

echo.
echo Serveurs lances!
echo.
pause
