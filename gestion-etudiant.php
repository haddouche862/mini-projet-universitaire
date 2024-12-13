<?php 
session_start();

require 'inc.functions.php';
require 'inc.connexion.php'; // Connexion à la base de données

if (!isConnecte()) {

    adddMessageAlert("Vous devez d'abord vous connecter.");
    header('Location: login.php');
    exit;
    }

// Variables pour afficher les messages d'erreur ou succès
$error = '';
$success = '';

// Ajout d'un nouvel étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $identifiant = $_POST['identifiant'];
    $formation = $_POST['formation'];

    // Générer un mot de passe aléatoire
    $motdepasse = bin2hex(random_bytes(8)); // 16 caractères hexadécimaux

    // Définir le rôle comme "étudiant" par défaut
    $role = "etudiant";

    if (!empty($identifiant) && !empty($formation)) {
        $query = "INSERT INTO etudiants (identifiant, formation, motdepasse, role) VALUES (?, ?, ?, ?)";
        $stmt = $bdd->prepare($query);
        if ($stmt->execute([$identifiant, $formation, $motdepasse, $role])) {
            $success = "Nouvel étudiant ajouté avec succès.";
        } else {
            $error = "Erreur lors de l'ajout de l'étudiant.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Mise à jour de la formation d'un étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $etudiant_id = $_POST['etudiant_id'];
    $nouvelle_formation = $_POST['nouvelle_formation'];

    if (!empty($etudiant_id) && !empty($nouvelle_formation)) {
        $query = "UPDATE etudiants SET formation = ? WHERE id = ?";
        $stmt = $bdd->prepare($query);
        if ($stmt->execute([$nouvelle_formation, $etudiant_id])) {
            $success = "Formation mise à jour avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Suppression d'un étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $etudiant_id = $_POST['etudiant_id'];

    if (!empty($etudiant_id)) {
        $query = "DELETE FROM etudiants WHERE id = ?";
        $stmt = $bdd->prepare($query);
        if ($stmt->execute([$etudiant_id])) {
            $success = "Étudiant supprimé avec succès.";
        } else {
            $error = "Erreur lors de la suppression de l'étudiant.";
        }
    } else {
        $error = "L'identifiant de l'étudiant est manquant.";
    }
}

// Déterminer l'ordre de tri
$order_by = 'id ASC'; // Valeur par défaut
if (isset($_GET['tri'])) {
    if ($_GET['tri'] === 'identifiant') {
        $order_by = 'identifiant ASC';
    } elseif ($_GET['tri'] === 'formation') {
        $order_by = 'formation ASC';
    }
}

// Récupération des étudiants
$query = "SELECT * FROM etudiants ORDER BY $order_by";
$stmt = $bdd->query($query);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des étudiants</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Gestion des étudiants</h1>

        <!-- Messages -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Liste des étudiants -->
        <h2>Liste des étudiants</h2>

        <form method="GET">
            <label for="tri">Trier par :</label>
            <select name="tri" id="tri">
                <option value="id" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'id') ? 'selected' : ''; ?>>Id</option>
                <option value="identifiant" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'identifiant') ? 'selected' : ''; ?>>Identifiant (alphabétique)</option>
                <option value="formation" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'formation') ? 'selected' : ''; ?>>Formation</option>
            </select>
            <button type="submit">Appliquer</button>
        </form>
        
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Identifiant</th>
                <th>Formation</th>
                <th>Supprimer l'étudiant</th>
            </tr>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($etudiant['id']); ?></td>
                    <td><?php echo htmlspecialchars($etudiant['identifiant']); ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="modifier">
                            <input type="hidden" name="etudiant_id" value="<?php echo $etudiant['id']; ?>">
                            <select name="nouvelle_formation">
                                <option value="LP" <?php echo ($etudiant['formation'] === 'LP') ? 'selected' : ''; ?>>LP</option>
                                <option value="DEUST" <?php echo ($etudiant['formation'] === 'DEUST') ? 'selected' : ''; ?>>DEUST</option>
                            </select>
                            <button type="submit">Modifier</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="etudiant_id" value="<?php echo $etudiant['id']; ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Formulaire pour ajouter un étudiant -->
        <h2>Ajouter un nouvel étudiant</h2>
        <form method="POST">
            <input type="hidden" name="action" value="ajouter">
            <label>Identifiant :</label>
            <input type="text" name="identifiant" required>
            <select name="formation">
                <option value="LP">LP</option>
                <option value="DEUST">DEUST</option>
            </select>
            <button type="submit">Ajouter</button>
        </form>
    </div>
    <footer>
        <p>&copy; Maryem-alysson-kheira-ines</p>
    </footer>
</body>
</html>
