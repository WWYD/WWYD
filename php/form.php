<?php
	$result = array();
	/* Test existence */
	if(isset($_POST['login']) && isset($_POST['mail']) &&isset($_POST['password'])) {
		/* Test si vide */
		if($_POST['login'] != "" && $_POST['mail'] != "" && $_POST['password'] != "") {
			// Valeurs facultatives
			if(!isset($_POST['first_name']))
				$_POST['first_name'] = "";

			if(!isset($_POST['last_name']))
				$_POST['last_name'] = "";

			try {
			    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			   
			   	// Test pseudo
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE login = ?');
			    $query->execute(array($_POST['login']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Pseudo déjà existant'));
			    	}
			    }

			   	// Test mail
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE mail = ?');
			    $query->execute(array($_POST['mail']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Mail déjà existant'));
			    	}
			    }

			    // Ajout BDD
			    $query = $bdd->prepare('INSERT INTO user (login, mail, password, first_name, last_name, rank_id) 
			    	                    VALUES (?, ?, ?, ?, ?, 1)');
			    $query->execute(array($_POST['login'], $_POST['mail'], $_POST['password'], $_POST['first_name'], $_POST['last_name']));
				
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