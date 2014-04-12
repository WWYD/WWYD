<?php

session_start();

if(isset($_POST['data'])) {
	$data = json_decode($_POST['data'])->data;

	if(isset($data->login) && isset($data->password)) {
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		   
			$query = $bdd->query('SELECT * FROM user WHERE login="'.mysql_real_escape_string($data->login).'"  AND password="'.mysql_real_escape_string($data->password).'"');

			if($data = $query->fetch()){
				if($data[0] >= 0) {
					$_SESSION['user'] = $data;
					$r = array('success' => array('title' => "Connexion", 'msg' => 'Vous êtes maintenant connecté'));
				} else {
					$r = array('error' => array('title' => "Connexion", 'msg' => 'Mot de passe et/ou login incorrect'));
				}
			} else
				$r = array('error' => array('title' => "Connexion", 'msg' => 'Mot de passe et/ou login incorrect'));

			$query->closeCursor();	
		} catch ( Exception $e ) {
			$r = array('error' => array('title' => "Erreur", 'msg' => 'Erreur base de données'));
		}
	} else {
		$r = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues icomplètes'));
	}

} else {
	$r = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}

echo json_encode($r);

?>