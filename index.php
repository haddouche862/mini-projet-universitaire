<?php
session_start();
include('inc.connexion.php');  // Inclut le fichier de connexion PDO

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur est un enseignant ou admin et obtenir son rôle
    $query = "SELECT role FROM enseignants WHERE id = :user_id";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $role_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($role_data) {
        $role = $role_data['role'];
    } else {
        // Si le rôle n'existe pas ou n'est pas reconnu, rediriger
        header('Location: login.php');
        exit;
    }
} else {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit;
}

// Fonction pour récupérer les cours
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

// Fonction pour récupérer les devoirs
function getAssignments() {
    global $bdd;
    $query = "SELECT d.description, d.date_limite, c.nom AS cours 
              FROM devoirs d
              JOIN cours c ON d.id_cours = c.id";
    
    $stmt = $bdd->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer l'emploi du temps de l'enseignant
function getSchedule($user_id) {
    global $bdd;
    $query = "SELECT c.nom, c.horaires_dates, c.salle_classe 
              FROM cours c
              JOIN cours_enseignants ce ON c.id = ce.id_cours
              JOIN enseignants e ON ce.id_prof = e.id
              WHERE e.id = :user_id";  
    
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

$courses = getCourses();
$assignments = getAssignments();
$teacher_schedule = getSchedule($user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Bienvenue sur le site universitaire</h1>
    <p>Utilisateur connecté : <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <nav>
        <ul>
            <li><a href="session_deconnexion.php">Se déconnecter</a></li>
            <li><a href="profile.php">Mon Profil</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if ($role == 'admin') { ?>
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
                            <td><?php echo $course['nom']; ?></td>
                            <td><?php echo $course['horaires_dates']; ?></td>
                            <td><?php echo $course['professeur']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <a href="manage_courses.php">Gestion des Cours</a>
                <a href="manage_teachers.php">Gestion des Enseignants</a>
            </div>
        </section>
    <?php } elseif ($role == 'prof') { ?>
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
                            <td><?php echo $course['nom']; ?></td>
                            <td><?php echo $course['horaires_dates']; ?></td>
                            <td><?php echo $course['salle_classe']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <a href="manage_assignments.php">Gérer les Devoirs</a>
            </div>
        </section>
    <?php } ?>
</main>

<footer>
    <p>&copy; 2024 Université - Tous droits réservés</p>
</footer>
</body>
</html>
