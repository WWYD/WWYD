<?php

header('Content-Type: text/html; charset=utf-8');

if(isset($_POST['login'])) {

	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
	                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $query = $bdd->prepare('SELECT count(*) FROM user WHERE login = ?');
	    $query->execute(array($_POST['login']));

	    if($data = $query->fetch()) {
	    	echo $data[0];
	    } else
	    	echo 0;

	} catch ( Exception $e ) {
		echo 0;
	}

}

?>