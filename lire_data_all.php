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
	
	/* On peut lire la requête ci-dessous comme cela :
	   La requête ('query') est de sélectionner (SELECT) tout (=> *) ce qui est dans la table 'bibliotheque' 
	   de la BDD définie par $dbb et de stocker toute la réponse dans la variable $requete.
	   Ce qui est contenu dans la variable $requete n'est pas exploitable. Il faut aller plus loin. */
	$requete = $bdd->query('SELECT * FROM cours');
	
	/* On va traiter la réponse ($requete) entrée par entrée avec une boucle while.
	   On va aller chercher (=> fetch) chaque entrée de la table successivement et on va stocker les valeurs
	   dans un tableau associatif $data qui contient les valeurs de chaque champ pour toutes les entrées.
	   On accède alors aux identifiants de cette façon => $data['identifiant']. */
	while ($data = $requete->fetch())
	{
		if (!$data) // On teste si la réponse à la requête est vide.
		{
			echo 'La BDD n\'existe pas ou est vide.';
			break;
		}
		else
		{
			// echo 'Titre : '.$data['titre'].'<br>';
			echo 'cours : '.$data['nom'].' - code : '.$data['code'].' - Formation : '.$data['formation'].'<br>';
		}
	}
	/* La requête fetch renvoie un booléen faux ('false') lorsqu'on est arrivé à la fin des données.
	   La boucle while s'arrête donc. 
	   La ligne ci-dessous indique qu'il faut "fermer le curseur qui parcourt les données".
	   Il est impératif de le faire afin d'éviter tout problème lors de la requête suivante. */
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