<?php

	header('Content-Type: text/html; charset=utf-8');

	session_start();
	include('../utils.php');

	if(isset($_SESSION['user']) && !$_SESSION['user']['banned']) {
		if($_SESSION['user']['premium'])
			$premium = '<span class="badge" style="background-color: rgb(236, 151, 31)">Premium</span>';
		else
			$premium = "";
		
		if(isset($_SESSION['user']) && isset($_POST['content']) && isset($_POST['topic_id'])){
			try {
				$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
				
				$query = $bdd->prepare("INSERT INTO post (content, date, last_edit, user_id, topic_id, is_answer) 
				                        VALUES ( ?, NOW(), NULL, ?, ?, 0)");
				$query->execute(array(htmlspecialchars($_POST['content'], ENT_QUOTES, "UTF-8"), $_SESSION['user']['id'], $_POST['topic_id']));

				?>

						<div class="content-elem ">
							<div class="content-bordered">
								<div class="content-bordered-title">
									<h4 class="panel-title">
										<a href="?/profil/<?php echo $_SESSION['user']['id']; ?>"><?php echo $_SESSION['user']['login']; ?></a>
									</h4>
								</div>
								<div class="p post-data" style="font-size: 12pt" rel="6"><?php echo BBCode(htmlspecialchars($_POST['content'], ENT_QUOTES, "UTF-8")); ?></div>
								<div class="content-bordered-sub">
									<span class="date">Ajouté à l'instant </span>
								</div>
							</div>
						</div>

				<?php

			} catch ( Exception $e ) {
				//echo 1;
			}
		}
	}
?>