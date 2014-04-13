<?php


echo "bonjour le monde";

session_start();

    if (isset($_SESSION['user']) && isset($_POST['post_id']) && isset($_POST['topic_id'])) {
        try {

			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

			// Vérifier que user est bien l'auteur
			// Vérifier qu'il n'y a pas déjà de réponse selectionné
			// Mettre en place la réponse

        } catch ( Exception $e ) {
             echo "Erreur : BDD";
        }
    }
    else
        echo "Erreur : Connexion";

/*
	$query = $bdd -> prepare('UPDATE post SET is_answer = TRUE WHERE id ='.$_POST['post_id']); 
	$query -> execute();
	$query2 = $bdd -> prepare('SELECT topic_id FROM post WHERE id ='.$_POST['post_id']);
	$query2 -> execute();
	$data = $query2->fetch();
	$query3 = $bdd -> prepare('UPDATE topic SET answered = TRUE WHERE id ='.$data[0]);
	$query3 -> execute();*/

?>