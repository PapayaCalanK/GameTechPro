<?php
session_start();

// Affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter au panier
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'], $_GET['nom'], $_GET['prix'], $_GET['image'])) {
    $_SESSION['panier'][] = [
        'id' => $_GET['id'],
        'nom' => $_GET['nom'],
        'prix' => $_GET['prix'],
        'image' => $_GET['image']
    ];
    header('Location: panier.php');
    exit();
}

// Retirer du panier
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    foreach ($_SESSION['panier'] as $key => $article) {
        if ($article['id'] == $_GET['id']) {
            unset($_SESSION['panier'][$key]);
            break;
        }
    }
    $_SESSION['panier'] = array_values($_SESSION['panier']);
}

// Calculer le total du panier
function calculerTotal() {
    return !empty($_SESSION['panier']) ? array_sum(array_column($_SESSION['panier'], 'prix')) : 0;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="header center-title">
    <a href="index.php" class="back-button">← Retour</a>
    <h1>GameTechPro</h1>
</header>


<main class="cart-container">
    <?php if (empty($_SESSION['panier'])) : ?>
        <div class="empty-cart">
            <h2>Votre panier est vide</h2>
            <a href="index.php" class="checkout-button">Continuer mes achats</a>
        </div>
    <?php else : ?>
        <div class="cart-box">
            <h2>Votre Panier</h2>
            <?php foreach ($_SESSION['panier'] as $article) : ?>
                <div class="cart-item">
                    <img src="images/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>" class="cart-item-image">
                    <div class="cart-item-details">
                        <h3 class="product-name"> <?= htmlspecialchars($article['nom']) ?> </h3>
                        <p class="product-price"> <?= htmlspecialchars($article['prix']) ?> € </p>
                        <a href="panier.php?action=remove&id=<?= $article['id'] ?>" class="remove-button">Retirer</a>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="cart-total">
                <h3>Total : <?= calculerTotal() ?> €</h3>
            </div>
            <div class="cart-actions">
                <a href="index.php" class="checkout-button continue">Continuer mes achats</a>
                <a href="checkout.php" class="checkout-button">Passer à la caisse</a>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
