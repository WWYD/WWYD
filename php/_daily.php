<?php
	header('Content-Type: text/html; charset=utf-8');		
?>


<div class="content-elem daily" style="<?php if(!is_co()) { ?> width: 97.9% <?php } ?>">
	<div class="content-bordered">
		<div class="content-bordered-title">
			<h4 class="panel-title">Situation du jour</h4>
		</div>
		 <?php
			$query = $bdd->query('SELECT topic.id, title, COUNT(t.id) AS reply FROM(SELECT id, topic_id FROM post WHERE date BETWEEN (NOW( ) - INTERVAL 1 DAY) AND NOW( )) t
								  LEFT JOIN topic ON t.topic_id = topic.id
								  GROUP BY t.topic_id
								  ORDER BY reply DESC
								  LIMIT 0,1');

			if($data = $query->fetch()){ ?>
				<p style="font-size: 22pt"><i>"<?php echo $data['title']; ?>"</i></p>
				<p style="height: 40px;"><a href="?/post/<?php echo $data['id']; ?>"><button type="button" class="btn" style="float: right">Répondre <span class="icon respond"></span></button></a></p>
			<?php
			} else { ?>
				<p style="font-size: 22pt"><i>Pas de situation aujourd'hui ! Pourquoi ne pas en proposer une ?</i></p>
			<?php
			}
		?>
		
	</div>
</div>