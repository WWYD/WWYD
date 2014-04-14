<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

if(isset($_POST['data']) AND $_POST['data'] != "") {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $query = $bdd->prepare('SELECT id, login, mail, first_name, last_name, nb_point, admin, premium FROM user WHERE login = ?');
		$query->execute(array($_POST['data']));
		
		if($data = $query->fetch()) {
			$result = array('success' => $data);
			$result['success']['title'] = "Modération utilisateur '".$result['success']['login']."'";
		} else
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucun utilisateur correspondant au login \''.$_POST['data'].'\''));

	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
} else
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));

echo json_encode($result);	

?>