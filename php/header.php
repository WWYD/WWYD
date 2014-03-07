<?php
	$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	session_start();
/*
	function set_notif($msg, $type) {
		if(!isset($_SESSION['notif']))
			$_SESSION['notif'] = array();

		$_SESSION['notif'][] = array('msg' => $msg, 'type' => $type);
	}

	function get_notif() {
		if(isset($_SESSION['notif'])) {
			return array_pop($_SESSION['notif']);
		} else
			return NULL;
	}

	while($notif = get_notif()) {
			echo "$('.notification').html('<span><span class=\"ok-sign\"></span>'+".$notif['msg']."+'</span>'').fadeIn(300).delay(1500).fadeOut(300);";
	}*/
?>
<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>WWYD?<?php if(isset($title)) { echo " - ".$title; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script src="../js/generator.js"></script>
		
        <link rel="stylesheet" href="../css/style.css">
        <style>
            body {
				margin: 0;
                padding-top: 50px;
                padding-bottom: 20px;
            }

        </style>
    </head>
	
	<body>
		<header>
			<nav id="fixedbar">
					<ul id="fixednav">
						<li><a class="main-title" href="index.php"><b><span style="color: #e19118">What</span><span style="color: #EEEEEE">Would</span><span style="color: #e19118">You</span><span style="color: #EEEEEE">Do</span><span style="color: #e19118">?</span></b></a></li>
		
						<li class="mn"><a href="index.php"><span class="home"></span> Accueil</a></li>
						<li class="mn"><a href="#"><span class="contact"></span> Contact</a></li>
						
						<?php
							if(!isset($_SESSION["user"])) {
								echo '<div style="float: right;"><li class="co"><input id="connection" type="button" name="submit"value="Connexion" class="btn" style="margin-top: -7px; padding-left: 30px; padding-right: 30px; margin-left: -20px; margin-right: -20px"/></li>';
								echo '<li class="co"><a href="inscription.php"><input type="button" value="Inscription" class="btn" style="margin-top: -26px; padding-left: 30px; padding-right: 30px; margin-left: -20px; background-image: linear-gradient(rgb(50, 50, 50) 0px, rgb(25, 25, 25) 100%);"/></a></form></li></div>';
							}
							else 
								echo  '<span style="float:right; margin-right: 30px">Connecté en tant que <b>'.$_SESSION["user"]["login"].'</b>&nbsp;&nbsp;<a href="deconnexion.php"><input type="button" value="Déconnexion" class="btn" style=" margin-top: -26px; margin-left: 320px; padding-left: 30px; padding-right: 30px; background-image: linear-gradient(rgb(50, 50, 50) 0px, rgb(25, 25, 25) 100%);"/></a></span>';
						?>
					</ul>
			</nav>
		
		</header>
		