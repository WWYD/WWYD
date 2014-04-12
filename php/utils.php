<?php

	// Connexion à la base de donnée
	function BBD_connect() {
		return new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}
	
	// Retourne le fichier de la page à charger, ou un lien vers la page d'erreur le cas échéant
	function get_page_to_load($URL) {

		$_GET['data'] = [];

		$URL = explode('/', $URL);
		if(count($URL) > 1) {

			for($i = 2; $i < count($URL); $i++) {
				$_GET['data'][$i-2] = $URL[$i];
			}

			switch ($URL[1]) {
				case 'index.html':
					return "php/index.php";
				case 'post.html':
					return "php/post.php";
				case 'admin.html':
					return "php/admin.php";
				case 'search.html':
					return "php/search.php";
				default:
					// Si erreur, page d'acceuil
					return "php/index.php";
			}

		} else 
			return "php/index.php";

	}

	// Retourne si un utilisateur est co ou non
	function is_co() {
		return isset($_SESSION["user"]);
	}

?>