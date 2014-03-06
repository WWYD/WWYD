<?php

if(isset($_POST['login'])) {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $ch = mysql_real_escape_string($_POST['login']);
	    $query = $bdd->prepare('SELECT login, id FROM user WHERE id LIKE "%'.$ch.'%"');
	    $query->bindValue(':nb', $nb, PDO::PARAM_INT);
		$query->execute();
		
		$result = array();
		$i = 0;
		
		while($data = $query->fetch()){
			array_push($result, array($data['login'] =>	$data['id']));
		}	
		
	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
}else {
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}
	echo json_encode($result);	

?>