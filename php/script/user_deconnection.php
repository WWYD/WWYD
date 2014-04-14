<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
unset($_SESSION);
unset($_COOKIE);
session_destroy();
header ('Location: ../../?/'); 
?>