<?php 
session_start();
include('inc.connexion.php');  // bdd

// si utilisateur connecté
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

    // Recupere les cours du semestre 1
    $query_cours = "SELECT c.nom, c.horaires_dates, c.salle_classe, 
    DAYNAME(c.horaires_dates) AS jour, c.horaires_dates, c.code, c.credits
    FROM cours c
    WHERE (c.formation = :formation OR c.formation = 'BOTH') 
    AND c.semestre = 2
    ORDER BY c.horaires_dates"; // Tri par horaires

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


$student_schedule = getStudentSchedule($user_id);
$assignments = getAssignments($user_id);


$days_of_week = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];

$schedule_by_day = [
    'Lundi' => [],
    'Mardi' => [],
    'Mercredi' => [],
    'Jeudi' => [],
    'Vendredi' => []
];


foreach ($student_schedule as $course) {
    foreach ($days_of_week as $day) {
        if (stripos($course['horaires_dates'], $day) !== false) {
            $schedule_by_day[$day][] = $course;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Étudiant</title>
    <link rel="stylesheet" href="assets/style.css">
   
</head>
<body>
    <header>
        <h1>Bienvenue</h1>
        <p>Utilisateur connecté : <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
        <nav>
            <ul>
                <li><a  class="btn" href="session_deconnexion.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <section>
    <h2>Mon Emploi du Temps</h2>
    <table>
        <thead>
            <tr>
                <?php foreach ($days_of_week as $day) { ?>
                    <th><?php echo $day; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach ($days_of_week as $day) { ?>
                    <td>
                        <?php 
                        if (!empty($schedule_by_day[$day])) {
                            foreach ($schedule_by_day[$day] as $course) {
                                echo "<p><strong>" . htmlspecialchars($course['nom']) . "</strong><br>" . 
                                     htmlspecialchars($course['horaires_dates']) . "<br>" . 
                                     "<em>Salle : " . htmlspecialchars($course['salle_classe']) . "</em></p>";
                            }
                        } else {
                            echo "Aucun cours.";
                        }
                        ?>
                    </td>
                <?php } ?>
            </tr>
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
            <a  class="btn" href="#.php" class="btn">Voir mes Devoirs</a>
        </section>


         <section>
            <h2>Mes Cours</h2>
            <div class="course-list">
                <?php foreach ($student_schedule as $course) { ?>
                    <div class="course-item">
                        <h3><?php echo htmlspecialchars($course['nom']); ?></h3>
                        <p class="code"><strong>Code :</strong> <?php echo htmlspecialchars($course['code']); ?></p>
                        <p class="credits"><strong>Crédits :</strong> <?php echo htmlspecialchars($course['credits']); ?></p>
                    </div>
                <?php } ?>
            </div>
            <a class="btn" href="liste_promo.php" class="btn">Voir mes Cours</a>
        </section>

    </main>
    <footer>
        <p>&copy; Maryem-alysson-kheira-ines</p>
    </footer>
</body>
</html>
