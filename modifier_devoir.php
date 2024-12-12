<!DOCTYPE HTML>
<html>
  <head>
    <title>UE L204 - Exemples de dialogue avec une base de données via PHP</title>
    <meta charset="utf-8"/>
	<style>
		.fieldset{width:800px;border:1px solid black;}
	</style>
  </head>
<body>
	<fieldset class="fieldset">
		<legend><strong>Affichage du résultat de la requête</strong></legend>
				<?php
		// On charge le fichier permettant de se connecter à la BDD
		include 'inc.connexion.php';

		// Vérifier si le formulaire a été soumis avec les bonnes données
		if (isset($_POST['modif_devoir']) && isset($_POST['new_date_limite_devoir']) && isset($_POST['id_devoir'])) {
			// Requête pour mettre à jour le devoir
			$requete = $bdd->prepare('UPDATE devoirs SET description = :description, date_limite = :date_limite WHERE id_devoir = :id_devoir');
			$requete->execute(array(
				'description' => $_POST['modif_devoir'], 
				'date_limite' => $_POST['new_date_limite_devoir'],
				'id_devoir' => $_POST['id_devoir']
			));
			echo 'Le devoir a été modifié avec succès.';
			$requete->closeCursor();
		} else {
			echo 'Veuillez remplir tous les champs.';
		}
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
