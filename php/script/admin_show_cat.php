<?php

session_start();

if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {

	if(isset($_POST['page']) && isset($_POST['page_size'])) {
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	
		    $query = $bdd->prepare('SELECT id, name, description FROM category LIMIT ?, ?');
		    $query->bindValue(1, ($_POST['page']+0) * ($_POST['page_size']+0), PDO::PARAM_INT);
		    $query->bindValue(2, $_POST['page_size']+0, PDO::PARAM_INT);
		    $query->execute();

		    $result = array('success' => array());

		    while($data = $query->fetch()) {
		    	if($data['description'] == "")
		    		$data['description'] = "(Aucune description)";

		    	$result['success'][] = $data;
		    }

	 	} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	}
	// Le nombre de pages
	else {
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		   
		    $query = $bdd->prepare('SELECT count(id) AS "size" FROM category');
		    $query->execute();

		    $result = array('success' => $query->fetch());
	 	} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	}


	echo json_encode($result);	
}

?>