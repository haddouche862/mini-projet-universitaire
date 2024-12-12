<!DOCTYPE HTML>
<html>
  <head>
    <title>Suppression d'un devoir</title>
    <meta charset="utf-8"/>
    <style>
        .fieldset{width:800px;border:1px solid black;}
    </style>
  </head>
  <body>
    <fieldset class="fieldset">
        <legend><strong>Affichage du devoir supprimé</strong></legend>
    <?php
    // On charge le fichier permettant de se connecter à la bdd
    include 'inc.connexion.php';

    // Correction de la requête : utiliser la colonne `id_devoir` au lieu de `id_devoirs`
    $requete = $bdd->prepare('DELETE FROM devoirs WHERE id_devoir = :supp_devoir');
    // Exécution de la requête avec l'ID du devoir à supprimer
    $requete->execute(array(
        'supp_devoir' => $_POST['devoir_delete']
    ));

    echo 'Le devoir a été supprimé avec succès.';
    ?>
    </fieldset>

    <fieldset class="fieldset">
        <form method="post" action="cours-enseignants.php">
            <input type="submit" value="Retour à la page des cours">
        </form>
    </fieldset>
  </body>
</html>
