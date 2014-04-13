<?php
	session_start();

    if (isset($_SESSION['user']) && isset($_POST['data']) && !$_SESSION['user']['banned']) {
		$data = json_decode($_POST['data'])->data;

		if(isset($data->post_id) && isset($data->content)) {
	        try {

	        	$data->post_id = mysql_real_escape_string($data->post_id);
	        	$data->content = htmlentities(mysql_real_escape_string($data->content));

				$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

				// Vérifie que l'user est bien l'auteur du post
				$check_query = $bdd -> prepare('SELECT user_id FROM post WHERE id ='.$data->post_id);
				$check_query -> execute();
				$check_data = $check_query->fetch();
				
				if($check_data[0] == $_SESSION['user']['id'] OR $_SESSION['user']['admin']){
					$query = $bdd -> prepare('UPDATE post SET content = "'.$data->content.'", last_edit = NOW() WHERE id ='.$data->post_id); 
					$query -> execute();
	        		$r = array('success' => array('title' => 'Message mis à jour', 'msg' => 'Votre message à correctement été modifié'));
				} else 
	        		$r = array('error' => array('title' => 'Erreur', 'msg' => 'Vous n\'avez pas le droit d\'effectuer ce traitement'));

	        } catch ( Exception $e ) {
	        	$r = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur BDD'));
	        }
	    } else
        	$r = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
    } else
        $r = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));


	echo json_encode($r);	

?>
