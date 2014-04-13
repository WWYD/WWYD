<?php 

	if(isset($_GET["data"][0])){

		$bdd = BBD_connect();

		// Info du post et du posteur
		$query = $bdd->prepare("SELECT topic.id as topic_id, topic.title as topic_title, topic.content as topic_content, topic.date as topic_date,
									   category.id as topic_cat_id, category.name as topic_cat, topic.answered as topic_answered,
							           user.id as user_id, user.login as user_login, user.nb_point as user_point, user.premium as user_premium, 
							           user.admin as user_admin, user.banned as user_banned, rank.name as  user_rank
							    FROM topic
							    LEFT JOIN user ON user.id = topic.user_id
							    LEFT JOIN rank ON user.rank_id = rank.id
							    LEFT JOIN category ON category.id = topic.category_id
							    WHERE topic.id = ?");
		$query->execute(array($_GET["data"][0]));


		if($data = $query->fetch()) {
			$topic = array();
			$topic['id'] = $data['topic_id'];
			$topic['title'] = $data['topic_title'];
			$topic['content'] = $data['topic_content'];
			$topic['date'] = $data['topic_date'];
			$topic['cat_id'] = $data['topic_cat_id'];
			$topic['topic_cat'] = $data['topic_cat'];
			$topic['answered'] = $data['topic_answered'];

			$user = array();
			$user['id'] = $data['user_id'];
			$user['login'] = $data['user_login'];
			$user['point'] = $data['user_point'];
			$user['premium'] = $data['user_premium'];
			$user['admin'] = $data['user_admin'];
			$user['banned'] = $data['user_banned'];
			$user['rank'] = $data['user_rank'];
		} else
			header("Location: ?/");

	} else
		header("Location: ?/");
?>

		<!-- Question -->
		<div style="min-height: 250px; width: 100%;  background-color: #DEDEDE;">

			<!-- Titre & question -->
			<div class="content" style="padding: 30px; margin-right: 390px;">
				<p style="font-size: 22pt; padding-left: 20px;"><i>"<?php echo $topic['title']; ?>"</i></p>
				<p><?php echo $topic['content']; ?></p>
			</div>
			
			<!-- Badge utilisateur -->
			<div class="content-elem login" style="width: 390px; position: absolute; top: 60px; right: 10px; z-index: 1;">
				<div class="content-bordered">
					<p>
						<img src="img/icon.png" alt="#" class="thumbnail"></img>
                    	<span class="span-user-name" >&nbsp;&nbsp;
                    		<a href="?/profil/<?php echo $user['id']; ?>" class="<?php if ($user['banned']) { echo "admin-ban"; } else if ($user['premium']) { echo "admin-login"; } ?>">
                    			<?php echo $user['login']; ?>
                    		</a>
                    	</span>
						<hr/>
						<ul class="list-unstyled">
							<li>
								<b>Solde :</b><span class="badge"><?php echo $user['point']; ?> points</span>
							</li>
							<li>
								<b>Grade :</b> <?php echo $user['rank']; ?>
							</li>
							<li>
							 	<b>Premium :</b>
								<?php if ($user['premium']) { ?> Oui <?php } else { ?> Non <?php } ?>
							</li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		
		<!-- Réponses -->
		<section>
			<section style="width: 66.6%; float: left;">
				<div class="content" id="content">

					<!-- Zone de réponses -->
					<?php if (is_co()) { 
							if($_SESSION['user']['banned']) { ?>
						<div class="content-elem">
							<div class="content-bordered btn btn-disabled center">Le utilisateurs bannis ne peuvent pas répondre</div>
						</div>
						<?php } else { ?>
						<div class="content-elem">
							<div class="content-bordered btn center" id="respond_display_button_zone">Répondre</div>
						</div>
					<?php }
						} else { ?>
						<div class="content-elem">
							<div class="content-bordered btn btn-disabled center">
								Connectez-vous pour répondre
							</div>
						</div>
					<?php } ?>

					<div class="content-elem" id="respond-zone" style="display: none">
						<div class="content-bordered respond-zone">
							<textarea id="reponse_textzone"></textarea>
							<p style="height: 20px; padding-right: 0px;">
								<button type="button" class="btn" id="comment_button" style="float: right">
									Répondre <span class="icon respond"></span>
								</button>
							</p>
						</div>
					</div>	

					<!-- Réponses -->
					<?php

					// Liste des messages
					$query = $bdd->prepare("SELECT post.id as id, post.content as content, post.date as date, post.is_answer as is_answer,
											       user.id as poster_id, user.login as login, user.premium as premium, user.admin as admin, user.banned as banned,
											       COALESCE(SUM(vote.value), 0) as value
											FROM post
											LEFT JOIN user ON user.id = post.user_id
											LEFT JOIN vote ON vote.post_id = post.id
											WHERE post.topic_id = ?
											GROUP BY post.id ");
					$query->execute(array($topic['id']));

					$empty = true;

					while($data = $query->fetch()) {
						$empty = false;

						?>
						<div class="content-elem <?php if($data["is_answer"]) { echo "select-answer"; } ?>" rel="<?php echo $data["id"]; ?>" >
							<div class="content-bordered">
								<div class="content-bordered-title">
									<h4 class="panel-title">
										<a href="?/profil/<?php echo $data["poster_id"]; ?>">
											<?php echo $data["login"]; ?>
										</a>
										<?php if($data['is_answer']) { ?> <span class="badge" style="background-color: rgb(236, 151, 31)">Réponse séléctionnée</span> <?php }
											  if($data['premium'])   { ?> <span class="badge-premium">Premium</span><?php } 
										?>
										<span style="float: right">
											<span class="badge badgeInt"><?php echo $data["value"]; ?></span>&nbsp;&nbsp;
											<span class="icon like"><input type="hidden" value="<?php echo $data["id"]; ?>"></span>
											<span class="icon dislike"><input type="hidden" value="<?php echo $data["id"]; ?>"></span>
										</span>
									</h4>
								</div>
								<p style="font-size: 12pt"><?php echo $data["content"]; ?></p>
								<?php
									if(is_co() AND !$topic['answered'] AND $user['id'] == $_SESSION['user']['id'] AND $data['poster_id'] != $user['id']) {
										?> <button class="answered_button btn btnsmall" rel="<?php echo $data["id"]; ?>" style="float: right; margin-top: -33px; margin-right: 5px;" >Sélectionner comme réponse</button> <?php
									}
								?>
							</div>
						</div>
					<?php } 

					if($empty) { ?>
						<div class="content-group" id="noans" style="display: block;">
							<span class="info" style="margin-top: 15px;">
								<h2>Aucune réponse</h2>
								Ce sujet n'a encore reçu aucune réponse. Soyez le premier !
							</span>
						</div>
					<?php } ?>

					<script type="text/javascript">
					$(document).ready(function () {
						var id;

						// Selection de la réponse
						$(".answered_button").click(function (e){
							id = $(e.target).attr("rel");
							$.ajax({
  								type: "POST",
								url: "php/script/post_select_answer.php",
								data: { post_id : id, topic_id : '<?php echo $_GET["data"][0]; ?>' }
							})
							.done(function( msg ) {
								$(".answered_button").fadeOut(200);
								console.log($("[rel="+id+"]"));
								$(".content-elem[rel="+id+"] .content-bordered-title").css("background-image", "linear-gradient(rgb(300, 233, 138) 0px, rgb(296, 211, 91) 100%)");
								$("[rel="+id+"]").children().css("box-shadow", "0px 0px 5px 0px #d58512");
							  });
						});
							
						// Réponse défillante
						$("#respond_display_button_zone").click(function(){
							$("#respond-zone").slideToggle(200, function(){
							if($("#respond_display_button_zone").text() == "Répondre")
								$("#respond_display_button_zone").text("Masquer");
							else
								$("#respond_display_button_zone").text("Répondre");
							});
						});

						// Deuxième bouton "Répondre"
						$("#comment_button").click(function (){
							$.ajax({
  								type: "POST",
								url: "php/script/post_reply.php",
								data: { content: $("#reponse_textzone").val(), topic_id: '<?php echo $_GET["data"][0]; ?>' }
							})
							.done(function( msg ) {
							    $("#content").append($(msg));
							    $("#noans").slideToggle(200);

							    $("#appears").fadeIn(200);	

							    $("#respond_display_button_zone").fadeOut(200);
							    $("#respond-zone").slideToggle(200);
							});
						});

						// Votes
						$(".dislike").click(function() {
							console.log('dislike');
							var me = $(this);

							$.ajax({
								type: "POST",
								url: "php/script/post_vote.php",
								data: {
									post_id: $(this).find('input').val(),
									vote_type: "dislike"
								}
							})
							.done(function( msg ) {
								console.log(msg);

								if(msg.indexOf("Succès") == 0) {					
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
								url: "php/script/post_vote.php",
								data: {
									post_id: $(this).find('input').val(),
									vote_type: "like"
								}
							})
							.done(function( msg ) {
								console.log(msg);

								if(msg.indexOf("Succès") == 0) {
									var badge = me.prevAll('.badge').eq(0);
									badge.text((parseInt(badge.text())) + 1);
								}
							});
						});
					});

					</script>
					
						
				</div>
			</section>
			<section style="width: 30.3%; float: left; margin-left: 15px;">
		        <?php
					include('php/_category.php');
				?>		
			</section>