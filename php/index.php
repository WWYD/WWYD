<?php
		include("header.php");
		$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));		
?>
		<div style="width: 100%; height: 150px; background-color: #DEDEDE; margin-bottom: 30px;">
			<div style="margin: auto; width: 80%;">
				<p style="padding: 30px; font-size : 19pt;"><b><i>Vous avez un dilemme à gérer ?</i></b></p>
				<p style="margin-top: -70px; padding: 30px; font-size : 14pt;">Un choix à faire et vous ne pouvez pas prendre de décision ?<br/>
				Laissez donc les internautes choisir pour vous !</p>
			</div>
			<div class="notification">
				<span><span class="ok-sign"></span> Vous êtes connecté </span>
			</div>
		</div>
		
		<section >
		<section style="width: 66.6%; float : left;">
			<div class="content" >
				<div class="content-group">
					<div class="content-elem daily" style="<?php if(!isset($_SESSION["user"]))
									{ ?> width: 97.9% <?php } ?>">
						<div class="content-bordered">
							<div class="content-bordered-title">
								<h4 class="panel-title">Situation du jour</h4>
							</div>
							
							<p style="font-size: 22pt"><i>"Un bébé, un chat et une seule portion de nourriture. Que faire ?"</i></p>
							<p style="height: 40px;"><a href="post.php?topic_id=1"><button type="button" class="btn" style="float: right">Répondre <span class="respond"></span></button></a></p>
						</div>
					</div>
					<?php
					if(isset($_SESSION["user"]))
									{
										?>
					<div class="content-elem login">
						<div class="content-bordered">
							<p>
								<img src="../img/apple-touch-icon-57x57-precomposed.png" alt="#" class="thumbnail"></img>
								<?php
									if(isset($_SESSION["user"]))
									{
										echo '<span class="span-user-name" >&nbsp;&nbsp;<a href="profil.php">'.$_SESSION["user"][1].'</a></span>';
							
										echo '<hr/>';
										echo '<ul class="list-unstyled">';
										echo '<li><b>Solde :</b> <span class="badge"> '.$_SESSION["user"]["nb_point"].' points</span></li>';
										$query = $bdd->prepare('SELECT name FROM rank WHERE id = :nb');
										$query->bindValue(':nb', $_SESSION["user"]["rank_id"], PDO::PARAM_INT);
										$query->execute();
										$data = $query->fetch();
										echo '<li><b>Grade :</b> '.$data['name'].'</li>';
		
										if($_SESSION["user"]["premium"])
											echo '<li><b>Premium :</b> Oui</li>';
										else
											echo '<li><b>Premium :</b> Non</li>';
									}
								?>
								</ul>
							</p>
						</div>
					</div>
					<?php } ?>
				</div>
				
				<div class="content-elem fresh">
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
									echo '<li><a href="post.php?topic_id='.$data['id'].'">'.$data["title"].' </a><span class="badge">'.$data2[0].' réponses</span></li>';
								}
							?>
						</ul>
					</div>
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