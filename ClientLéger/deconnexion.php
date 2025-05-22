<?php
session_start();
session_destroy(); // Détruit la session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="header">
    <h1>GameTechPro</h1>
</header>

<main class="logout-container">
    <h2>Déconnexion réussie</h2>
    <p>Vous avez été déconnecté avec succès.</p>
    
    <a href="index.php" class="return-button">Retour à l'accueil</a>
</main>

<?php include 'footer.php'; ?>
</body>
</html>
