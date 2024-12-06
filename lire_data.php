<!DOCTYPE HTML>
<html>
  <head>
    <title>UE L204 - Exemples de dialogue avec une base de données via PHP</title>
    <meta charset="utf-8"/>
	<style>
		.fieldset{width:1000px;border:1px solid black;}
	</style>
  </head>
<body>
	<fieldset class="fieldset">
		<legend><strong>Affichage du résultat de la requête</strong></legend>
	<?php
	// On charge le fichier permettant de se connecter à la bdd
	include 'inc.connexion.php';
	
	// Pour la récupération d'une partie de la BDD, on utilise la méthode des requêtes préparées permettant de se prémunir contre les injections SQL
	// On utilise la méthode "prepare" de l'extension PDO afin de préparer une requête à être lancée (http://php.net/manual/fr/pdo.prepare.php)
	// Puis la méthode "execute" de l'extension PDO pour lancer la requête après avoir inséré les paramètres (http://php.net/manual/fr/pdo.exec.php)
	
	// Etape 1 : on prépare la requête (plusieurs exemples ci-dessous, testez chacune d'elles !)
	$requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ?');
	// $requete = $bdd->prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ? ORDER BY annee'); // Il est ici implicite que c'est un classement par ordre croissant.
	// $requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ? ORDER BY annee DESC'); // Pour un classement par ordre décroissant
	// $requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ? ORDER BY annee ASC LIMIT 0,2');
	// $requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ? AND annee > 1850');
	
	// Exécution de la requête via la méthode 'execute'
	$requete->execute(array($_POST['nom_auteur'])); // Le paramètre indiqué va aller remplacer le '?' de la ligne précédente
	
	/* 
	A noter que si on a besoin d'utiliser 2 paramètres, on fait par exemple comme ceci :
	$requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = ? AND annee > ?');
	$requete->execute(array($_POST['nom_auteur'],$_POST['annee_minimum']));
	
	Une autre syntaxe évitant les '?' est possible (plus lisible lorsqu'il y a beaucoup de paramètres) :
	$requete = $bdd -> prepare('SELECT identifiant, auteur, titre, annee, exemplaires FROM bibliotheque WHERE auteur = :auteur AND annee > :annee');
	$requete->execute(array('auteur' => $_POST['nom_auteur'], 'annee' => $_POST['annee_minimum']));
	*/
	while ($data = $requete->fetch())
	{	
		echo 'Identifiant : '.$data['identifiant'].' - Auteur : '.$data['auteur'].' - Titre : '.$data['titre'].' - Année de publication : '.$data['annee'].' - Nombre d\'exemplaires : '.$data['exemplaires'].'<br>';
	}
	$requete->closeCursor();
	?>
	</fieldset>
	<br><br>
	<fieldset class="fieldset">
		<form method="post" action="index.php">
			<input type="submit" value="Retour à la page d'accueil">
		</form>
	</fieldset>
</body>
</html>