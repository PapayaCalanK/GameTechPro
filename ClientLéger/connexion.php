<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Vérifier si l'utilisateur vient de se déconnecter
$logoutMessage = isset($_GET['logout']) ? "Vous avez été déconnecté avec succès." : null;

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des entrées
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Vérification des champs remplis
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } else {
        // Vérifier si l'utilisateur existe avec requête préparée
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et que le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email']; // Stocker l'utilisateur en session
            header("Location: index.php"); // Redirection après connexion
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
<header class="header center-title">
    <a href="index.php" class="back-button">← Retour</a>
    <h1>GameTechPro</h1>
</header>

    <div class="login-container">
        <h2>Connexion</h2>

        <!-- Message de déconnexion -->
        <?php if ($logoutMessage) : ?>
            <p class="success-message"><?= htmlspecialchars($logoutMessage) ?></p>
        <?php endif; ?>

        <!-- Message d'erreur -->
        <?php if ($error) : ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Formulaire de connexion sécurisé -->
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-button">Se connecter</button>
        </form>

        <div class="register-link">
            Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
