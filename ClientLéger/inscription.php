<?php
session_start();
require 'config.php'; // Connexion à la base de données

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données utilisateur
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Vérification des champs
    if (empty($email) || empty($password) || empty($password_confirm)) {
        $error = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email est déjà utilisé
        $check = $pdo->prepare("SELECT id FROM user WHERE email = :email");
        $check->bindParam(':email', $email, PDO::PARAM_STR);
        $check->execute();

        if ($check->rowCount() > 0) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Hachage sécurisé du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur avec requête préparée
            $stmt = $pdo->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $success = "Inscription réussie ! <a href='connexion.php'>Se connecter</a>";
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - GameTechPro</title>
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
</head>
<body>
    <header class="header">
        <a href="index.php" class="back-button">← Retour</a>
        <h1>GameTechPro</h1>
    </header>

    <div class="container">
        <h2>Inscription</h2>

        <!-- Messages d'erreur ou de succès -->
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Formulaire d'inscription sécurisé -->
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required 
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required minlength="8" placeholder="8 caractères minimum">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="submit-button">S'inscrire</button>
        </form>

        <div class="login-link">
            Déjà un compte ? <a href="connexion.php">Se connecter</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
