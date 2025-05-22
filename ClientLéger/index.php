<?php
session_start();
require 'config.php';

// Récupérer les filtres éventuels (filtre marque)
$filter = isset($_GET['category']) ? $_GET['category'] : 'all';

// Début de la requête SQL
$sql = "SELECT * FROM produits";
$conditions = [];
$params = [];

//  Filtrage par marque si sélectionné
if ($filter !== 'all') {
    $conditions[] = "marque = :filter";
    $params[':filter'] = $filter;
}

//  Gestion des filtres de prix (en dessous ou au-dessus d'un montant saisi)
if (!empty($_GET['price_condition']) && !empty($_GET['price_value'])) {
    if ($_GET['price_condition'] === 'below') {

        // Si l'utilisateur veut voir les produits en dessous d'un certain prix
        $conditions[] = "prix <= :price_value";
        $params[':price_value'] = $_GET['price_value'];
    } elseif ($_GET['price_condition'] === 'above') {
        
        // Si l'utilisateur veut voir les produits au-dessus d'un certain prix
        $conditions[] = "prix >= :price_value";
        $params[':price_value'] = $_GET['price_value'];
    }
}

//  Si on a des conditions (filtre marque ou prix), on les ajoute à la requête
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

//  Gestion du tri par prix (ordre croissant ou décroissant)
if (!empty($_GET['price_filter'])) {
    if ($_GET['price_filter'] === 'asc') {
        $sql .= " ORDER BY prix ASC";

    } elseif ($_GET['price_filter'] === 'desc') {
        $sql .= " ORDER BY prix DESC";
    }
}

//  Préparation et exécution de la requête sécurisée
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameTechPro - Nos Marques</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <script defer src="search.js"></script>
</head>
<body>

<header class="header">
    <div class="header-container">
        <h1>GameTechPro</h1>

        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="panier.php">Panier</a>
            <?php if (isset($_SESSION['user'])) : ?>
                <a href="deconnexion.php">Se déconnecter</a>
            <?php else : ?>
                <a href="connexion.php">Se connecter</a>
            <?php endif; ?>
        </nav>

        <!-- Barre de recherche AJAX -->
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Rechercher un produit..." autocomplete="off">
            <button type="submit">Rafraîchir</button>
        </form>
    </div>

    <!--  Formulaire de TRI par PRIX -->
   <div class="price-filter">
    <form method="GET" action="index.php" class="filter-form">
        <!--  Le premier bouton déroulant "Trier par prix" -->
        <select name="price_filter">
            <option value="">-- Trier par prix --</option>
            <option value="asc">Plus petit prix</option>
            <option value="desc">Plus grand prix</option>
        </select>

        <!--  Le champ "Saisir un prix" -->
        <input type="number" name="price_value" placeholder="Saisir un prix">

        <!--  Le bouton déroulant "Prix en dessous de / Prix au-dessus de" -->
        <select name="price_condition">
            <option value="">-- Choisir condition --</option>
            <option value="below">Prix en dessous de</option>
            <option value="above">Prix au-dessus de</option>
        </select>

        <!--  Le bouton bleu "Trier" -->
        <button type="submit">Trier</button>
    </form>
</div>

</header>

<!-- Filtres de marques -->
<div class="filters">
    <a href="?category=all" class="filter-btn <?= $filter === 'all' ? 'active' : '' ?>">Nos Marques</a>
    <a href="?category=HP" class="filter-btn <?= $filter === 'HP' ? 'active' : '' ?>">HP</a>
    <a href="?category=Apple" class="filter-btn <?= $filter === 'Apple' ? 'active' : '' ?>">Apple</a>
    <a href="?category=Acer" class="filter-btn <?= $filter === 'Acer' ? 'active' : '' ?>">Acer</a>
    <a href="?category=Asus" class="filter-btn <?= $filter === 'Asus' ? 'active' : '' ?>">Asus</a>
    <a href="?category=Lenovo" class="filter-btn <?= $filter === 'Lenovo' ? 'active' : '' ?>">Lenovo</a>
</div>

<!-- Conteneur des produits mis à jour dynamiquement -->
<div id="products-container" class="products-container">
    <?php if (empty($produits)) : ?>
        <p class="no-products">Aucun produit trouvé.</p>
    <?php else : ?>
        <?php foreach ($produits as $produit) : ?>
            <div class="product-card">
                <img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="product-image">
                <div class="product-info">
                    <h3 class="product-name"><?= htmlspecialchars($produit['nom']) ?></h3>
                    <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                    <p class="product-price"><?= htmlspecialchars($produit['prix']) ?> €</p>
                    <a href="panier.php?action=add&id=<?= $produit['id'] ?>&nom=<?= urlencode($produit['nom']) ?>&prix=<?= $produit['prix'] ?>&image=<?= urlencode($produit['image']) ?>" class="add-to-cart-button">Ajouter au panier</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
