<?php

session_start();

if(isset($_POST['data'])) {
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
		$query = $bdd->query('SELECT * FROM user WHERE login="'.mysql_real_escape_string($_POST['data'][0]['value']).'"  AND password="'.mysql_real_escape_string($_POST['data'][1]['value']).'"');
		
		if($data = $query->fetch()){
			$_SESSION['user'] = $data;
			$_SESSION['notif'] = 1;
			$r = array('success' => array('title' => "Erreur", 'msg' => "Compte non reconnu"));
		} else
			$r = array('error' => array('title' => "Erreur", 'msg' => "Probl�me dans la base de donn�es"));

		$query->closeCursor();	
	} catch ( Exception $e ) {
		$r = array('error' => array('title' => "Erreur", 'msg' => "Erreur base de donn�es"));
	}

} else {
	$r = array('error' => array('title' => "Erreur", 'msg' => "Aucune donn�es re�ues !"));
}

echo json_encode($r);

?>