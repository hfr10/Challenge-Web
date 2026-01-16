# 📡 API REST - Documentation Complète

**Base URL**: `http://localhost:8000`

---

## 🏠 Endpoints Généraux

### Welcome
```http
GET /
```
**Réponse**:
```json
{"success": true, "message": "Welcome to Challenge Web API"}
```

### Test
```http
GET /test
```
**Réponse**:
```json
{"success": true, "message": "API is working"}
```

---

## 📦 Produits (Products)

### Lister tous les produits
```http
GET /products
```
**Réponse**:
```json
{
  "success": true,
  "products": [
    {
      "id": 1,
      "name": "Laptop Pro",
      "description": "High-performance laptop",
      "price": 1299.99,
      "category": "Electronics",
      "stock": 10,
      "image": "/images/laptop.jpg"
    }
  ]
}
```

### Récupérer un produit
```http
GET /products/{id}
```
**URL Example**: `GET /products/1`

**Réponse**:
```json
{
  "success": true,
  "product": {
    "id": 1,
    "name": "Laptop Pro",
    "price": 1299.99
  }
}
```

### Créer un produit
```http
POST /products
Content-Type: application/json

{
  "name": "New Product",
  "description": "Description",
  "price": 99.99,
  "category": "Electronics",
  "stock": 50,
  "image": "/images/product.jpg"
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Product created successfully"
}
```

### Mettre à jour un produit
```http
PUT /products/{id}
Content-Type: application/json

{
  "name": "Updated Name",
  "price": 199.99
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Product updated successfully"
}
```

### Supprimer un produit
```http
DELETE /products/{id}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

---

## 🔐 Authentification (Auth)

### S'inscrire
```http
POST /auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Réponse (201 Created)**:
```json
{
  "success": true,
  "message": "User registered successfully",
  "token": "a1b2c3d4e5f6...",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

### Se connecter
```http
POST /auth/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password123"
}
```

**Réponse (200 OK)**:
```json
{
  "success": true,
  "message": "Login successful",
  "token": "a1b2c3d4e5f6...",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  }
}
```

### Se déconnecter
```http
POST /auth/logout
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### Rafraîchir le token
```http
POST /auth/refresh
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "token": "new_token_here"
}
```

---

## 🛒 Panier (Cart)

### Récupérer le panier
```http
GET /cart
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "cart": {
    "items": [
      {
        "id": 1,
        "name": "Laptop",
        "quantity": 1,
        "price": 1299.99
      }
    ],
    "total": 1299.99
  }
}
```

### Ajouter au panier
```http
POST /cart/add
Authorization: Bearer {token}
Content-Type: application/json

{
  "product_id": 1,
  "quantity": 1
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Item added to cart"
}
```

### Voir les articles du panier
```http
GET /cart/items
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "items": [
    {
      "id": 1,
      "name": "Laptop",
      "quantity": 1,
      "price": 1299.99
    }
  ]
}
```

### Mettre à jour la quantité
```http
PUT /cart/{item_id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "quantity": 2
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Cart updated"
}
```

### Supprimer un article
```http
DELETE /cart/{item_id}
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Item removed from cart"
}
```

### Vider le panier
```http
DELETE /cart
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Cart cleared"
}
```

---

## 📦 Commandes (Orders)

### Créer une commande
```http
POST /orders
Authorization: Bearer {token}
Content-Type: application/json

{
  "items": [
    {
      "product_id": 1,
      "quantity": 1
    }
  ],
  "shipping_address": "123 Main St",
  "payment_method": "credit_card"
}
```

**Réponse (201 Created)**:
```json
{
  "success": true,
  "message": "Order created",
  "orderId": 123
}
```

### Lister mes commandes
```http
GET /orders
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "orders": [
    {
      "id": 1,
      "total": 1299.99,
      "status": "pending",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}
```

### Récupérer une commande
```http
GET /orders/{id}
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "order": {
    "id": 1,
    "total": 1299.99,
    "status": "pending",
    "items": [
      {
        "product_id": 1,
        "quantity": 1,
        "price": 1299.99
      }
    ]
  }
}
```

### Mettre à jour une commande
```http
PUT /orders/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "shipping_address": "456 Oak Ave"
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Order updated"
}
```

### Mettre à jour le statut
```http
PUT /orders/{id}/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "completed"
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Order status updated"
}
```

### Supprimer une commande
```http
DELETE /orders/{id}
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Order deleted"
}
```

---

## 👤 Utilisateurs (Users)

### Récupérer mon profil
```http
GET /users/profile
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-15T10:00:00Z"
  }
}
```

### Mettre à jour mon profil
```http
PUT /users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com"
}
```

**Réponse**:
```json
{
  "success": true,
  "message": "Profile updated"
}
```

### Supprimer mon compte
```http
DELETE /users/{id}
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "message": "User deleted"
}
```

### Récupérer mes commandes (via users)
```http
GET /users/{id}/orders
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "orders": [
    {
      "id": 1,
      "total": 1299.99,
      "status": "pending"
    }
  ]
}
```

---

## 🛡️ Admin (Admin)

### Tableau de bord
```http
GET /admin/dashboard
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "stats": {
    "total_orders": 42,
    "total_revenue": 50000.00,
    "total_products": 50,
    "total_users": 100
  }
}
```

### Lister toutes les commandes (Admin)
```http
GET /admin/orders
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "orders": [
    {
      "id": 1,
      "user_id": 5,
      "total": 1299.99,
      "status": "pending"
    }
  ]
}
```

### Lister tous les utilisateurs (Admin)
```http
GET /admin/users
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "users": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2024-01-15T10:00:00Z"
    }
  ]
}
```

### Lister tous les produits (Admin)
```http
GET /admin/products
Authorization: Bearer {token}
```

**Réponse**:
```json
{
  "success": true,
  "products": [...]
}
```

### Gérer un utilisateur (Admin)
```http
PUT /admin/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Updated Name",
  "role": "admin"
}
```

### Supprimer un utilisateur (Admin)
```http
DELETE /admin/users/{id}
Authorization: Bearer {token}
```

### Créer un produit (Admin)
```http
POST /admin/products
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "New Product",
  "price": 99.99
}
```

### Mettre à jour un produit (Admin)
```http
PUT /admin/products/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Updated Product",
  "price": 199.99
}
```

### Supprimer un produit (Admin)
```http
DELETE /admin/products/{id}
Authorization: Bearer {token}
```

### Gérer une commande (Admin)
```http
PUT /admin/orders/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "completed"
}
```

### Supprimer une commande (Admin)
```http
DELETE /admin/orders/{id}
Authorization: Bearer {token}
```

---

## 🔑 Authentication Header

Pour tous les endpoints protégés, incluez:
```http
Authorization: Bearer {votre_token}
```

Le token est retourné après le login/register et doit être inclus dans chaque requête.

---

## 🚨 Codes de Réponse HTTP

| Code | Signification |
|------|---------------|
| 200 | OK - Requête réussie |
| 201 | Created - Ressource créée |
| 400 | Bad Request - Données invalides |
| 401 | Unauthorized - Token manquant/invalide |
| 403 | Forbidden - Accès refusé (admin required) |
| 404 | Not Found - Ressource inexistante |
| 500 | Server Error - Erreur serveur |

---

## 💡 Exemples avec cURL

```bash
# Lister les produits
curl http://localhost:8000/products

# Se connecter
curl -X POST http://localhost:8000/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password123"}'

# Ajouter au panier (avec token)
curl -X POST http://localhost:8000/cart/add \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"product_id":1,"quantity":1}'
```

---

**Bonne intégration! 🚀**
