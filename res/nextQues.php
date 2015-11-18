<?php
session_start();
if(!isset($_SESSION['quizid']))
{
	header("Location:../index.php");
	die();
}

if($_SESSION['numques']>$_SESSION['quesno'])
	$_SESSION['quesno']++;

header("Location:../quiz.php");
?>