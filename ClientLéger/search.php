<?php
require 'config.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

$sql = "SELECT * FROM produits WHERE nom LIKE :search OR marque LIKE :search";
$params = [':search' => "%$query%"];

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($produits)) {
    echo '<p class="no-products">Aucun produit trouvé.</p>';
} else {
    foreach ($produits as $produit) : ?>
        <div class="product-card">
            <img src="images/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="product-image">
            <div class="product-info">
                <h3 class="product-name"><?= htmlspecialchars($produit['nom']) ?></h3>
                <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                <p class="product-price"><?= htmlspecialchars($produit['prix']) ?> €</p>
                <a href="panier.php?action=add&id=<?= $produit['id'] ?>&nom=<?= urlencode($produit['nom']) ?>&prix=<?= $produit['prix'] ?>&image=<?= urlencode($produit['image']) ?>" class="add-to-cart-button">Ajouter au panier</a>
            </div>
        </div>
    <?php endforeach;
}
?>
