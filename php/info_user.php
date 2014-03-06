<?php

if(isset($_POST['id'])) {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $query = $bdd->prepare('SELECT * FROM user WHERE id = :nb');
	    $query->bindValue(':nb', $_POST['id'], PDO::PARAM_INT);
		$query->execute();
		
		$result = array();
		$i = 0;
		
		$result = $query->fetch();
		
		if (empty($result))
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucun user trouvé'));
		
	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
}else {
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}
	echo json_encode($result);	
	var_dump($result);

?>