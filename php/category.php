<?php
	$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	$query = $bdd->query('SELECT name, id FROM category');
	while($data = $query->fetch()){
		$query2 = $bdd->query('SELECT COUNT(*) FROM topic WHERE category_id = "'.$data['id'].'"');
		$data2 = $query2->fetch();
		echo '<tr><td>'.$data["name"].' <a class="badge" style="float: right">'.$data2[0].'</a></td></tr>';
	}
?>