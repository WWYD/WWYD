<?php

header('Content-Type: text/html; charset=utf-8');

/* Test existence */
if(isset($_POST['data'])) {
	$data = json_decode($_POST['data'])->data;

	if(isset($data->login) && isset($data->mail) &&isset($data->password)) {
		/* Test si vide */
		if($data->login != "" && $data->mail != "" && $data->password != "") {
			// Valeurs facultatives
			if(!isset($data->firstname))
				$data->firstname = "";

			if(!isset($data->lastname))
				$data->lastname = "";

			try {
			    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			   
			   	// Test pseudo
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE login = ?');
			    $query->execute(array($data->login));

			    if($qdata = $query->fetch()) {
			    	if($qdata[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Pseudo déjà existant'));
						echo json_encode($result);
						exit();
			    	}
			    }

			   	// Test mail
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE mail = ?');
			    $query->execute(array($data->mail));

			    if($qdata = $query->fetch()) {
			    	if($qdata[0] >= 1) {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Mail déjà existant'));
						echo json_encode($result);
						exit();
			    	}
			    }

			    // Ajout BDD
			    $query = $bdd->prepare('INSERT INTO user (login, mail, password, first_name, last_name, rank_id) VALUES (?, ?, ?, ?, ?, 1)');
			    $query->execute(array(htmlspecialchars($data->login, ENT_QUOTES, "UTF-8"), htmlspecialchars($data->mail, ENT_QUOTES, "UTF-8"), htmlspecialchars($data->password, ENT_QUOTES, "UTF-8"), htmlspecialchars($data->firstname, ENT_QUOTES, "UTF-8"), htmlspecialchars($data->lastname, ENT_QUOTES, "UTF-8")));
				
				$result = array('success' => array('title' => 'Compte créé !', 'msg' => "Vous pouvez maintenant vous connecter avec votre compte"));
			} catch ( Exception $e ) {
				 $result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
			}
		} else {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
		}

	} else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues incomplètes'));
	}
} else {
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}

echo json_encode($result);
?>