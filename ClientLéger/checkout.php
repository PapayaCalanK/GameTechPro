<?php
session_start();

// Vérifier si le panier est vide
if (empty($_SESSION['panier'])) {
    header('Location: panier.php');
    exit();
}

// Calculer le total du panier
function calculerTotal() {
    return array_sum(array_column($_SESSION['panier'], 'prix'));
}

// Simuler le paiement et vider le panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paiement'])) {
    $_SESSION['commande_success'] = true;
    $_SESSION['panier'] = []; // On vide le panier après validation
    header('Location: confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="header">
    <a href="panier.php" class="back-button">← Retour</a>
    <h1>GameTechPro</h1>
</header>

<main class="checkout-container">
    <h2>Finalisation de la commande</h2>

    <form method="POST">
        <div class="checkout-section">
            <h3>Informations de livraison</h3>
            <label>Nom complet</label>
            <input type="text" name="nom" required>
            <label>Adresse</label>
            <input type="text" name="adresse" required>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="checkout-section">
            <h3>Mode de paiement</h3>
            <label><input type="radio" name="paiement" value="cb" checked> Carte bancaire</label>
            <label>Numéro de carte</label>
            <input type="text" name="carte" required>
            <label>Date d'expiration</label>
            <input type="text" name="expiration" required>
            <label>CVV</label>
            <input type="text" name="cvv" required>
        </div>

        <div class="order-summary">
            <h3>Total à payer : <?= calculerTotal() ?> €</h3>
        </div>

        <button type="submit" class="submit-button">Confirmer le paiement</button>
    </form>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
