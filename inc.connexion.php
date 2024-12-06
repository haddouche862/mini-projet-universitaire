<?php
	// Param�tres de connexion
	$serveur  = "localhost:3307";
	$database = "universit";
	$user     = "root";
	$password = "Younes.124";
	
	
	// CONNEXION A LA BASE DE DONNEES mysql //
	/* 
		La structure try ... catch permet de r�aliser les actions suivantes :
		PHP essaie d'ex�cuter les instructions pr�sentes � l'int�rieur du bloc "try"
		En cas d'erreur, les instructions du bloc "catch" sont ex�cut�es.
		Dans ce cas, un message d'erreur est affich�.
	*/
		
		/* 
			PDO est une extension "orient�e objet". Il faut donc v�rifier que l'extension PDO est bien activ�e sur votre version de PHP (cf cours)
			On travaille en local : localhost
			La BDD s'appelle "UE_L204"
			Le login par d�faut est "root"
			Le mot de passe (sur MAMP) est aussi "root". Il peut �tre vide pour WampServer.
			On cr�e un objet $bdd
		*/

		// Connexion � la base de donn�es
		// $bdd est un objet correspondant � la connexion � la BDD
		try {
			$bdd = new PDO("mysql:host=localhost;dbname=universit;charset=utf8", "root", "");
			
			// Récupérer toutes les tables
			$requete = $bdd->query('SHOW TABLES');
			
			while ($table = $requete->fetch()) {
				$tableName = $table[0];
				
				
				$query = $bdd->query("SELECT * FROM $tableName");
				
			}
		}
		catch(Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
?>