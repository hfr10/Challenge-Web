@echo off
echo.
echo ========================================
echo  Challenge-Web - Demarrage Automatique
echo ========================================
echo.

REM Verifier si Node.js est installe
where node >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERREUR] Node.js n'est pas installe ou non dans le PATH
    echo Telechargez Node.js depuis: https://nodejs.org
    pause
    exit /b 1
)

REM Verifier si PHP est installe
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [ERREUR] PHP n'est pas installe ou non dans le PATH
    echo Telechargez PHP depuis: https://www.php.net/downloads
    pause
    exit /b 1
)

echo [OK] Node.js et PHP detectes
echo.
echo Demarrage en cours...
echo.

REM Changer le titre de la fenetre
title Challenge-Web - Backend (PHP)

REM Demarrer le backend PHP dans une nouvelle fenetre
echo Lancement du backend PHP sur localhost:8000...
start cmd /k "cd backend && php -S localhost:8000 -t public && pause"

REM Attendre un peu pour laisser le backend demarrer
timeout /t 2 /nobreak

REM Changer le titre
title Challenge-Web - Frontend (Vue.js)

REM Demarrer le frontend dans une nouvelle fenetre
echo Lancement du frontend Vue.js sur localhost:5173...
start cmd /k "cd frontend && npm run dev && pause"

REM Message final
echo.
echo ========================================
echo  DEMARRAGE COMPLETE!
echo ========================================
echo.
echo Backend (PHP):   http://localhost:8000
echo Frontend (Vue):  http://localhost:5173
echo.
echo Ouverture du navigateur...
timeout /t 2 /nobreak

REM Ouvrir le navigateur
start http://localhost:5173

echo.
echo Les deux serveurs devraient maintenant etre actifs!
echo Pour arreter, fermez les deux fenetres.
echo.
pause
