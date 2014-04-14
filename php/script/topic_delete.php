<?php

	header('Content-Type: text/html; charset=utf-8');

	session_start();

    if (isset($_SESSION['user']) && isset($_POST['topic_id']) && !$_SESSION['user']['banned']) {
        try {

        	$_POST['topic_id'] = mysql_real_escape_string($_POST['topic_id']);

			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

			// Vérifie que l'user est bien l'auteur du post
			$check_query = $bdd -> prepare('SELECT user_id FROM topic WHERE id ='.$_POST['topic_id']);
			$check_query -> execute();
			$check_data = $check_query->fetch();
			
			if($check_data[0] == $_SESSION['user']['id'] OR $_SESSION['user']['admin']){
				$query = $bdd -> prepare('DELETE FROM topic WHERE id ='.$_POST['topic_id']); 
				$query -> execute();
			}

        } catch ( Exception $e ) {
             echo "Erreur : BDD";
        }
    }
    else
        echo "Erreur : Connexion";

?>