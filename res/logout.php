<?php
session_start();
if(!isset($_SESSION['uid']))
{
	header("Location:../index.php");
	die();
}
unset($_SESSION['uid']);
unset($_SESSION['type']);
unset($_SESSION['name']);
session_destroy();
header("Location:../index.php");

?>
