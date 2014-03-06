<?php
	session_start();
	if($_SESSION['user']['premium'])
		$premium = '<span class="badge" style="background-color: rgb(236, 151, 31)">Premium</span>';
	else
		$premium = "";

	if(isset($_SESSION['user']) && isset($_POST['content'])){
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=wwyd', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
			$query = $bdd->query('INSERT INTO post VALUES ("", "'.mysql_real_escape_string($_POST['content']).'", now(),"'.mysql_real_escape_string($_SESSION['user']['id']).'", "'.mysql_real_escape_string($_POST['topic_id']).'")');
			echo '<div class="content-elem">';
							echo '<div class="content-bordered" id="appears" style="display: none">'.
									 '<div class="content-bordered-title">'.
									 '<h4 class="panel-title">'.$_SESSION['user']['login'].' '.$premium.'<span style="float: right"><span class="badge" id="badgeInt"></span>&nbsp;&nbsp;<span class="plus"></span><span class="vote"> </span><span class="less"></span></span></h4>'.
								 '</div>'.
								
								'<p style="font-size: 12pt">'.$_POST["content"].'</p>'.
							 '</div>'.
						'</div>';
		} catch ( Exception $e ) {
			echo 1;
		}
	}
?>