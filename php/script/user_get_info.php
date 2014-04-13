<?php

session_start();

if(isset($_POST['data'])) {
	$data = json_decode($_POST['data']);

	if(isset($data->id)) {
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		   
			$query = $bdd->prepare('SELECT user.id AS id, user.login AS login, user.mail AS mail, user.first_name AS first_name, 
				                         user.last_name AS last_name, user.rank_id AS rank_id, rank.name AS rank, nb_point AS nb_point, 
				                         nb_euro AS nb_euro, admin AS admin, premium AS premium, banned AS banned,
				                         COUNT(post.id) AS nb_post
							        FROM  user
								    LEFT JOIN rank ON rank.id = user.rank_id
								    LEFT JOIN post ON post.user_id = user.id
								    WHERE user.id = ?
								    GROUP BY user.id');
			$query->execute(array($data->id));

			if($data = $query->fetch()){
				$r = array('success' => $data);
			} else
				$r = array('error' => array('title' => "Connexion", 'msg' => 'Compte inconnu'));

			$query->closeCursor();	
		} catch ( Exception $e ) {
			$r = array('error' => array('title' => "Erreur", 'msg' => 'Erreur base de données'));
		}
	} else {
		$r = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues icomplètes'));
	}

} else {
	$r = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
}

echo json_encode($r);

?>