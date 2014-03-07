<?php
	$result = array();
	/*
		$_POST['data'][0] -> login
		$_POST['data'][1] -> mail
		$_POST['data'][2] -> password
		$_POST['data'][3] -> first_name
		$_POST['data'][4] -> last_name
	*/
	
	/* Test existence */
	if(isset($_POST['data']) && isset($_POST['data'][0]['value']) && isset($_POST['data'][1]['value']) &&isset($_POST['data'][2]['value'])) {
		/* Test si vide */
		if($_POST['data'][0]['value'] != "" && $_POST['data'][1]['value'] != "" && $_POST['data'][2]['value'] != "") {
			// Valeurs facultatives
			if(!isset($_POST['data'][3]['value']))
				$_POST['data'][3]['value'] = "";

			if(!isset($_POST['data'][4]['value']))
				$_POST['data'][4]['value'] = "";

			try {
			    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			   
			   	// Test pseudo
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE login = ?');
			    $query->execute(array($_POST['data'][0]['value']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Pseudo déjà existant'));
			    	}
			    }

			   	// Test mail
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE mail = ?');
			    $query->execute(array($_POST['data'][1]['value']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Mail déjà existant'));
			    	}
			    }

			    // Ajout BDD
			    $query = $bdd->prepare('INSERT INTO user (login, mail, password, first_name, last_name, rank_id) 
			    	                    VALUES (?, ?, ?, ?, ?, 1)');
			    $query->execute(array($_POST['data'][0]['value'], $_POST['data'][1]['value'], $_POST['data'][2]['value'], $_POST['data'][3]['value'], $_POST['data'][4]['value']));
				
				$result = array('success' => array('result' => "La BDD a bien été mise à jour."));
			} catch ( Exception $e ) {
				 $result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
			}
		} else {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
		}

	} else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
	}
	echo json_encode($result);
?>