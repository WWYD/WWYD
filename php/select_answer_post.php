<?php
	$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	$query = $bdd -> prepare('UPDATE post SET is_answer = TRUE WHERE id ='.$_POST['post_id']); 
	$query -> execute();
	$query2 = $bdd -> prepare('SELECT topic_id FROM post WHERE id ='.$_POST['post_id']);
	$query2 -> execute();
	$data = $query2->fetch();
	$query3 = $bdd -> prepare('UPDATE topic SET answered = TRUE WHERE id ='.$data[0]);
	$query3 -> execute();
	
?>