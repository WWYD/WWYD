<?php

session_start();

if(isset($_SESSION['user']) && $_SESSION['user']['admin']) {

	if(isset($_POST['page']) && isset($_POST['page_size'])) {
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

		    $cat = "";
		    $query;

		    if(isset($_POST['data'])) {

			    if($_POST['data']['id_cat']+0 > 0)
		    		$cat = "AND category_id = ".$bdd->quote($_POST['data']['id_cat']);

			    $query = $bdd->prepare('SELECT topic.id, title, content, login, user.id as user_id, category.name, DATE_FORMAT(topic.date, "%d/%m/%y - %Hh%i") AS date
			    	                    FROM topic 
			    	                    RIGHT JOIN user ON user_id = user.id
			    	                    RIGHT JOIN category ON category_id = category.id
			    	                    WHERE login LIKE ? AND title LIKE ? '.$cat.'
			    	                    LIMIT ?, ?');

			    $query->bindValue(1, $_POST['data']['login']."%", PDO::PARAM_STR);
			    $query->bindValue(2, $_POST['data']['name']."%", PDO::PARAM_STR);
			    $query->bindValue(3, ($_POST['page']+0) * ($_POST['page_size']+0), PDO::PARAM_INT);
			    $query->bindValue(4, $_POST['page_size']+0, PDO::PARAM_INT);
			    $query->execute();
			} else {			    
				$query = $bdd->prepare('SELECT topic.id, title, content, login, user.id as user_id, DATE_FORMAT(topic.date, "%d/%m/%y - %Hh%i") AS date
			    	                    FROM topic 
			    	                    RIGHT JOIN user ON user_id = user.id
			    	                    LIMIT ?, ?');
			    $query->bindValue(1, ($_POST['page']+0) * ($_POST['page_size']+0), PDO::PARAM_INT);
			    $query->bindValue(2, $_POST['page_size']+0, PDO::PARAM_INT);
			    $query->execute();
			}

		    $result = array('success' => array());

		    while($data = $query->fetch()) {
		    	$result['success'][] = $data;
		    }

	 	} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	}
	// Le nombre de pages
	else {
		try {
		    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

		    $cat = "";
		    $query;

		    if(isset($_POST['data'])) {

			    if($_POST['data']['id_cat']+0 > 0)
		    		$cat = "AND category_id = ".$bdd->quote($_POST['data']['id_cat']);

			    $query = $bdd->prepare('SELECT count(topic.id) AS "size"
			    	                    FROM topic 
			    	                    RIGHT JOIN user ON user_id = user.id
			    	                    WHERE login LIKE ? AND title LIKE ? '.$cat);

			    $query->bindValue(1, $_POST['data']['login']."%", PDO::PARAM_STR);
			    $query->bindValue(2, $_POST['data']['name']."%", PDO::PARAM_STR);
			    $query->execute();
			} else {	
			    $query = $bdd->prepare('SELECT count(id) AS "size" FROM topic');
			    $query->execute();
			}
		    $result = array('success' => $query->fetch());
	 	} catch(Exception $e) {
			$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
		}
	}


	echo json_encode($result);	
}

?>