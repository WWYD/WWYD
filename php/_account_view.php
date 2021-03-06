<div class="content-bordered">
	<p style="height: 70px; width: 100%;">
		<img src="img/icon.png" alt="#" class="thumbnail"></img>
		<span class="span-user-name" >
			<a href="?/profil/<?php echo $_SESSION["user"]['id']; ?>" class="<?php if ($_SESSION["user"]['banned']) { echo "admin-ban"; } else if ($_SESSION["user"]['admin']) { echo "admin-login"; } ?>">
	           <?php echo $_SESSION["user"]['login']; ?>
	        </a>
		</span>

		<hr/>
		<ul class="list-unstyled">
			<li>
				<b>Solde :</b> <span class="badge"><?php echo $_SESSION["user"]["nb_point"]; ?> points</span>
			</li>

			<?php
				$query = $bdd->prepare('SELECT name FROM rank WHERE id = :nb');
				$query->bindValue(':nb', $_SESSION["user"]["rank_id"], PDO::PARAM_INT);
				$query->execute();
				$data = $query->fetch();
			?>
		
			<li>
				<b>Grade :</b><?php echo $data['name']; ?>
			</li>

		
			<?php if($_SESSION["user"]["premium"]) { ?>
			<li><b>Premium :</b> Oui</li>
			<?php } else { ?>
			<li><b>Premium :</b> Non</li>
			<?php } ?>
		</ul>
	</p>
</div>