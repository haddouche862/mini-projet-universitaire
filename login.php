<?php
session_start();
require_once 'inc.connexion.php'; 

$error = '';

// Vérification 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifiant = $_POST['username']; 
    $password = $_POST['password'];

   
    $query = "SELECT id, role, motdepasse FROM enseignants WHERE identifiant = ?";
    $stmt = $bdd->prepare($query);
    $stmt->execute([$identifiant]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['motdepasse']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = 'prof'; 
        $_SESSION['username'] = $identifiant;
        header('Location: index.php');
        exit;
    }

    // Si non trouvé dans enseignants, vérifier dans  étudiants
    $query = "SELECT id, role, motdepasse FROM etudiants WHERE identifiant = ?";
    $stmt = $bdd->prepare($query);
    $stmt->execute([$identifiant]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student && $password === $student['motdepasse']) {
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['user_role'] = 'etudiant'; 
        $_SESSION['username'] = $identifiant;
        header('Location: index_etudiant.php');
        exit;
    }

    $error = "Nom d'utilisateur ou mot de passe incorrect.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Page de connexion</title>
</head>
<body>
    <div class="container">
        <div class="login">
            <h1>Bienvenue dans votre espace de connexion de l'Université !</h1>
        <main class="main-content">
            <h2>Veuillez entrer vos informations d'authentification</h2>
            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="username" class="form-label">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                <button class="btn" type="submit">Se connecter</button>
            </form>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
        </main>
        </div>
    </div>
    <footer>
        <p>&copy; Maryem - Alyson - Kheira - Ines</p>
    </footer>
</body>
</html>
