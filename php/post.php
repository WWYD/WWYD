<?php 

	include("header.php");
	
	if(isset($_GET["topic_id"])){
		$st = $_GET["topic_id"];
		$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
							  
				$topic_query = $bdd->prepare('SELECT * FROM topic WHERE id = '.$st);
				$topic_query->execute();

				$posts_query = $bdd->prepare('SELECT post.id, content, date,post.user_id, topic_id, is_answer, SUM(value) as note
											  FROM post left join vote on (post_id = post.id)
											  WHERE topic_id = '.$st.'
											  GROUP BY post.id
											  ORDER BY date ASC');
				$posts_query->execute();

				$topic_data = $topic_query->fetch();
				if($topic_data["title"] == NULL)
				{
					header("Location: index.php");
				}
				$title = $topic_data["title"];
				$content = $topic_data["content"];
				$id_author = $topic_data["user_id"];
				
				$author_query = $bdd->prepare('SELECT * FROM user WHERE  id= '.$id_author);
				$author_query->execute();
				
				$author_data = $author_query->fetch();
				$author_name = $author_data["login"];
				$author_solde = $author_data["nb_point"];
				$author_grade = $author_data["rank_id"];
				$author_premium = $author_data["premium"];

	
		}
	else
		header("Location: index.php");
			
?>
		<div style="min-height: 250px; width: 100%;  background-color: #DEDEDE;">
			<div class="content" style="padding: 30px; margin-right: 390px;">
				<p style="font-size: 22pt; padding-left: 20px;"><i>"<?php echo $title; ?>"</i></p>
				<p><?php echo $content; ?></p>
			</div>
			
			<div class="content-elem login" style="width: 390px; position: absolute; top: 60px; right: 10px; z-index: 1;">
				<div class="content-bordered">
					<p>
						<img src="../img/apple-touch-icon-57x57-precomposed.png" alt="#" class="thumbnail"></img>
						<span class="span-user-name" >&nbsp;&nbsp;<a href="profil.php"><?php echo $author_name; ?></a></span>
						<hr/>
						<ul class="list-unstyled">
							<li><b>Solde :</b> <span class="badge"><?php echo $author_solde; ?> points </span></li>
							<li><b>Grade :</b> <?php echo $author_grade; ?></li>
							<li><b>Premium :</b><?php 	if($author_premium)
															echo ' Oui';
														else
															echo ' Non';
												?></li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		
		<section>
			<section style="width: 66.6%; float: left;">
				<div class="content">
					<div class="content-group" id="content-group">

					<?php 

					// Si user connecté, on fait apparaitre le bouton pour poster une réponse
					if (isset($_SESSION['user']))
					{
						echo '<div class="content-elem">';
							echo '<div class="content-bordered btn" id="respond_display_button_zone">';
								echo '<span style="margin-left: 45%" id="respond_display_button">Répondre</span>';
							echo '</div>';
						echo '</div>';
					}
					else
					{
						echo '<div class="content-elem">';
							echo '<div class="content-bordered btn" style="background-image: linear-gradient(rgb(240, 240, 240) 0px, rgb(220, 220, 220) 100%); border: solid 1px #777">';
								echo '<span class="connection" style="margin-left: 38%; color: black;">Connectez-vous pour répondre</span>';
							echo '</div>';
						echo '</div>';
					}
					?>

					<div class="content-elem" id="respond-zone" style="display: none">
						<div class="content-bordered respond-zone">
							<textarea id="reponse_textzone"></textarea>
							<p style="height: 20px; padding-right: 0px;">
								<button type="button" class="btn" id="comment_button" style="float: right">
									Répondre <span class="respond"></span>
								</button>
							</p>
						</div>
					</div>	


					<?php
					$empty = true;

					$r = "";
					$answer = "";

					while($comment = $posts_query->fetch())
					{
						$empty = false;
						$comment_author_query = $bdd->prepare('SELECT login, premium FROM user WHERE id = '.$comment["user_id"]);
						$comment_author_query->execute();
						$comment_author = $comment_author_query->fetch(PDO::FETCH_ASSOC);
						
						// TODO: Gérer ca au niveau SQL
						if ($comment["note"] == null)
							$comment["note"] = 0;

						if($comment_author["premium"] == 1)
							$premium = '<span class="badge" style="background-color: rgb(236, 151, 31)">Premium</span>';
						else
							$premium = '';

						if($comment['is_answer']) {
							$answer = '<div class="content-elem select-answer">'.
		                              '<div class="content-bordered">'.
									     '<div class="content-bordered-title">'.
										     '<h4 class="panel-title">'.$comment_author["login"].' '.
											     '<span class="badge" style="background-color: rgb(236, 151, 31)">Réponse séléctionnée</span>'.' '.$premium.
												     '<span style="float: right">'.
													     '<span class="badge" id="badgeInt">'.$comment["note"].'</span>&nbsp;&nbsp;'.
													     '<span class="like"><input type="hidden" value="'.$comment["id"].'"></span>'.
													     '<span class="dislike"><input type="hidden" value="'.$comment["id"].'">'.
												     '</span>'.
											     '</span>'.
										     '</h4>'.
									     '</div>'.
									     '<p style="font-size: 12pt">'.$comment["content"].'</p>'.
								     '</div>'.
							     '</div>'; 

						} else {
							$r  .= 	'<div class="content-elem">'.
	                                  	'<div class="content-bordered">'.
									     	'<div class="content-bordered-title">'.
										     	'<h4 class="panel-title">'.
											     	$comment_author["login"].' '.$premium.
											     	'<span style="float: right">'.
											     		'<span class="badge" id="badgeInt">'.$comment["note"].'</span>&nbsp;&nbsp;'.
											     		'<span class="like"><input type="hidden" value="'.$comment["id"].'"></span>'.
											     		'<span class="dislike"><input type="hidden" value="'.$comment["id"].'"></span>'.
											     	'</span>'.
										     	'</h4>'.
									     	'</div>'.
								     		'<p style="font-size: 12pt">'.$comment["content"].'</p>'.
							     		'</div>'.
						     		'</div>'; 
						 }
					}

					echo $answer;
					echo $r;

					if($empty == true)
					{
						echo '<div class="content-elem info" id="noans">';
							echo'<p style="font-size: 12pt"><h2>Résultat vide</h2>Il n\'y a pas encore de réponse pour ce topic</p>';
						echo '</div>';
					}
					?>
					<script type="text/javascript">

						// Si le premier bouton "Répondre" est cliqué, on fait apparaitre un champ de texte pour rédiger
						// et un deuxième bouton Répondre pour valider l'envoi.
						// Le premier bouton devient "Masquer" pour annuler la rédaction
						$("#respond_display_button_zone").click(function(){
							$("#respond-zone").slideToggle(200, function(){
							if($("#respond_display_button").text() == "Répondre")
								$("#respond_display_button").text("Masquer");
							else
								$("#respond_display_button").text("Répondre");
							});
						});


						// Deuxième bouton "Répondre" cliqué -> envoi du commentaire via ajax
						$("#comment_button").click(function (){
							$.ajax({
  								type: "POST",
								url: "replyPost.php",
								data: { content: $("#reponse_textzone").val(), topic_id: "<?php echo $_GET['topic_id']; ?>" }
							})
							.done(function( msg ) {
							    $("#content-group").append($(msg));
							    $("#reponse_textzone").val("");
							    $("#appears").fadeIn(200);	
							    $("#noans").slideToggle(200);
							    $("#respond_display_button").text("Répondre");
							    $("#respond-zone").slideToggle(200);
							  });
							});

						$(".dislike").click(function() 
						{
							console.log('dislike');
							var me = $(this);

							$.ajax({
								type: "POST",
								url: "vote.php",
								data: {
									post_id: $(this).find('input').val(),
									vote_type: "dislike"
								}
							})
							.done(function( msg ) 
							{
								console.log(msg);

								if (msg == "Vote bien pris en compte")
								{					
									var badge = me.prevAll('.badge').eq(0);
									badge.text((parseInt(badge.text())) - 1);
								}	
							});
						});

						$(".like").click(function() {

							console.log('like');
							var me = $(this);

							$.ajax({
								type: "POST",
								url: "vote.php",
								data: {
									post_id: $(this).find('input').val(),
									vote_type: "like"
								}
							})
							.done(function( msg ) 
							{
								console.log(msg);
								if (msg == "Vote bien pris en compte")
								{					
									var badge = me.prevAll('.badge').eq(0);
									badge.text((parseInt(badge.text())) + 1);
								}	
							});
						});

					</script>
					
						
					</div>
				</div>
			</section>
			<section style="width: 30.3%; float: left;">
		        <?php
					include('category.php');
				?>		
			</section>

<?php
	include("footer.php");
?>