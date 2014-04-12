<?php

	$per_page = 5;

	/* Test variables */
	if (isset($_POST["title"]) AND isset($_POST["resolved"]) AND isset($_POST["category"]) AND isset($_POST["ranking"]) AND isset($_POST["start_"])) {
		$str_query = "SELECT SQL_CALC_FOUND_ROWS topic.id as id, topic.title as title, user.login as login, 
		                     topic.user_id as user_id, topic.date as date, COUNT(post.id) as answers, category.id as category_id, category.name as category 
		              FROM (topic, user, category) LEFT OUTER JOIN post ON post.topic_id = topic.id
		              WHERE topic.user_id = user.id AND topic.category_id = category.id AND title LIKE ?";

		// Uniquement ceux sans réponses
		if($_POST["resolved"] == 0) {
			$str_query .= " AND answered = 0";
		}

		// Catégorie
		if($_POST["category"] != 0) {
			$str_query .= " AND category_id = ".($_POST["category"]+0);
		}

		$str_query .= " GROUP BY topic.id";

		// Ordre
		if($_POST["ranking"] == 1) { // date
			$str_query .= " ORDER BY topic.date ASC";
		} else if ($_POST["ranking"] == 2) { // Dernier post
			$str_query .= " ORDER BY ( SELECT topic.date
										FROM post
										WHERE topic_id = topic.id
										ORDER BY topic.date
										LIMIT 0 , 1
									 ) DESC";
		} else if ($_POST["ranking"] == 3) { // Cagnotte
			$str_query .= " ORDER BY topic.date ASC";
		} else if ($_POST["ranking"] == 4) { // Nombre de réponses
			$str_query .= " ORDER BY (SELECT COUNT(*) FROM post WHERE topic_id = topic.id) DESC";
		} else { // date
			$str_query .= " ORDER BY topic.date DESC";
		}

		$str_query .= " LIMIT ?, ".$per_page;

		try {
			// Requête principale
			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		    $query = $bdd->prepare($str_query);
			$query->bindValue(1, "%".$_POST["title"]."%", PDO::PARAM_STR);
			$query->bindValue(2, $_POST["start_"]*$per_page, PDO::PARAM_INT);
			$query->execute();

			// Nombre d'entrée de la dernière requête
			$query_paginate = $bdd->prepare("SELECT FOUND_ROWS()");
			$query_paginate->execute();

			$result = array();

			if($data = $query_paginate->fetch()) {
				$result['size'] = $data[0];
			} else {
				$result['size'] = 0;;
			}

			$result['start'] = $_POST["start_"]+0;
			$result['results'] = array();

			while($data = $query->fetch()) {
				$result['results'][] = $data;
			}
		} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	} else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
	}

	echo json_encode($result);

?>