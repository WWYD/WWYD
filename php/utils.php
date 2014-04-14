<?php

	header('Content-Type: text/html; charset=utf-8');		

	// Connexion à la base de donnée
	function BBD_connect() {
		return new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}
	
	// Retourne le fichier de la page à charger, ou un lien vers la page d'erreur le cas échéant
	function get_page_to_load($URL) {

		$_GET['data'] = array();

		$URL = explode('/', $URL);
		if(count($URL) > 1) {

			for($i = 2; $i < count($URL); $i++) {
				$_GET['data'][$i-2] = $URL[$i];
			}

			switch ($URL[1]) {
				case 'index':
				case 'index.html':
					return "php/index.php";
				case 'post':
				case 'post.html':
					return "php/post.php";
				case 'admin':
				case 'admin.html':
					return "php/admin.php";
				case 'search':
				case 'search.html':
					return "php/search.php";
				case 'profil':
				case 'profil.html':
					return "php/profil.php";
				case 'category':
				case 'category.html':
					return "php/category.php";
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

	function BBCode($text) {

		$text = preg_replace('`\[b\](.+)\[/b\]`isU', '<b>$1</b>', $text); 
		$text = preg_replace('`\[i\](.+)\[/i\]`isU', '<i>$1</i>', $text);
		$text = preg_replace('`\[s\](.+)\[/s\]`isU', '<u>$1</u>', $text);
		$text = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $text);
		$text = preg_replace('`\[quote=(.+)\](.+)\[/quote\]`isU', '<div class="quote"><span class="quoted"><b>$1</b> à dit :</span>$2</div>', $text);
		$text = preg_replace('`\[quote\](.+)\[/quote\]`isU', '<div class="quote">$1</div>', $text);

		return $text;
	}

	function parse_date($date) {
		return $date;
		$date = explode(" ", $date);

		// Heure
		$time = explode(":", $date[1]);

		// Date
		$date = explode("-", $date[0]);

		return $date[2].'/'.$date[1].'/'.$date[0].' - '.$time[0].'h'.$time[1];
	}
?>