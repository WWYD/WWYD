<?php
	/* Test existance */
	if(isset($_POST['login']) && isset($_POST['mail']) &&isset($_POST['pass'])) {
		/* Test si vide */
		if($_POST['login'] != "" && $_POST['mail'] != "" && $_POST['pass'] != "") {

			// Valeurs facultatives
			if(!isset($_POST['firstname']))
				$_POST['firstname'] = "";

			if(!isset($_POST['lastname']))
				$_POST['lastname'] = "";

			try {
			    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			   
			   	// Test pseudo
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE login = ?');
			    $query->execute(array($_POST['login']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						include 'error.php?e=3';
						exit();
			    	}
			    }

			   	// Test mail
			    $query = $bdd->prepare('SELECT count(*) FROM user WHERE mail = ?');
			    $query->execute(array($_POST['mail']));

			    if($data = $query->fetch()) {
			    	if($data[0] >= 1) {
						include 'error.php?e=4';
						exit();
			    	}
			    }

			    // Ajout BDD
			    $query = $bdd->prepare('INSERT INTO user (login, mail, password, firstname, lastname) 
			    	                    VALUES (?, ?, ?, ?, ?)');
			    $query->execute(array($_POST['login'], $_POST['mail'], $_POST['pass'], $_POST['firstname'], $_POST['lastname']));

				include 'success.php';

			} catch ( Exception $e ) {
				include 'error.php?e=5';
			}
		} else {
			include 'error.php?e=2';
			exit();
		}

	} else {
		include 'error.php?e=1';
		exit();
	}
?>