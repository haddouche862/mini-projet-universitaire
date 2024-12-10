<?php 
session_start();
include('inc.connexion.php');  // bdd

// si utilisateur connecter
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// on recupere l'edt 
function getStudentSchedule($user_id) {
    global $bdd;

    // en fonction de la formation
    $query_formation = "SELECT formation FROM etudiants WHERE id = :user_id";
    $stmt = $bdd->prepare($query_formation);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $student_data = $stmt->fetch(PDO::FETCH_ASSOC);

    $formation = $student_data ? $student_data['formation'] : null;

    if (!$formation) {
        return []; 
    }

    $query_cours = "SELECT c.nom, c.horaires_dates, c.salle_classe 
                    FROM cours c
                    WHERE c.formation = :formation OR c.formation = 'BOTH'";
    $stmt_cours = $bdd->prepare($query_cours);
    $stmt_cours->bindParam(':formation', $formation, PDO::PARAM_STR);
    $stmt_cours->execute();

    return $stmt_cours->fetchAll(PDO::FETCH_ASSOC);
}


function getAssignments($user_id) {
    global $bdd;

    $query_formation = "SELECT formation FROM etudiants WHERE id = :user_id";
    $stmt = $bdd->prepare($query_formation);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $student_data = $stmt->fetch(PDO::FETCH_ASSOC);

    $formation = $student_data ? $student_data['formation'] : null;

    if (!$formation) {
        return []; 
    }

    $query_devoirs = "SELECT d.description, d.date_limite, c.nom AS cours
                      FROM devoirs d
                      JOIN cours c ON d.id_cours = c.id
                      WHERE c.formation = :formation OR c.formation = 'BOTH'";
    $stmt_devoirs = $bdd->prepare($query_devoirs);
    $stmt_devoirs->bindParam(':formation', $formation, PDO::PARAM_STR);
    $stmt_devoirs->execute();

    return $stmt_devoirs->fetchAll(PDO::FETCH_ASSOC);
}

// Récuperer l'emploi du temps et les devoirs
$student_schedule = getStudentSchedule($user_id);
$assignments = getAssignments($user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Étudiant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bienvenue</h1>
        <p>Utilisateur connecté : <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
        <nav>
            <ul>
                <li><a href="session_deconnexion.php">Se déconnecter</a></li>
                <li><a href="profile.php">Mon Profil</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Mon Emploi du Temps</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Horaires</th>
                        <th>Salle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($student_schedule)) { ?>
                        <tr>
                            <td colspan="3">Aucun emploi du temps trouvé.</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($student_schedule as $course) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($course['nom']); ?></td>
                                <td><?php echo htmlspecialchars($course['horaires_dates']); ?></td>
                                <td><?php echo htmlspecialchars($course['salle_classe']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Mes Devoirs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Description</th>
                        <th>Date Limite</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)) { ?>
                        <tr>
                            <td colspan="3">Aucun devoir trouvé.</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($assignments as $assignment) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($assignment['cours']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['description']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['date_limite']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section>
            <div>
                <a href="view_courses.php" class="btn">Voir mes Cours</a>
                <a href="my_assignments.php" class="btn">Voir mes Devoirs</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Université - Tous droits réservés</p>
    </footer>
</body>
</html>
