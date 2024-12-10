<?php
session_start();

// bdd
include('inc.connexion.php'); 

$id_prof = $_SESSION['id_prof']; 

// Vérifier si l'enseignant est connecté && id dispo
if (!isset($id_prof)) {
    header('Location: login.php');
    exit;
}


// Récup les cours de l'enseignant connecté
$sql = "SELECT c.id, c.nom AS cours_nom, c.code, c.credits, c.horaires_dates, c.salle_classe,
                d.description AS devoir_description, d.date_limite AS devoir_date_limite
        FROM cours c
        JOIN cours_enseignants ce ON c.id = ce.id_cours
        LEFT JOIN devoirs d ON c.id = d.id_cours
        WHERE ce.id_prof = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$id_prof]);
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes cours</title>
</head>
<body>
    <header>
        <a href="index.php">Accueil</a>
    </header>
    <div class="cours-enseignant-container">
        <h1>Mes cours</h1>
        <?php if (empty($cours)): ?>
            <p>Aucun cours associé à cet enseignant.</p>
        <?php else: ?>
            <?php foreach ($cours as $course): ?>
                <div class="cours-enseignant">
                    <h2><?= htmlspecialchars($course['cours_nom']) ?> (<?= htmlspecialchars($course['code']) ?>)</h2>
                    <p>Salle : <?= htmlspecialchars($course['salle_classe']) ?></p>
                    <p>Horaires : <?= htmlspecialchars($course['horaires_dates']) ?></p>
                    <p>Crédits : <?= htmlspecialchars($course['credits']) ?></p>

                    <p><strong>Devoirs :</strong>
                    <?php 
                        if (isset($course['devoir_description']) && !empty($course['devoir_description'])) {
                            echo htmlspecialchars($course['devoir_description']) . "<br>";
                            echo "Date limite : " . htmlspecialchars($course['devoir_date_limite']);
                        } else {
                            echo 'Aucun devoir assigné.';
                        }
                    ?>
                </p>

                                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
