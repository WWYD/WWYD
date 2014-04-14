<?php
	header('Content-Type: text/html; charset=utf-8');	
?>
<div class="content-bordered">
	<div class="content-bordered-title">
		<h4 class="panel-title">Situation récentes</h4>
	</div>

	<ul class="list-unstyled">
    	<?php
			$query = $bdd->prepare('SELECT title, id, DATE_FORMAT(date, "%d/%m/%y - %Hh%i") AS date FROM topic ORDER BY topic.date DESC LIMIT 0,5');
			$query -> execute();
			while($data = $query->fetch()){
				$query2 = $bdd->prepare('SELECT COUNT(*) FROM post WHERE topic_id ='.$data['id']);
				$query2 -> execute();
				$data2 = $query2 -> fetch();
				echo '<li><span class="date">['.$data['date'].']</span><a href="?/post/'.$data['id'].'"> '.$data["title"].' </a><span class="badge">'.$data2[0].' réponses</span></li>';
			}
		?>
	</ul>
</div>