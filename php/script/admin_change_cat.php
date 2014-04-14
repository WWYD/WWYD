<?php

header('Content-Type: text/html; charset=utf-8');

session_start();

if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {
	/* Test existence */
	if(isset($_POST['data'])) {
		$data = json_decode($_POST['data']);

		if(isset($data->data)) {
			$data = $data->data;

			if(isset($data->name) && isset($data->desc) && isset($data->id)) {
				try {

					$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
					$query = $bdd->prepare('UPDATE category SET name = ?, description = ? WHERE id = ?');
					$query->execute(array(htmlspecialchars($data->name, ENT_QUOTES, "UTF-8"), htmlspecialchars($data->desc, ENT_QUOTES, "UTF-8"), $data->id));
					$query->closeCursor();

					$result = array('success' => array('title' => 'Catégorie modifiée', 'msg' => "La catégorie '".$data->name."' a été modifée avec succès"));

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