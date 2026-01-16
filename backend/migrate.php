<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s',
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_NAME']
    );

    $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    echo "✓ Connexion à la base de données réussie\n\n";

    $sqlFile = __DIR__ . '/migrations/001_create_tables.sql';

    if (!file_exists($sqlFile)) {
        throw new Exception("Fichier de migration introuvable: {$sqlFile}");
    }

    $sql = file_get_contents($sqlFile);

    echo "Exécution de la migration...\n";

    $pdo->exec($sql);

    echo "✓ Migration exécutée avec succès\n";
    echo "✓ Tables créées: users, categories, products, orders, order_items\n\n";

    echo "Insertion des données de test...\n";

    $pdo->exec("
        INSERT INTO users (email, password_hash, first_name, last_name, role) VALUES
        ('admin@ecommerce.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'Admin', 'User', 'admin'),
        ('john@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "', 'John', 'Doe', 'user'),
        ('jane@example.com', '" . password_hash('password123', PASSWORD_DEFAULT) . "', 'Jane', 'Smith', 'user')
        ON CONFLICT (email) DO NOTHING
    ");

    $pdo->exec("
        INSERT INTO categories (name, slug, description) VALUES
        ('Électronique', 'electronique', 'Produits électroniques et high-tech'),
        ('Mode', 'mode', 'Vêtements et accessoires'),
        ('Maison', 'maison', 'Articles pour la maison et décoration'),
        ('Sports', 'sports', 'Équipements sportifs et fitness')
        ON CONFLICT (slug) DO NOTHING
    ");

    $pdo->exec("
        INSERT INTO products (category_id, name, slug, description, price, stock, image_url, is_active) VALUES
        (1, 'Laptop Pro 15', 'laptop-pro-15', 'Ordinateur portable haute performance 15 pouces', 1299.99, 25, 'https://via.placeholder.com/300x300?text=Laptop', true),
        (1, 'Smartphone X', 'smartphone-x', 'Smartphone dernière génération avec 5G', 899.99, 50, 'https://via.placeholder.com/300x300?text=Phone', true),
        (1, 'Casque Audio Pro', 'casque-audio-pro', 'Casque audio sans fil avec réduction de bruit', 249.99, 100, 'https://via.placeholder.com/300x300?text=Headphones', true),
        (2, 'T-shirt Premium', 'tshirt-premium', 'T-shirt 100% coton biologique', 29.99, 200, 'https://via.placeholder.com/300x300?text=TShirt', true),
        (2, 'Jean Slim Fit', 'jean-slim-fit', 'Jean confortable coupe slim', 79.99, 150, 'https://via.placeholder.com/300x300?text=Jeans', true),
        (3, 'Lampe LED Design', 'lampe-led-design', 'Lampe LED moderne et élégante', 59.99, 75, 'https://via.placeholder.com/300x300?text=Lamp', true),
        (3, 'Coussin Déco', 'coussin-deco', 'Coussin décoratif en velours', 24.99, 120, 'https://via.placeholder.com/300x300?text=Cushion', true),
        (4, 'Ballon de Football', 'ballon-football', 'Ballon de football professionnel', 39.99, 80, 'https://via.placeholder.com/300x300?text=Soccer', true),
        (4, 'Tapis de Yoga', 'tapis-yoga', 'Tapis de yoga antidérapant', 34.99, 60, 'https://via.placeholder.com/300x300?text=Yoga', true),
        (4, 'Haltères 10kg', 'halteres-10kg', 'Paire d\'haltères de 10kg', 89.99, 40, 'https://via.placeholder.com/300x300?text=Dumbbells', true)
        ON CONFLICT (slug) DO NOTHING
    ");

    echo "✓ Données de test insérées\n";
    echo "  - 3 utilisateurs créés\n";
    echo "  - 4 catégories créées\n";
    echo "  - 10 produits créés\n\n";

    echo "═══════════════════════════════════════════════════════\n";
    echo "Migration terminée avec succès!\n";
    echo "═══════════════════════════════════════════════════════\n\n";

    echo "Comptes de test:\n";
    echo "  Admin: admin@ecommerce.com / admin123\n";
    echo "  User1: john@example.com / password123\n";
    echo "  User2: jane@example.com / password123\n\n";

} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
