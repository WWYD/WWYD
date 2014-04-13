
<div class="content-bordered">
	<div class="content-bordered-title">
		<h4 class="panel-title">Situation récentes</h4>
	</div>

	<ul class="list-unstyled">
    	<?php
			$query = $bdd->prepare('SELECT title,id FROM topic ORDER BY date DESC LIMIT 0,3');
			$query -> execute();
			while($data = $query->fetch()){
				$query2 = $bdd->prepare('SELECT COUNT(*) FROM post WHERE topic_id ='.$data['id']);
				$query2 -> execute();
				$data2 = $query2 -> fetch();
				echo '<li><a href="?/post/'.$data['id'].'">'.$data["title"].' </a><span class="badge">'.$data2[0].' réponses</span></li>';
			}
		?>
	</ul>
</div>