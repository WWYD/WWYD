<?php

if(isset($_POST['page']) && isset($_POST['page_size']) && isset($_POST['data'])) {
	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	    $query = $bdd->prepare('SELECT topic.id, title, topic.content, DATE_FORMAT(topic.date, "%e/%c/%m - %Hh%i") as date_, login, user.id as login_id, answered, pot_point, COUNT(post.id) as nb_post
								FROM topic
								RIGHT JOIN user ON user.id = topic.user_id
								LEFT JOIN post ON topic.id = post.topic_id
								WHERE category_id = ?
								GROUP BY topic.id
								LIMIT ?, ?');
	    $query->bindValue(1, $_POST['data']+0, PDO::PARAM_INT);
	    $query->bindValue(2, ($_POST['page']+0) * ($_POST['page_size']+0), PDO::PARAM_INT);
	    $query->bindValue(3, $_POST['page_size']+0, PDO::PARAM_INT);
	    $query->execute();

	    $result = array('success' => array());

	    while($data = $query->fetch()) {
	    	$result['success'][] = $data;
	    }

 	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
}
// Le nombre de pages
else if (isset($_POST['data'])) {
	try {
	    $bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	   
	    $query = $bdd->prepare('SELECT count(id) AS "size" FROM topic WHERE category_id = ?');
	    $query->execute(array($_POST['data']));

	    $result = array('success' => $query->fetch());
 	} catch(Exception $e) {
		$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur base de données'));
	}
} else
	$result = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur données'));


echo json_encode($result);	

?>