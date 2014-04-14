<div class="categories">
	<h3>Les 5 dernières réponses</h3>
	<table class="table table-striped table-hover">
		<?php
			$query = $bdd->prepare("SELECT id_ AS id, title_ AS title, date_ AS date, COUNT(date_) AS nb_post, points_ as points, answered_ AS answered
									FROM (SELECT topic.id AS id_, topic.title AS title_, DATE_FORMAT(topic.date, '%d/%m/%y - %Hh%i') AS date_, topic.pot_point as points_, topic.answered AS answered_
										  FROM post
										  RIGHT JOIN topic ON post.topic_id = topic.id
										  RIGHT JOIN category ON topic.category_id = category.id
									      WHERE category.id = ?
										  GROUP BY post.id
										  HAVING post.id != 0
									      ORDER BY post.date  DESC) t
									GROUP BY id_
									ORDER BY date_  DESC");

			$query->execute(array($id_cat));
																
			while($data = $query->fetch()){ ?>

			<tr>
				<td>
					<a style="width: 85%; float: left;" href="?/post/<?php echo $data['id']; ?>">
						 <?php echo $data['title']; ?> 
					</a>
					<span class="badge" style="float: right"><?php echo $data['nb_post']; ?></span>
					<span class="date" style="font-size: 70%; float: right;">[<?php echo $data['date']; ?>]</span>
				</td>
			</tr>

		<?php } ?>			
	</table>
</div>