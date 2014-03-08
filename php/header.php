<?php
	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	session_start();
?>
<html>
	<head>
        <meta charset="utf-8">
        <title>WWYD?<?php if(isset($title)) { echo " - ".$title; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		
        <link rel="stylesheet" href="../css/style.css">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script src="../js/generator.js"></script>

		<!-- Pop-up messages d'alertes -->
		<script src="../js/generator.message.js"></script>
		<link rel="stylesheet" href="../css/generator.message.css">

		<!-- Fenêtres -->
		<script src="../js/generator.ttbox.js"></script>
		<link rel="stylesheet" href="../css/generator.ttbox.css">

		<!-- Formulaires -->
		<script src="../js/generator.form.js"></script>
		<link rel="stylesheet" href="../css/generator.form.css">

		<!-- Titres -->
		<script src="../js/generator.title.js"></script>
		<link rel="stylesheet" href="../css/generator.title.css">

    </head>
	
	<body>
		<header>
			<nav id="fixedbar">
					<ul id="fixednav">
						<li><a class="main-title" href="index.php"><b><span style="color: #e19118">What</span><span style="color: #EEEEEE">Would</span><span style="color: #e19118">You</span><span style="color: #EEEEEE">Do</span><span style="color: #e19118">?</span></b></a></li>
		
						<li class="mn"><a href="index.php"><span class="home"></span> Accueil</a></li>
						<li class="mn"><a href="search.php"><span class="search"></span> Recherche</a></li>
						<li class="mn"><a href="#"><span class="contact"></span> Contact</a></li>
						
						<?php
							if(!isset($_SESSION["user"])) {
								echo '<div style="float: right;"><li class="co"><input id="connection" type="button" name="submit"value="Connexion" class="btn connection" style="margin-top: -7px; padding-left: 30px; padding-right: 30px; margin-left: -20px; margin-right: -20px"/></li>';
								echo '<li class="co"><a href="#"><input type="button" value="Inscription" class="btn inscription" style="margin-top: -26px; padding-left: 30px; padding-right: 30px; margin-left: -20px; background-image: linear-gradient(rgb(50, 50, 50) 0px, rgb(25, 25, 25) 100%);"/></a></form></li></div>';
							}
							else 
								echo  '<span style="float:right; margin-right: 30px">Connecté en tant que <b>'.$_SESSION["user"]["login"].'</b>&nbsp;&nbsp;<a href="deconnexion.php" class="deconnection"><input type="button" value="Déconnexion" class="btn" style=" margin-top: -26px; margin-left: 320px; padding-left: 30px; padding-right: 30px; background-image: linear-gradient(rgb(50, 50, 50) 0px, rgb(25, 25, 25) 100%);"/></a></span>';
						?>
					</ul>
			</nav>
		
		</header>
		