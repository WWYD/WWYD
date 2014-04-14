<?php

header('Content-Type: text/html; charset=utf-8');

session_start();
$cfg['PersistentConnections'] = TRUE;

// Test connexion
if(isset($_SESSION['user']) && !$_SESSION['user']["banned"]) {
	// Test données
	if(isset($_POST['data'])) {
		$data = json_decode($_POST['data'])->data;

		//var_dump($data);

		if(isset($data->title) && isset($data->pot_point) && isset($data->content) && isset($data->category_id)) {
			/* Test si vide */
			if($data->title != "" && $data->pot_point != "" && $data->content != "") {

				// Sécurisation
				$data->title = htmlspecialchars($data->title, ENT_QUOTES, "UTF-8");
				$data->pot_point = $data->pot_point+0;
				$data->content = htmlspecialchars($data->content, ENT_QUOTES, "UTF-8");

				if($data->pot_point < 0) {
					$result = array('error' => array('title' => 'Erreur', 'msg' => 'Cagnote impossible'));
					echo json_encode($result);
					exit();
				}

				try {
				    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
				                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
				   
				   	// Test title
				    $query = $bdd->prepare('SELECT count(*) FROM topic WHERE title = ?');
				    $query->execute(array($data->title));

				    if($qdata = $query->fetch()) {
				    	if($qdata[0] >= 1) {
							$result = array('error' => array('title' => 'Erreur', 'msg' => 'Titre déjà existant'));
							echo json_encode($result);
							exit();
				    	}
				    }

				   	// Test cagnote
				    $query = $bdd->prepare('SELECT nb_point FROM user WHERE id = ?');
				    $query->execute(array($_SESSION['user']['id']));

				    if($qdata = $query->fetch()) {
				    	if($qdata[0]+0 < $data->pot_point ) {
							$result = array('error' => array('title' => 'Erreur', 'msg' => 'Vous n\'avez pas assez de points pour en miser '.$data->pot_point));
							echo json_encode($result);
							exit();
				    	}
				    } else {
						$result = array('error' => array('title' => 'Erreur', 'msg' => 'Impossible de récuperer votre cagnote'));
						echo json_encode($result);
						exit();
				    }

				    // Ajout BDD
				    $query = $bdd->prepare('INSERT INTO topic (title, content, date, user_id, category_id, answered, pot_point) VALUES (?, ?, NOW(), ?, ?, 0, ?)');
				    $query->execute(array($data->title, $data->content, $_SESSION['user']['id'], $data->category_id, $data->pot_point));
				    
				    // Ne fonctionne pas (et devrait)
				    //$id = $bdd->lastInsertId();
				    $query = $bdd->prepare('SELECT id FROM topic ORDER BY id DESC LIMIT 0,1');
				    $query->execute();

				    $id = $query->fetch();
				    if($id)
				    	$id = $id[0];
				   	else
				   		$id = -1;

				    // On enlève les points à l'utilisateur
				    $query = $bdd->prepare('UPDATE user SET nb_point = (nb_point - ?) WHERE id = ?');
				    $query->execute(array($data->pot_point, $_SESSION['user']['id']));

					
					$result = array('success' => array('title' => 'Question posée !', 'msg' => "Vous allez être redirigé automatiquement sur votre nouvelle question", "id" => $id ));
				} catch ( Exception $e ) {
					 $result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
				}
			} else {
				$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
			}

		} else {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues incomplètes'));
		}
	} else {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));
	}

} else 
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Vous devez être connecté'));

echo json_encode($result);

?>