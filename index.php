<?php

	header( 'content-type: text/html; charset=utf-8' );
	session_start();

	include("php/utils.php");

	// Page d'index du site
	include("php/_header.php");
	include(get_page_to_load($_SERVER['QUERY_STRING']));
	include("php/_footer.php");

?>
