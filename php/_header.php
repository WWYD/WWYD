<?php
	header('Content-Type: text/html; charset=utf-8');		
?>

<html>
	<head>
        <meta charset="utf-8">
        <title>WWYD?<?php if(isset($title)) { echo " - ".$title; } ?></title>
		
        <link rel="stylesheet" href="css/style.css">

		<script src="js/jquery.min.js"></script>
		<script src="js/generator.js"></script>

		<!-- Pop-up messages d'alertes -->
		<script src="js/generator.message.js"></script>
		<link rel="stylesheet" href="css/generator.message.css">

		<!-- Fenêtres -->
		<script src="js/generator.ttbox.js"></script>
		<link rel="stylesheet" href="css/generator.ttbox.css">

		<!-- Formulaires -->
		<script src="js/generator.form.js"></script>
		<link rel="stylesheet" href="css/generator.form.css">

		<!-- Champs -->
		<script src="js/generator.textinput.js"></script>
		<link rel="stylesheet" href="css/generator.textinput.css">

		<!-- Bouttons -->
		<script src="js/generator.button.js"></script>
		<link rel="stylesheet" href="css/generator.button.css">

		<!-- Checkboxs -->
		<script src="js/generator.checkbox.js"></script>
		<link rel="stylesheet" href="css/generator.checkbox.css">

		<!-- Titres -->
		<script src="js/generator.title.js"></script>
		<link rel="stylesheet" href="css/generator.title.css">

		<!-- Paragraphes -->
		<script src="js/generator.paragraph.js"></script>
		<!-- <link rel="stylesheet" href="../css/generator.paragraph.css"> -->

		<!-- Div formatées -->
		<script src="js/generator.div.js"></script>
		<!-- <link rel="stylesheet" href="../css/generator.title.css"> -->

		<!-- Pagination onglets -->
		<script src="js/generator.tab.js"></script>
		<link rel="stylesheet" href="css/generator.tab.css"> 

		<!-- Sytème de panneaux -->
		<script src="js/generator.panel.js"></script>
		<!-- <link rel="stylesheet" href="../css/generator.panel.css"> -->

		<!-- Sytème de pagination -->
		<script src="js/generator.paginate.js"></script>
		<link rel="stylesheet" href="css/generator.paginate.css">

    </head>
	
	<body>

		<!-- Sécurité JavaScript -->
		<noscript>
			<div class="ttbox-global" style="display: block;">
				<div class="ttbox-frame" style="width: 500px; margin-left: -250px;">
					<h3 style="margin-top: 0px;">Javascript désactivé</h3>
					<p>Il semblerait que le <b>Javascript</b> soit désactivé sur votre navigateur.<br/><br/>
					   Pour vous proposer la meilleur expérience possible nous avons choisis d'user (et d'abuser) de
					   ce langage, c'est pourquoi notre site n'est pas fonctionnel sans.<br/>
					</p>
				</div>
			</div>
		</noscript>

		<!-- Header site -->
		<header>
			<nav id="fixedbar">
				<ul id="fixednav">
					<li>
						<a class="main-title" href="?/">
							<span>What</span><span>Would</span><span>You</span><span>Do</span><span>?</span>
						</a>
					</li>
					<li class="only-reponsive mn">
						<a href="index.php">Menu</a>
					</li>
					<li class="no-reponsive mn">
						<a href="?/" class="icon home"> Accueil</a>
					</li>
					<li class="no-reponsive mn">
						<a href="?/search/" class="icon search"> Recherche</a>
					</li>
					<?php if(is_co() AND $_SESSION['user']['admin']) { ?>
					<li class="no-reponsive mn">
						<a href="?/admin/" class="icon contact"> Admin</a>
					</li>
					<?php } else { ?>
					<li class="no-reponsive mn">
						<a href="?/contact/" class="icon contact"> Contact</a>
					</li>
					<?php } ?>
				</ul>
					
					<?php
						if(!is_co()) {
					?>
						<!-- Inscription / connexion -->
						<input type="button" value="Inscription" class="btn registration" />
						<input type="button" value="Connexion"   class="btn connection"   />
					<?php
						} else {
					?>
						<!-- Affichage info-compte / déconnexion -->
						<span style="float:right; margin-right: 30px">
							<span id="header-login">
								Connecté en tant que <b><?php echo $_SESSION["user"]["login"]; ?></b>&nbsp;&nbsp;
							</span>
							<input type="button" value="Déconnexion" class="btn btn-style2 deconnection"/>
						</span>
					<?php
						}
					?>
			</nav>
		</header>
		