<?php

if(isset($_POST['login'])) {
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
		$query = $bdd->query('SELECT * FROM user WHERE login="'.mysql_real_escape_string($_POST['login']).'"  AND password="'.mysql_real_escape_string($_POST['password']).'"');
		
		while($data = $query->fetch()){
			if(isset($data)){
				session_start();
				$_SESSION['user'] = $data;
				$_SESSION['notif'] = 1;
				header('location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			
			else if($data[0] == 0)
				$erreur = 'Compte non reconnu.';
			else
				$erreur = 'Problème dans la base de données.';
		}
		$query->closeCursor();	
	} catch ( Exception $e ) {
		echo 0;
	}

}

?>