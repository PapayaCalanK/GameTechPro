<?php
session_start();

if (!isset($_SESSION['commande_success'])) {
    header('Location: index.php');
    exit();
}

// Supprimer l'indicateur de commande réussie
unset($_SESSION['commande_success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="header">
    <h1>GameTechPro</h1>
</header>

<main class="confirmation-container">
    <h2>Commande validée ✅</h2>
    <p>Merci pour votre achat ! Votre commande a bien été enregistrée.</p>
    <a href="index.php" class="return-button">Retour à la boutique</a>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
