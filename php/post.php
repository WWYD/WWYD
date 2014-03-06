<?php 
	include("header.php");
	
	if(isset($_GET["topic_id"])){
		$st = $_GET["topic_id"];
		$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(
			                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
							  
				$topic_query = $bdd->prepare('SELECT * FROM topic WHERE id = '.$st);
				$topic_query->execute();

				$posts_query = $bdd->prepare('SELECT * FROM post WHERE topic_id = '.$st .' ORDER BY date ASC');
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
					
					<div class="content-elem" id="respond-zone">
						<div class="content-bordered respond-zone">
							<textarea id="reponse_textzone"></textarea>
							<p style="height: 20px; padding-right: 0px;"><button type="button" class="btn" id="comment_button" style="float: right">Répondre <span class="respond"></span></button></p>
						</div>
					</div>						
					
					<script type="text/javascript">
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
							    $("#respond-zone").slideToggle(200);
							  });
							});
					</script>
					<?php

					while($comment = $posts_query->fetch())
					{
						$comment_author_query = $bdd->prepare('SELECT login, premium FROM user WHERE id = '.$comment["user_id"]);
						$comment_author_query->execute();
						$comment_author = $comment_author_query->fetch(PDO::FETCH_ASSOC);
						

						if($comment_author["premium"] == 1)
							$premium = '<span class="badge" style="background-color: rgb(236, 151, 31)">Premium</span>';
						else
							$premium = '';

						echo '<div class="content-elem">';
							echo '<div class="content-bordered">';
								echo '<div class="content-bordered-title">';
									echo '<h4 class="panel-title">'.$comment_author["login"].' '.$premium.'<span style="float: right"><span class="badge" id="badgeInt"></span>&nbsp;&nbsp;<span class="plus"></span><span class="vote"> </span><span class="less"></span></span></h4>';
								echo '</div>';
								
								echo'<p style="font-size: 12pt">'.$comment["content"].'</p>';
							echo '</div>';
						echo '</div>';
					}
					?>
						
					</div>
				</div>
			</section>
			<section style="width: 30.3%; float: left;">
			<div class="categories">
				<h3>Catégories</h3>
				<table class="table table-striped table-hover">
					<tr><td>Général</td></tr>
					<tr><td>Humour</td></tr>
					<tr><td>Politique</td></tr>
					<tr><td>Cinéma</td></tr>
					<tr><td>Littérature</td></tr>
					<tr><td>Jeu vidéo</td></tr>
					<tr><td>Alimentaire</td></tr>
					<tr><td>Sport</td></tr>
					<tr><td>Sexe</td></tr>
					
				</table>
			</div>
		</section>

<?php
	include("footer.php");
?>