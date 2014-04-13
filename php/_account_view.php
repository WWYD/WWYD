<div class="content-bordered">
	<p>
		<img src="img/icon.png" alt="#" class="thumbnail"></img>
		<span class="span-user-name" >&nbsp;&nbsp;
			<a href="?/profil"><?php echo $_SESSION["user"][1]; ?></a>
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