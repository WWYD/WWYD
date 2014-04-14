<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {
	if(isset($_POST['data'])) {

		// Une page en particulier
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

		    $query = $bdd->prepare('SELECT id, name, description FROM category WHERE id = ?');
		    $query->bindValue(1, $_POST['data']+0, PDO::PARAM_INT);
		    $query->execute();

		    $result = array('success' => array());

		    if($data = $query->fetch()) {
		    	if($data['description'] == "")
		    		$data['description'] = "(Aucune description)";

		    	$data['title'] = "Modification catégorie '".$data['name']."'";

		    	$result['success'] = $data;
		    }

	 	} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	} else
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));

	echo json_encode($result);	
}

?>