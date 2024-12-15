<?php
session_start();

// bdd
include('inc.connexion.php'); 

$id_prof = $_SESSION['user_id'];

// Vérifier si l'enseignant est connecté && id dispo
if (!isset($id_prof)) {
    header('Location: login.php');
    exit;
}

// Récup les cours de l'enseignant connecté, avec les devoirs
$sql = "SELECT c.id, c.nom AS cours_nom, c.code, c.credits, c.horaires_dates, c.salle_classe,
               d.id_devoir, d.description AS devoir_description, d.date_limite AS devoir_date_limite
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
    <link rel="stylesheet" type="text/css" href="assets/style.css">
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
                </div>
                <div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>Salle</th>
                                <th>Horaires</th>
                                <th>Crédits</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars($course['salle_classe']) ?></td>
                                <td><?= htmlspecialchars($course['horaires_dates']) ?></td>
                                <td><?= htmlspecialchars($course['credits']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h3>Devoirs :</h3>
                    <?php if (empty($course['devoir_description'])): ?>
                        <p>Aucun devoir pour ce cours.</p>
                    <?php else: ?>
                        <div>
                            <h4>Code devoir: <?= htmlspecialchars($course['id_devoir']) ?></h4>
                            <p><strong>Description :</strong> <?= htmlspecialchars($course['devoir_description']) ?></p>
                            <p><strong>Date Limite :</strong> <?= htmlspecialchars($course['devoir_date_limite']) ?></p>

                            <!-- Boutons pour chaque devoir -->
                            <form method="post">
                                <input type="hidden" name="id_devoir" value="<?= htmlspecialchars($course['id_devoir']) ?>">
                                <button class="btn btn-ajouter" type="submit" name="action" value="ajouter">Ajouter un devoir</button>
                                <button class="btn btn-modifier" type="submit" name="action" value="modifier">Modifier le devoir</button>
                                <button class="btn btn-supprimer" type="submit" name="action" value="supprimer">Supprimer le devoir</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Formulaire Ajouter -->

    <div class="form-devoirs">
        <?php if (isset($_POST['action']) && $_POST['action'] === 'ajouter'): ?>
            <form method="post" action="ajouter_devoir.php">
                <h2>Ajouter un devoir</h2>
                <label for="id_cours">Cours :</label>
                <select name="id_cours" id="id_cours" required>
            <?php foreach ($cours as $course): ?>
                <option value="<?= htmlspecialchars($course['id']) ?>"><?= htmlspecialchars($course['cours_nom']) ?> (<?= htmlspecialchars($course['code']) ?>)</option>
            <?php endforeach; ?>
                </select>
                <br>
                <label for="description">Description :</label>
                <textarea name="nouvelle_description" id="description" required></textarea>
                <br>
                <label for="date_limite">Date Limite :</label>
                <input type="date" name="nouveau_delai" id="date_limite" required>
                <br>
                <label for="nouveau_code">Code du devoir :</label>
                <input type="text" name="nouveau_code" id="nouveau_code" required>
                <br>
                <button type="submit" name="action" value="ajout_confirm">Confirmer l'Ajout</button>
            </form>
        <!-- Formulaire Modifier -->
        <?php elseif (isset($_POST['action']) && $_POST['action'] === 'modifier'): ?>
            <form method="post" action="modifer_devoir.php">
            
                <label for="id_devoir">ID du devoir :</label>
                <input type="text" size="15" name="id_devoir" required>
                <br>
                <label for="description">Nouvelle description :</label>
                <input type="text" size="15" name="modif_devoir" required>
                <br>
                <label for="date_limite">Nouvelle date limite :</label>
                <input type="date" name="new_date_limite_devoir" required>
                <br>
                <input type="submit" name="action" value="modif_confirm">Confirmer la modification</input>
            </form>
        <!-- Formulaire Supprimer -->
        <?php elseif (isset($_POST['action']) && $_POST['action'] === 'supprimer'): ?>
            <form method="post" action="supprimer_devoir.php">
                <label>Entrer le code du devoir à supprimer</label><input type="text" size="15" name="devoir_delete">
                <input type="submit" name="action" value="suppr_confirm">Supprimer</input>
            </form>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>
