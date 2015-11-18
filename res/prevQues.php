<?php
session_start();
if(!isset($_SESSION['quizid']))
{
	header("Location:../index.php");
	die();
}

if($_SESSION['quesno']>1)
	$_SESSION['quesno']--;

header("Location:../quiz.php");
?>