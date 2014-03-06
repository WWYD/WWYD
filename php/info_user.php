<?php

if(isset($_POST['id'])) {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $query = $bdd->prepare('SELECT * FROM user WHERE id = :id');
	    $query->bindValue(':nb', $nb, PDO::PARAM_INT);
		$query->execute();
		
		$result = array();
		$i = 0;
		
		while($data = $query->fetch()){
			array_push($result, $data[$i]);
			$i++;
		}	
	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
}else {
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}
	echo json_encode($result);	

?>