<?php

	session_start();

    if (isset($_SESSION['user']) && isset($_POST['post_id']) && isset($_POST['topic_id'])) {
        try {

			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			
			// Vérifie qu'il n'y a pas déjà de réponse selectionné et que user est bien l'auteur
			$check_query = $bdd -> prepare('SELECT * FROM topic WHERE id ='.$_POST['topic_id']);
			$check_query -> execute();
			$check_data = $check_query->fetch();			
			// Vérifie que user la réponse sélectionnée n'a pas été écrit par l'auteur
			$check_query2 = $bdd -> prepare('SELECT user_id FROM post WHERE id ='.$_POST['post_id']);
			$check_query2 -> execute();
			$check_data2 = $check_query2->fetch();
			
			if($check_data['answered'] == false AND $check_data['user_id'] == $_SESSION['user']['id'] AND $check_data2[0] != $_SESSION['user']){
				$query = $bdd -> prepare('UPDATE post SET is_answer = TRUE WHERE id ='.$_POST['post_id']); 
				$query -> execute();
				$query2 = $bdd -> prepare('SELECT topic_id FROM post WHERE id ='.$_POST['post_id']);
				$query2 -> execute();
				$data = $query2->fetch();
				$query3 = $bdd -> prepare('UPDATE topic SET answered = TRUE WHERE id ='.$data[0]);
				$query3 -> execute();
				$query4 = $bdd -> prepare('UPDATE user SET nb_euro = nb_euro +'.$check_data['pot_euro'].', nb_point = nb_point + '.$check_data['pot_point'].' WHERE id ='.$check_data2[0]);
				$query4 -> execute();
			}

        } catch ( Exception $e ) {
             echo "Erreur : BDD";
        }
    }
    else
        echo "Erreur : Connexion";
?>