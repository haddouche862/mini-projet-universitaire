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

// Ajout d'un nouvel enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter_enseignant') {
    $identifiant = $_POST['identifiant'];
    $role = $_POST['role']; // Récupération du rôle
   
// Générer un mot de passe aléatoire
$motdepasse = bin2hex(random_bytes(8)); // 16 caractères hexadécimaux


    if (!empty($identifiant) && !empty($role)) {
        $query = "INSERT INTO enseignants (identifiant, motdepasse, role) VALUES (?, ?, ?)";
        $stmt = $bdd->prepare($query);
        if ($stmt->execute([$identifiant, $motdepasse, $role])) {
            $success = "Nouvel enseignant ajouté avec succès.";
        } else {
            $error = "Erreur lors de l'ajout de l'enseignant.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Attribution d'un cours à un enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'attribuer_cours') {
    $id_prof = $_POST['id_prof'];
    $id_cours = $_POST['id_cours'];

    // Vérifier si l'enseignant a le rôle "admin"
    $query_role = "SELECT role FROM enseignants WHERE id = ?";
    $stmt_role = $bdd->prepare($query_role);
    $stmt_role->execute([$id_prof]);
    $role_enseignant = $stmt_role->fetchColumn();

    if ($role_enseignant === 'admin') {
        $error = "Un enseignant avec le rôle 'admin' ne peut pas être attribué à un cours.";
    } else {
        if (!empty($id_prof) && !empty($id_cours)) {
            $query = "INSERT INTO cours_enseignants (id_prof, id_cours) VALUES (?, ?)";
            $stmt = $bdd->prepare($query);
            if ($stmt->execute([$id_prof, $id_cours])) {
                $success = "Cours attribué avec succès.";
            } else {
                $error = "Erreur lors de l'attribution du cours.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
}

// Suppression d'un enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer_enseignant') {
    $id_enseignant = $_POST['id_prof'];

    if (!empty($id_enseignant)) {
        // Supprimer les cours associés à l'enseignant
        $query_cours_enseignants = "DELETE FROM cours_enseignants WHERE id_prof = ?";
        $stmt_cours_enseignants = $bdd->prepare($query_cours_enseignants);
        $stmt_cours_enseignants->execute([$id_enseignant]);

        // Supprimer l'enseignant
        $query_enseignant = "DELETE FROM enseignants WHERE id = ?";
        $stmt_enseignant = $bdd->prepare($query_enseignant);
        if ($stmt_enseignant->execute([$id_enseignant])) {
            $success = "Enseignant supprimé avec succès.";
        } else {
            $error = "Erreur lors de la suppression de l'enseignant.";
        }
    } else {
        $error = "Veuillez sélectionner un enseignant à supprimer.";
    }
}

// Suppression d'un cours d'un enseignant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer_cours') {
    $id_prof = $_POST['id_prof'];
    $id_cours = $_POST['id_cours'];

    if (!empty($id_prof) && !empty($id_cours)) {
        // Déboguer les valeurs reçues
        var_dump($id_prof, $id_cours);  // Debugging

        // Supprimer l'association entre l'enseignant et le cours
        $query = "DELETE FROM cours_enseignants WHERE id_prof = ? AND id_cours = ?";
        $stmt = $bdd->prepare($query);
        if ($stmt->execute([$id_prof, $id_cours])) {
            $success = "Cours supprimé de l'enseignant avec succès.";
        } else {
            $error = "Erreur lors de la suppression du cours.";
            // Déboguer l'erreur SQL
            var_dump($stmt->errorInfo());
        }
    } else {
        $error = "Veuillez sélectionner un enseignant et un cours.";
    }
}

// Déterminer l'ordre de tri
$order_by = 'id ASC'; // Valeur par défaut
if (isset($_GET['tri'])) {
    if ($_GET['tri'] === 'identifiant') {
        $order_by = 'identifiant ASC';
    } elseif ($_GET['tri'] === 'role') {
        $order_by = 'role ASC';
    }
}

// Récupération des enseignants
$query = "SELECT * FROM enseignants ORDER BY $order_by";
$stmt = $bdd->query($query);
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des cours
$query_cours = "SELECT * FROM cours ORDER BY id ASC";
$stmt_cours = $bdd->query($query_cours);
$cours = $stmt_cours->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Gestion des enseignants</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <h1>Gestion des enseignants</h1>

        <!-- Messages -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Liste des enseignants -->
        <h2>Liste des enseignants</h2>

        <form method="GET">
            <label for="tri">Trier par :</label>
            <select name="tri" id="tri">
                <option value="id" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'id') ? 'selected' : ''; ?>>Id</option>
                <option value="identifiant" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'identifiant') ? 'selected' : ''; ?>>Identifiant (alphabétique)</option>
                <option value="role" <?php echo (isset($_GET['tri']) && $_GET['tri'] === 'role') ? 'selected' : ''; ?>>Rôle</option>
            </select>
            <button type="submit">Appliquer</button>
        </form>
        
        <table border="1">
            <tr>
                <th>ID</id>
                <th>Identifiants</th>
                <th>Rôle</th>
                <th>Cours attribués</th>
                <th>Supprimer l'enseignant</th>
            </tr>
            <?php foreach ($enseignants as $enseignant): ?>
                <tr>
                    <td><?php echo htmlspecialchars($enseignant['id']); ?></td>
                    <td><?php echo htmlspecialchars($enseignant['identifiant']); ?></td>
                    <td><?php echo htmlspecialchars($enseignant['role']); ?></td> <!-- Affichage du rôle -->
                    <td>
                        <?php
                        $query = "SELECT c.nom FROM cours c 
                                INNER JOIN cours_enseignants ec ON c.id = ec.id_cours 
                                WHERE ec.id_prof = ?";
                        $stmt = $bdd->prepare($query);
                        $stmt->execute([$enseignant['id']]);
                        $cours_enseignants = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        echo htmlspecialchars(implode(", ", $cours_enseignants));
                        ?>
                    </td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="prof_id" value="<?php echo $enseignant['id']; ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <!-- Formulaire pour supprimer un cours d'un enseignant -->
        <h2>Supprimer un cours d'un enseignant</h2>
        <form method="POST">
            <label>Enseignant :</label>
            <select name="id_prof" required>
                <?php foreach ($enseignants as $enseignant): ?>
                    <option value="<?php echo $enseignant['id']; ?>"><?php echo htmlspecialchars($enseignant['identifiant']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Cours :</label>
            <select name="id_cours" required>
                <?php foreach ($cours as $cours_item): ?>
                    <option value="<?php echo $cours_item['id']; ?>"><?php echo htmlspecialchars($cours_item['nom']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Supprimer</button>
        </form>
            
        <h2>Attribuer un cours</h2>
        <form method="POST">
            <input type="hidden" name="action" value="attribuer_cours">
            <label>Enseignant :</label>
            <select name="id_prof" required>
                <?php foreach ($enseignants as $enseignant): ?>
                    <option value="<?php echo $enseignant['id']; ?>"><?php echo htmlspecialchars($enseignant['identifiant']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Cours :</label>
            <select name="id_cours" required>
                <?php foreach ($cours as $cours_item): ?>
                    <option value="<?php echo $cours_item['id']; ?>"><?php echo htmlspecialchars($cours_item['nom']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Attribuer</button>
        </form>

        <!-- Formulaire pour ajouter un enseignant -->
        <h2>Ajouter un nouvel enseignant</h2>
        <form method="POST">
            <input type="hidden" name="action" value="ajouter_enseignant">
            <label>Identifiant :</label>
            <input type="text" name="identifiant" required>
            <label>Rôle :</label>
            <select name="role" required>
                <option value="prof">prof</option>
                <option value="admin">admin</option>
            </select>
            <button type="submit">Ajouter</button>
        </form>
        </div>

        
    <footer>
        <p>&copy; Maryem-alysson-kheira-ines</p>
    </footer>
</body>
</html>
