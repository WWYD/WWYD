<?php

if(isset($_SESSION['login'])) {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

		$str = "";
		$result = array();
					
		if(isset($_POST['mail'])){
			if($str != "")
				$str += ", ";
			$str = $str."mail = '".mysql_real_escape_string($_POST['mail']);
			array_push($result, array("mail" => mysql_real_escape_string($_POST['mail'])));
		}
		if(isset($_POST['password'])){
			if($str != "")
				$str = $str."', ";
			$str = $str."password = '".mysql_real_escape_string($_POST['password']);
			array_push($result, array("password" => mysql_real_escape_string($_POST['password'])));
		}
		if(isset($_POST['first_name'])){
			if($str != "")
				$str = $str."', ";
			$str = $str."first_name = '".mysql_real_escape_string($_POST['first_name']);
			array_push($result, array("first_name" => mysql_real_escape_string($_POST['first_name'])));
		}
		if(isset($_POST['last_name'])){
			if($str != "")
				$str = $str."', ";
			$str = $str."last_name = '".mysql_real_escape_string($_POST['last_name']);
			array_push($result, array("last_name" => mysql_real_escape_string($_POST['last_name'])));
		}
		if($str != "")
			$str = $str."'";
		
		if($str != ""){
			$query = $bdd->prepare('UPDATE user SET '.$str.' WHERE login = ?');
			$query->execute(array($_SESSION['login']));			
		}
		
	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
}else {
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}
	echo json_encode($result);

?>