<?php
session_start();
require_once 'inc.connection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $query = "SELECT id, role, motdepasse FROM enseignants WHERE identifiant = ?";
            $stmt = $bdd->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['motdepasse'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $username;

                header('Location: index.php');
                exit;
            } else {
                $error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
