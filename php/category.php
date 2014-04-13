		<?php

		if(isset($_GET["data"][0])){
			
			$id_cat = $_GET["data"][0];

			$bdd = BBD_connect();

			$query = $bdd->prepare("SELECT category.id as _id, category.name as name, category.description as description, COUNT(topic.id) as nb_topic, 
										(SELECT COUNT(post.id) FROM category   
										 LEFT JOIN topic ON topic.category_id = category.id
										 LEFT JOIN post ON post.topic_id = topic.id
										 WHERE category.id = _id) as nb_post 
									FROM category 
									LEFT JOIN topic ON topic.category_id = category.id
									WHERE category.id = ?
									GROUP BY category.id");

			$query->execute(array($_GET["data"][0]));

			if($data = $query->fetch()) {
				if($data['description'] == "")
					$data['description'] = "(Aucune description)";
				$cat = $data;
			} else
				header("Location: ?/");

		} else
			header("Location: ?/");
		?>

		<!-- Nom, descript & header  -->
		<div id="indexTile" <?php if(file_exists('img/cat-'.$cat['_id'].'.jpg')) { echo 'style="background: url(\'img/cat-'.$cat['_id'].'.jpg\') no-repeat center; background-size: 100%;"'; } ?> >
			<section >
				<p><b><i><?php echo $cat['name']; ?></i></b></p>
				<p><?php echo $cat['description']; ?></p>
			</section>
		</div>
		
		<!-- Section du contenu -->
		<section>
			<!-- Section de gauche -->
			<section style="width: 66.6%; float : left;">

	      	    <div class="content-elem fresh">
	      	    	<?php if(is_co()) { ?>
		      	    	<?php if($_SESSION['user']['banned']) { ?>
		      	    	<div class="btn btn-disabled" style="margin: 5px;"><span class="icon warning-sign" ></span>Les utilisateurs bannis ne peuvent pas poster de nouvelles réponses</div>
		      	    	<?php } else { ?>
			      	    <div class="btn new-cat" style="margin: 5px;"><span class="icon plus" ></span>Poser une nouvelle question</div>
			      	    <?php } ?>
		      	    <?php } else { ?>
		      	    <div class="connection-show btn btn-disabled" style="margin: 5px;"><span class="icon warning-sign" ></span>Connectez vous pour pouvoir poser une question</div>
		      	    <?php } ?>
		      	    <div style="margin: 5px; margin-top: 12px; box-sizing: border-box;">
		      	    	<div class="btn show-cat" style="width: 49%; float: left; box-sizing: border-box"><span class="icon eye" ></span>Voir toutes les questions</div>
		      	    	<a href="?/search/<?php echo $id_cat; ?>"><div class="btn" style="width: 49%; float: right; box-sizing: border-box"><span class="icon search" ></span>Chercher dans cette catégorie</div></a>
		      	    </div>
	      	    </div>

	      	    <div id="cat-stat" style="width:100%; ">
		      	    <div class="content-elem fresh">
						<div class="content-bordered">
							<div class="content-bordered-title">
								<h4 class="panel-title">Statistiques</h4>
							</div>
							
							<p>
								<b class="content-bordered-item">Nombre de sujets : </b><?php echo $cat['nb_topic']; ?>
								<b class="content-bordered-item">Nombre de messages : </b><?php echo $cat['nb_post']; ?>
							</p>
						</div>
					</div>
						
					<div class="content-elem fresh">
						<div class="content-bordered">
							<div class="content-bordered-title">
								<h4 class="panel-title">Les plus répondus</h4>
							</div>
							<ul class="list-unstyled">
							<?php
								$query = $bdd->prepare("SELECT topic.id AS id, topic.title AS title, DATE_FORMAT(topic.date, '%d/%m/%y - %Hh%i') AS date_, topic.pot_point as points, COUNT(post.id) AS nb_post, topic.answered AS answered
														FROM category
														RIGHT JOIN topic ON topic.category_id = category.id
														LEFT JOIN post ON post.topic_id = topic.id
													    WHERE category.id = ?
														GROUP BY topic.id
														ORDER BY nb_post DESC
														LIMIT 0,5");

								$query->execute(array($id_cat));
																					
								while($data = $query->fetch()){ ?>

								<li>
										<span class="date">[<?php echo $data['date_']; ?>]</span>
										<a href="?/post/<?php echo $data['id']; ?>">
											<?php echo $data['title']; ?>
											<span class="badge" style="float: right; margin-right: 10px;"><?php echo $data['nb_post']; ?> rep.</span>
											<?php if($data['points'] > 0 AND !$data['answered']) { ?>
											<span class="badge" style="float: right; margin-right: 10px;"><?php echo $data['points']; ?> points</span>
											<?php } else if ($data['answered']) {  ?>
											<span class="badge-premium" style="float: right; margin-right: 10px;">Répondu</span>
											<?php } ?>
										</a>
								</li>
				
							<?php } ?>	
							</ul>
						</div>
					</div>

					<div class="content-elem fresh">
						<div class="content-bordered">
							<div class="content-bordered-title">
								<h4 class="panel-title">Les derniers créés</h4>
							</div>

							<ul class="list-unstyled">
							<?php
								$query = $bdd->prepare("SELECT topic.id AS id, topic.title AS title, DATE_FORMAT(topic.date, '%d/%m/%y - %Hh%i') AS date_, topic.pot_point as points, COUNT(post.id) AS nb_post, topic.answered AS answered
														FROM category
														RIGHT JOIN topic ON topic.category_id = category.id
														LEFT JOIN post ON post.topic_id = topic.id
													    WHERE category.id = ?
														GROUP BY topic.id
														ORDER BY topic.date DESC
														LIMIT 0,5");

								$query->execute(array($id_cat));
																					
								while($data = $query->fetch()){ ?>

								<li>
										<span class="date">[<?php echo $data['date_']; ?>]</span>
										<a href="?/post/<?php echo $data['id']; ?>">
											<?php echo $data['title']; ?>
											<span class="badge" style="float: right; margin-right: 10px;"><?php echo $data['nb_post']; ?> rep.</span>
											<?php if($data['points'] > 0 AND !$data['answered']) { ?>
											<span class="badge" style="float: right; margin-right: 10px;"><?php echo $data['points']; ?> points</span>
											<?php } else if ($data['answered']) {  ?>
											<span class="badge-premium" style="float: right; margin-right: 10px;">Répondu</span>
											<?php } ?>
										</a>
								</li>
				
							<?php } ?>	
							</ul>
						</div>
					</div>
				</div>

	      	    <div id="cat-show" style="display: none; width:100%; ">
	      	    </div>
			</section>
				
			<!-- Section de droite -->
			<section style="width: 30.3%; float: left;">
				<div class="categories">
					<h3>Les 15 dernières réponses</h3>
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
			</section>
		</section>
		
		<script type="text/javascript">
		<!--
				$('body').on('click', '.show-cat', function(e) {
					$('.show-cat').removeClass('show-cat').addClass('hide-cat').html('<span class="icon eye" ></span>Voir les stats');
					$('#cat-show').slideToggle();
					$('#cat-stat').slideToggle();
				});

				$('body').on('click', '.hide-cat', function(e) {
					$('.hide-cat').removeClass('hide-cat').addClass('show-cat').html('<span class="icon eye"></span>Voir toutes les questions');
					$('#cat-show').slideToggle();
					$('#cat-stat').slideToggle();
				});

				var page_func = function(data) {

					var an = '';
					var p = '';

					if(data.answered == "1") {
						var an = '<span class="badge-premium">Répondu</span>';
					} else if(parseInt(data.points) > 0) {
						var p = '<span class="badge" style="float: right;">'+data.points+' points</span>';
					}

					console.log(data.points);

					if(data.content.length > 100) {
						text = data.content.slice(0,100)+"...";
					} else {
						text = data.content;
					}

					return '<div class="content-elem fresh">'+
						'<div class="content-bordered">'+
							'<div class="content-bordered-title">'+
								'<h4 class="panel-title"><a href="?/post/'+data.id+'"><i>'+data.title+'</i></a> par <a href="?/profil/'+data.login_id+'">'+data.login+'</a> <span class="date">['+data.date_+']</span> '+an+' <span class="badge" style="float: right;">'+data.nb_post+' réponses</span>'+p+'</h4>'+
							'</div>'+
							'<p>'+
								text+
							'</p>'+
							'<a href="?/post/'+data.id+'"><button type="button" class="btn btnsmall" style="float: right; margin-top: -35px; margin-right: 8px;">Voir <span class="icon respond"></span></button></a>'+
						'</div>'+
					'</div>';
				};

				// Pagination
				var page = new generator.Paginate( {
									    				source    : "php/script/topic_show.php",
									    				page_size : 5,
									    				model     : page_func,
									    				data      : <?php echo $id_cat; ?>
									    			});
				page.setRenderTo($('#cat-show'));
				page.init();

				// Ajout de nouveau message
					var points_clbk = function(e, element) {
													  return !isNaN(parseInt(element.val())) && parseInt(element.val()) >= 0;
												  };

					var login = new generator.TextInput({ placeholder : "Question", min_size : 3, check_onkey : true, show_validation : true });
					var cagnote = new generator.TextInput({ placeholder : "Cagnote", 
					                                              check_onkey : true, 
					                                              show_validation : true,
					                                              check_clbk : points_clbk,
					                                              value : 0 });

					var content = new generator.TextArea({ placeholder : 'contenu', css : {width : "100%", height : "300px"}});
					var cat_id = new generator.Hidden({ default : <?php echo $id_cat; ?> });


					box = new generator.TTBox( { width: 560, elements : 
						new generator.Form( { elements :
							[[{ item  : new generator.Title({ text: "Nouvelle question dans <?php echo $cat['name']; ?>" }), width : 4 }],
							 [{ label : 'Titre', item : login, name : 'title' }, { label : 'Cagnote', item : cagnote, name : 'pot_point' }],
							 [{ item  : new generator.Title({ text: "Contenu question" }), width : 4 }],
							 [{ item : content, name : 'content', width : 5}],
							 [{ item : cat_id, name : 'category_id', width : 5}],
							], 
							design : "table", 
							submit_value : "Poster votre question !",
							target : "php/script/topic_new.php", 
							success_clbk : function(data) {
									var error = new generator.Message({ type : 'success', title : data.success.title, 
				          				                                message : data.success.msg, 
				          				                                modal : true, dismissible : false, 
				          				                                disable : box.window ,
					      				                            	creation_clbk : function() {
					      				                            		window.setTimeout( function() { 
					      				                            			window.location.href = '?/post/'+data.success.id; 
					      				                            		}, 1000 );
					      				                            	}});
									box.hide();
									error.init();
							 } 
						   } 
						)
					});

					box.init();

				// Pop-up inscription
				$(".new-cat").on("click", function(e) {
					box.show();
				});
		-->
		</script>

<?php

?>