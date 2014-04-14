<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {

	if(isset($_POST['data'])) {
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		   
		    $query = $bdd->prepare('SELECT login, id FROM user WHERE login LIKE ? LIMIT 6');
			$query->execute(array($_POST['data']."%"));
			
			$result = array('success' => array());
			
			while ($data = $query->fetch()) {
				$result['success'][] = $data['login'];
			}
			
		} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	}else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
	}
	
	echo json_encode($result);	
}

?>