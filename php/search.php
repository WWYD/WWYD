<?php 
	$title = "Recherche";
	include("header.php");
	$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	if(isset($_GET['id']))
		$id = $_GET['id'];
	else
		$id = 0;

?>
		<div style="width: 100%;  background-color: #DEDEDE;">
			<div class="content" style="padding: 30px; margin: auto;">
				<p style="font-size: 22pt; padding-left: 20px;">Recherche de question</p>
				<form class="content-bordered" style="padding: 27px;" id="search-form">
					<table>
						<tr>
							<td style="padding-top: 15px;">Titre</td>
							<td style="padding-top: 15px;"><input type="text" class="form-connection" id="title"></td>
						
							<td style="padding-top: 15px; padding-left: 15px;">Situations résolues</td>
							<td style="padding-top: 15px;"><input id="resolved" type="checkbox" class="form-connection"></td>
						</tr>
						<tr>
							<td style="padding-top: 15px;">Catégorie</td>
							<td style="padding-top: 15px;">
								<select class="form-connection" id="category">
						            <option value="0">Toutes</option>
                                    <?php
										$query = $bdd->query('SELECT name, id FROM category');
										while($data = $query->fetch()){
											if($id == $data["id"])
												echo '<option selected="selected" value="'.$data["id"].'">'.$data["name"].'</option>';
											else
												echo '<option value="'.$data["id"].'">'.$data["name"].'</option>';
										}
									?>
					            </select>
					        </td>
					        <td style="padding-top: 15px; padding-left: 15px;">Classer par</td>
							<td style="padding-top: 15px;">
								<select class="form-connection" id="ranking">
						            <option value="0">Date (+ au - récent)</option>
						            <option value="1">Date (- au + récent)</option>
						            <option value="2">Par activité</option>
						            <option value="3">Par cagnotte</option>
						            <option value="4">Par réponses</option>
					            </select>
					        </td>
					    </tr>
				    </table>
				</form>
				<button type="button" id="start-search" class="btn" style=" margin: auto; margin-top: 10px; margin-bottom: -19px;">Lancer la recherche</button>
			</div>
		</div>
		
		<section>
			<section style="width: 100%; float: left;">
				<div class="content">
					<div class="content-group" id="finds">				

					</div>
				</div>
			</section>

			<script type="text/javascript"> <!--

				function message(title, category, category_id, login, login_id, date, answers, id) {
					var day = date.split(" ");
					day = day[0].split("-");
					return '<div class="content-elem">'+
					        '<div class="content-bordered">'+
								'<div class="content-bordered-title">'+
									'<h4 class="panel-title">'+title+'</h4>'+
								'</div>'+
								'<p style="font-size: 12pt">'+
									'Dans <a href="#?id='+category_id+'"">'+category+'</a> par <a href="#?id='+login_id+'">'+login+'</a> le '+day[2]+'/'+day[1]+'/'+day[0]+' <span class="badge">'+answers+' réponses</span>'+
									'<a href="post.php?topic_id='+id+'"><button type="button" class="btn btnsmall" style="float: right; margin-top: -2px;">'+
									'Voir <span class="respond"></span></button></a></p>'+
							'</div>'+
						   '</div>';
				}

				function error(div, title, msg) {
					div.html('<span class="error" style="display: none;"><h2>'+title+'</h2>'+msg+'</span>');
					div.children().fadeIn(300);
				}

				function info(div, title, msg) {
					div.html('<span class="info" style="display: none;"><h2>'+title+'</h2>'+msg+'</span>');
					div.children().fadeIn(300);
				}

				$(document).ready(function() {

					// Sauvegarde des éléments
					var title = $("#title").val();
					var resolved = ( $('#resolved').is(':checked') ? 1 : 0);
					var category = $("#category").val();
					var ranking = $("#ranking").val();
					var start = 0;

					function make_search(update) {

						if(update) {
							title = $("#title").val();
							resolved = ( $('#resolved').is(':checked') ? 1 : 0);
							category = $("#category").val();
							ranking = $("#ranking").val();
							start = 0;
						}

						$('html,body').animate({scrollTop: 0}, function() {
							$.ajax({ type: "POST",
								  	 url: "search_script.php",
	               					 dataType: "json",
								     data: { title: title,
								             resolved: resolved,
								             category: category,
								             ranking: ranking,
								             start_: start }
								         })
									  .done(function(data) {
									  	$(window).scrollTop();
									    if(data.error) {
									    	error($("#finds"), data.error.title, data.error.msg);
									    } else {
									    	var result = "";

									    	if(data.results && data.results.length > 0) {
									    		// Résultats
										    	for (var i = 0; i < data.results.length; i++) {;
										    		result += message(data.results[i].title, data.results[i].category,
										    						  data.results[i].category_id, data.results[i].login,
										    			              data.results[i].login_id, data.results[i].date, 
										    			              data.results[i].answers, data.results[i].id);
										    	};
										    	// Pagination
										    	result += '<div class="content-elem paginate">';
										    	for (var i = 0; i*10 < data.size; i++) {
										    		if(i == data.start)
										    			result += '<button type="button" class="selected">'+(i+1)+'</button>';
										    		else
										    			result += '<button type="button">'+(i+1)+'</button>';
										    	};
										    	result += '</div>';
										    	$("#finds").fadeOut(200, function() {
										    		$(this).html(result).fadeIn(300);
										    	});
										    } else {
										    	info($("#finds"), "Résultat vide", "La recherche n'a retournée aucun résultat")
										    }
									    }
									  })
									  .fail(function() {
									  	console.log('erreur');
									  	error($("#finds"), "Erreur de connexion", "Impossible de charger le script");
									  });
						});
					}

					$("#search-form").keypress(function(event) {
					    if (event.which == 13) {
					        event.preventDefault();
					        $("#start").val(0);
					        make_search(true);
					    }
					});

					$(".content-group").on("click", ".paginate button" ,function() {
						var p = $(this).html() - 1;

						if(p != start) {
							start = p;
					        make_search(false);
						}
					});

					$("#start-search").click(function() {
						make_search(true);
					});

					make_search(false);

				});

			-->
			</script>
			
<?php
	include("footer.php");
?>