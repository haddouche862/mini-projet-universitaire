<?php 
session_start();
include('inc.connexion.php'); // bdd

//  si l'utilisateur est connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Verification du role (admin ou prof)
$query = "SELECT role FROM enseignants WHERE id = :user_id";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$role_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$role_data) {
    header('Location: login.php');
    exit;
}

$role = $role_data['role'];

// Frecup les cours
function getCourses() {
    global $bdd;
    $query = "SELECT c.id, c.nom, c.horaires_dates, c.salle_classe, e.identifiant AS professeur 
              FROM cours c
              JOIN cours_enseignants ce ON c.id = ce.id_cours
              JOIN enseignants e ON ce.id_prof = e.id";
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTeacherCourses() {
    global $bdd;
    $query = "
        SELECT 
            e.id AS enseignant_id, 
            e.identifiant AS enseignant, 
            c.nom AS cours_nom, 
            c.code AS cours_code, 
            c.credits AS cours_credits
        FROM enseignants e
        JOIN cours_enseignants ce ON e.id = ce.id_prof
        JOIN cours c ON ce.id_cours = c.id";
    
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$teacher_courses = getTeacherCourses();

// recupere l'emploi du temps de l'enseignant
function getTeacherSchedule($user_id) {
    global $bdd;
    $query = "SELECT c.nom, c.horaires_dates, c.salle_classe 
              FROM cours c
              JOIN cours_enseignants ce ON c.id = ce.id_cours
              WHERE ce.id_prof = :user_id";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$courses = getCourses();
$teacher_schedule = getTeacherSchedule($user_id);

//recuprer les enseignants 
function getTeachers() {
    global $bdd;
    $query = "SELECT id, identifiant FROM enseignants";
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$teachers = getTeachers();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Admin/Enseignant</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header>
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <nav>
        <ul>
            <li><a class="btn" href="session_deconnexion.php">Se déconnecter</a></li>
        </ul>
    </nav>
</header>
<main>
     <?php if ($role === 'admin') { ?>
        <!-- Section gestion des cours -->
        <section>
            <h2>Gestion des Cours</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cours</th>
                        <th>Horaires</th>
                        <th>Professeur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['nom']); ?></td>
                            <td><?php echo htmlspecialchars($course['horaires_dates']); ?></td>
                            <td><?php echo htmlspecialchars($course['professeur']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section>
    <h2>Liste des Enseignants et Cours</h2>
    <table>
        <thead>
            <tr>
                <th>Enseignant</th>
                <th>Nom du Cours</th>
                <th>Code</th>
                <th>Crédits</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teacher_courses as $course) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['enseignant']); ?></td>
                    <td><?php echo htmlspecialchars($course['cours_nom']); ?></td>
                    <td><?php echo htmlspecialchars($course['cours_code']); ?></td>
                    <td><?php echo htmlspecialchars($course['cours_credits']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div>
                <a class="btn" href="gestion_cours.php">Gestion des cours</a>
                <a class="btn" href="gestion_enseignants.php">Gestion des Enseignants</a>
            </div>
</section>

   

    <?php } elseif ($role === 'prof') { ?>
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
                    <?php foreach ($teacher_schedule as $course) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['nom']); ?></td>
                            <td><?php echo htmlspecialchars($course['horaires_dates']); ?></td>
                            <td><?php echo htmlspecialchars($course['salle_classe']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <section>
    <h2>Devoirs Attribués</h2>
    <table>
        <thead>
            <tr>
                <th>Cours</th>
                <th>Description</th>
                <th>Date Limite</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // devoirs en fonction des cours de l'enseignant
            function getTeacherAssignments($user_id) {
                global $bdd;
                $query = "SELECT d.description, d.date_limite, c.nom AS cours, e.identifiant AS enseignant 
                          FROM devoirs d
                          JOIN cours c ON d.id_cours = c.id
                          JOIN cours_enseignants ce ON c.id = ce.id_cours
                          JOIN enseignants e ON ce.id_prof = e.id
                          WHERE ce.id_prof = :user_id";
                $stmt = $bdd->prepare($query);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $teacher_assignments = getTeacherAssignments($user_id);

            if (empty($teacher_assignments)) { ?>
                <tr>
                    <td colspan="4">Aucun devoir attribué pour l'instant.</td>
                </tr>
            <?php } else { 
                foreach ($teacher_assignments as $assignment) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($assignment['cours']); ?></td>
                        <td><?php echo htmlspecialchars($assignment['description']); ?></td>
                        <td><?php echo htmlspecialchars($assignment['date_limite']); ?></td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
    <a class="btn" href="cours-enseignants.php">Gérer les Devoirs</a>
</section>

    <?php } ?>
</main>
<footer>
        <p>&copy; Maryem-alysson-kheira-ines</p>
    </footer>
</body>
</html>
