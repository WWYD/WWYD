		<?php
			header('Content-Type: text/html; charset=utf-8');
			$bdd = BBD_connect();		
		?>

		<!-- Phrase d'accroche du site -->
		<div id="indexTile">
			<section >
				<p><b><i>Vous avez un dilemme à gérer ?</i></b></p>
				<p>Un choix à faire et vous ne pouvez pas prendre de décision ?<br/>
				Laissez donc les internautes choisir pour vous !</p>
			</section>
		</div>
		
		<!-- Section du contenu -->
		<section>
			<!-- Section de gauche -->
			<section style="width: 66.6%; float : left;">
				<div class="content" >
		      	  <?php include('php/_daily.php'); ?>
				 	<?php if(is_co()) { ?>
						<div class="content-elem login">
		      		<?php include('php/_account_view.php'); ?>
						</div>
					<?php } ?>
				</div>
					
				<div class="content-elem fresh">
		      	  <?php include('php/_recent.php'); ?>
				</div>
			</section>
				
			<!-- Section de droite -->
			<section style="width: 30.3%; float: left;">
		        <?php include('php/_category.php'); ?>
			</section>
		</section>
		
<?php

?>