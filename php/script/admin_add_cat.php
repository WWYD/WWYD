<?php

session_start();


if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {
	/* Test existence */
	if(isset($_POST['data'])) {
		$data = json_decode($_POST['data']);

		if(isset($data->data)) {
			$data = $data->data;

			if(isset($data->name) && isset($data->desc)) {
				try {

					$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

					$query = $bdd->prepare('INSERT INTO category (name, description) VALUES (?, ?)');
					$query->execute(array($data->name, $data->desc));
					$query->closeCursor();

					$result = array('success' => array('title' => 'Catégorie crée', 'msg' => "Nouvelle catégorie '".$data->name."' ajoutée"));

				} catch ( Exception $e ) {
					$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
				}

			} else {
				$result = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues incomplètes'));
			}
		} else {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues mal formées'));
		}
	} else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
	}

	echo json_encode($result);
}

?>