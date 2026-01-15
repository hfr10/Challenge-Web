-- Users
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    category_id INTEGER REFERENCES categories(id) ON DELETE SET NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    image_url VARCHAR(500),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    shipping_address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order Items
CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,
    order_id INTEGER REFERENCES orders(id) ON DELETE CASCADE,
    product_id INTEGER REFERENCES products(id),
    quantity INTEGER NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL
);

-- Index pour performances
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_order_items_order ON order_items(order_id);

-- Catégories Football
INSERT INTO categories (name, slug, description) VALUES
('Maillots', 'maillots', 'Maillots officiels de clubs et équipes nationales'),
('Chaussures', 'chaussures', 'Crampons et chaussures de football'),
('Ballons', 'ballons', 'Ballons d''entraînement et de match'),
('Équipement', 'equipement', 'Protège-tibias, gants, sacs et accessoires'),
('Survêtements', 'survetements', 'Survêtements et vêtements d''entraînement'),
('Accessoires', 'accessoires', 'Chaussettes, chasubles, pompons et accessoires');

-- Maillots
INSERT INTO products (category_id, name, slug, description, price, stock, image_url) VALUES
(1, 'Maillot PSG Domicile 2024/25', 'maillot-psg-domicile-2024', 'Maillot officiel du Paris Saint-Germain saison 2024/2025. Bleu marine avec bande rouge centrale.', 89.99, 150, 'https://images.unsplash.com/photo-1522778119026-d647f0596c20?w=300'),
(1, 'Maillot Real Madrid Extérieur 2024/25', 'maillot-real-madrid-exterieur-2024', 'Maillot noir mythique du Real Madrid. Édition limitée avec détails dorés.', 94.99, 80, 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=300'),
(1, 'Maillot France Domicile 2024', 'maillot-france-domicile-2024', 'Maillot de l''équipe de France. Bleu tricolore avec 2 étoiles.', 84.99, 200, 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=300'),
(1, 'Maillot Manchester City Domicile 2024/25', 'maillot-man-city-domicile-2024', 'Maillot sky blue iconique de Manchester City.', 89.99, 120, 'https://images.unsplash.com/photo-1560272564-c83b66b1ad12?w=300'),
(1, 'Maillot Barcelone Third 2024/25', 'maillot-barcelone-third-2024', 'Troisième maillot du FC Barcelone. Design moderne en dégradé bleu-vert.', 92.99, 90, 'https://images.unsplash.com/photo-1556817411-31ae72fa3ea0?w=300'),

-- Chaussures
(2, 'Nike Mercurial Vapor 15 Elite', 'nike-mercurial-vapor-15', 'Crampons ultra-légers pour la vitesse. Technologie Air Zoom pour l''explosivité.', 279.99, 45, 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=300'),
(2, 'Adidas Predator Edge.1 FG', 'adidas-predator-edge-1', 'Contrôle et précision maximale. Idéal pour les meneurs de jeu.', 249.99, 60, 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=300'),
(2, 'Puma Future Ultimate FG', 'puma-future-ultimate', 'Chaussures adaptatives avec système de laçage FUZIONFIT360.', 229.99, 50, 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=300'),
(2, 'Nike Phantom GX Elite FG', 'nike-phantom-gx-elite', 'Frappe de balle optimisée avec surface texturée Gripknit.', 269.99, 35, 'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?w=300'),

-- Ballons
(3, 'Ballon Nike Flight 2024', 'ballon-nike-flight-2024', 'Ballon officiel de la Ligue 1. Technologie AerowSculpt pour trajectoire précise.', 149.99, 100, 'https://images.unsplash.com/photo-1614632537197-38a17061c2bd?w=300'),
(3, 'Ballon Adidas Champions League 2024', 'ballon-ucl-2024', 'Ballon officiel de l''UEFA Champions League avec étoiles iconiques.', 159.99, 80, 'https://images.unsplash.com/photo-1511489731672-3fc3e4f9c64d?w=300'),
(3, 'Ballon Entraînement Select Brillant', 'ballon-select-brillant', 'Ballon d''entraînement qualité professionnelle. Cousu main.', 69.99, 200, 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=300'),
(3, 'Ballon Futsal Puma King', 'ballon-futsal-puma-king', 'Ballon spécial futsal avec rebond contrôlé.', 44.99, 120, 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?w=300'),

-- Équipement
(4, 'Protège-tibias Nike Mercurial Lite', 'protege-tibias-nike-mercurial', 'Protège-tibias ultra-légers avec coque rigide. Portés par les pros.', 24.99, 300, 'https://images.unsplash.com/photo-1587329310686-91414b8e3cb7?w=300'),
(4, 'Gants Gardien Adidas Predator Pro', 'gants-adidas-predator-pro', 'Gants de gardien avec paume URG 4.0 pour adhérence maximale.', 119.99, 40, 'https://images.unsplash.com/photo-1542568849-f6b85e7b9b40?w=300'),
(4, 'Sac de Sport Nike Academy Team', 'sac-nike-academy-team', 'Grand sac de sport avec compartiment chaussures. 60L.', 39.99, 150, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=300'),
(4, 'Pompe à Ballon Double Action', 'pompe-ballon-double-action', 'Pompe manuelle avec manomètre intégré et aiguilles incluses.', 12.99, 250, 'https://images.unsplash.com/photo-1592107761705-30a1bbc641e7?w=300'),

-- Survêtements
(5, 'Survêtement PSG Training 2024', 'survetement-psg-training-2024', 'Survêtement officiel d''entraînement du PSG. Technologie Dri-FIT.', 99.99, 100, 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=300'),
(5, 'Veste Coupe-Vent Adidas Tiro 24', 'veste-adidas-tiro-24', 'Veste légère déperlante avec capuche. Parfaite pour l''échauffement.', 54.99, 180, 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=300'),
(5, 'Pantalon Entraînement Nike Dri-FIT Park', 'pantalon-nike-park', 'Pantalon d''entraînement avec poches zippées. Coupe ajustée.', 34.99, 220, 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=300'),

-- Accessoires
(6, 'Chaussettes Adidas Milano 16', 'chaussettes-adidas-milano', 'Chaussettes montantes avec technologie Climalite. Pack de 3 paires.', 19.99, 400, 'https://images.unsplash.com/photo-1586350977771-b3b0abd50c82?w=300'),
(6, 'Chasubles d''Entraînement Set 10pcs', 'chasubles-entrainement-10', 'Set de 10 chasubles réversibles bleu/rouge. Taille unique.', 29.99, 80, 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=300'),
(6, 'Brassard Capitaine Élastique', 'brassard-capitaine', 'Brassard de capitaine avec velcro ajustable. Plusieurs couleurs.', 7.99, 350, 'https://images.unsplash.com/photo-1543326727-cf6c39e8f84c?w=300'),
(6, 'Gourde Sport Nike HyperCharge 700ml', 'gourde-nike-hypercharge', 'Gourde isotherme avec valve anti-fuite. Sans BPA.', 16.99, 200, 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=300');

-- Utilisateur admin (password: admin123)
INSERT INTO users (email, password_hash, first_name, last_name, role) VALUES
('admin@footballshop.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Thomas', 'Dubois', 'admin');

-- Utilisateur test (password: test123)
INSERT INTO users (email, password_hash, first_name, last_name, role) VALUES
('client@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lucas', 'Martin', 'user');

-- Commande exemple
INSERT INTO orders (user_id, total, status, shipping_address) VALUES
(2, 194.98, 'delivered', '15 Rue du Stade, 75015 Paris');

INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) VALUES
(1, 3, 1, 84.99, 84.99),
(1, 11, 1, 69.99, 69.99),
(1, 16, 2, 19.99, 39.98);
```

---

## 🎨 Détails des Catégories

| Catégorie | Produits | Prix Moyen |
|-----------|----------|------------|
| **Maillots** | 5 produits | 85-95€ |
| **Chaussures** | 4 produits | 230-280€ |
| **Ballons** | 4 produits | 45-160€ |
| **Équipement** | 4 produits | 13-120€ |
| **Survêtements** | 3 produits | 35-100€ |
| **Accessoires** | 5 produits | 8-30€ |

**Total** : **25 produits** dans **6 catégories**

---

## 🔐 Comptes de Test
```
👤 ADMIN
Email: admin@footballshop.fr
Password: admin123

👤 CLIENT
Email: client@example.com
Password: test123