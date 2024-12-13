<?php
session_start();

// Connexion à la base de données
include('inc.connexion.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Affichage des cours, enseignants et recherche des étudiants</title>
    <meta charset="utf-8"/>
    <style>
        .fieldset { width: 1000px; border: 1px solid black; margin-bottom: 20px; padding: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <!-- Section pour afficher les cours et enseignants -->
    <fieldset class="liste_cours">
        <legend><strong>Liste des cours et enseignants</strong></legend>

        <?php
        // Requête pour récupérer les cours et regrouper les enseignantsxsxs
        $sql = "SELECT c.id, c.nom AS cours_nom, c.code, GROUP_CONCAT(e.identifiant SEPARATOR ', ') AS enseignants
        FROM cours c
        JOIN cours_enseignants ce ON c.id = ce.id_cours
        JOIN enseignants e ON ce.id_prof = e.id
        GROUP BY c.id, c.nom, c.code";

$stmt = $bdd->prepare($sql);
$stmt->execute();
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

 <?php if (empty($cours)): ?>
     <p>Aucun cours associé à cet enseignant.</p>
 <?php else: ?>
    <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom du Cours</th>
                        <th>Code</th>
                        <th>Enseignant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cours as $course): ?>
                        <tr>
                            <td><?= htmlspecialchars($course['id']) ?></td>
                            <td><?= htmlspecialchars($course['cours_nom']) ?></td>
                            <td><?= htmlspecialchars($course['code']) ?></td>
                            <td><?= htmlspecialchars($course['enseignants']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </fieldset>

    <!-- Formulaire de recherche des étudiants -->
    <h2>Rechercher les étudiants de l'université</h2>
    <form method="post">
        <label for="formation">Formation:</label>
        <select name="formation" id="formation">
            <option value="LP">LP</option>
            <option value="DEUST">DEUST</option>
        </select>
        <input type="submit" value="Rechercher">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $formation = $_POST['formation'];

        // Requête pour récupérer les étudiants par formation
        $sql_etudiants = "SELECT identifiant, formation FROM etudiants WHERE formation = ?";
        $stmt = $bdd->prepare($sql_etudiants);
        $stmt->execute([$formation]);
        $result_etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Liste des étudiants en $formation</h2>";
        echo "<table>
                <tr>
                    <th>Nom</th>
                    <th>Formation</th>
                </tr>";

        if (count($result_etudiants) > 0) {
            foreach ($result_etudiants as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['identifiant']) . "</td>
                        <td>" . htmlspecialchars($row['formation']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Aucun étudiant trouvé pour cette formation</td></tr>";
        }
        echo "</table>";
    }
    ?>
    </fieldset>
    <br><br>
    <!-- Retour à l'accueil -->
    <fieldset class="fieldset">
        <form method="post" action="index.php">
            <input type="submit" value="Retour à la page d'accueil">
        </form>
    </fieldset>
</body>
</html>
