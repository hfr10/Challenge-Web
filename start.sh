#!/bin/bash

echo "===================================="
echo "  E-Commerce Platform - Groupe 6"
echo "===================================="
echo ""

echo "[1/3] Verification des dependances..."
echo ""

# Backend dependencies
cd backend
if [ ! -d "vendor" ]; then
    echo "Installation des dependances Composer..."
    composer install
fi

# Frontend dependencies
cd ../frontend
if [ ! -d "node_modules" ]; then
    echo "Installation des dependances npm..."
    npm install
fi

cd ..

echo ""
echo "[2/3] Verification de la base de donnees..."
echo ""
echo "IMPORTANT: Assurez-vous que PostgreSQL est lance et que la base de donnees 'ecommerce_db' existe."
echo "Si ce n'est pas le cas, executez les commandes suivantes dans psql:"
echo "  CREATE DATABASE ecommerce_db;"
echo ""
echo "Pour executer les migrations, lancez: php backend/migrate.php"
echo ""

echo "[3/3] Demarrage des serveurs..."
echo ""
echo "Backend: http://localhost:8000"
echo "Frontend: http://localhost:5173"
echo ""

# Start backend in background
cd backend
php -S localhost:8000 -t public > /dev/null 2>&1 &
BACKEND_PID=$!

# Start frontend in background
cd ../frontend
npm run dev > /dev/null 2>&1 &
FRONTEND_PID=$!

echo ""
echo "Serveurs lances!"
echo "Backend PID: $BACKEND_PID"
echo "Frontend PID: $FRONTEND_PID"
echo ""
echo "Appuyez sur Ctrl+C pour arreter les serveurs"
echo ""

# Trap Ctrl+C to kill both processes
trap "kill $BACKEND_PID $FRONTEND_PID; exit" INT

# Wait for both processes
wait
