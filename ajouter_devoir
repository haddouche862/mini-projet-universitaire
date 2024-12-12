<!DOCTYPE HTML>
<html>
  <head>
    <title>Ajouter un devoir</title>
    <meta charset="utf-8"/>
	<style>
		.fieldset{width:800px;border:1px solid black;}
	</style>
  </head>
<body>
	<fieldset class="fieldset">
		<legend><strong>Affichage du nouveau devoir</strong></legend>
	<?php
	// On charge le fichier permettant de se connecter à la bdd
	include 'inc.connexion.php';
	
	// On insère des données dans une BDD avec la requête INSERT INTO
	$requete = $bdd->prepare('INSERT INTO devoirs (id_cours, description, date_limite) VALUES (:id_cours, :description, :delai)');
	
	// On indique ensuite les paramètres dans le même ordre
	$requete->execute(array(
    'id_cours' => $_POST['id_cours'],
    'description' => $_POST['nouvelle_description'],
    'delai' => $_POST['nouveau_delai']
));

	echo 'Le nouveau devoir a été ajouté dans la table \'universit\'.';
	$requete->closeCursor();
	?>
	</fieldset>
	<br><br>
	<fieldset class="fieldset">
		<form method="post" action="cours-enseignants.php">
			<input type="submit" value="Retour à la page des cours">
		</form>
	</fieldset>
</body>
</html>
