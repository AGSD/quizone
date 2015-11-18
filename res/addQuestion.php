<?php
if(!isset($_POST['quesno']))
{
	header("Location:../index.php");
	die();
}
session_start();
$quizid=$_SESSION['quizid'];
$quesno=$_POST['quesno'];
$questext=$_POST['questext'];
$answer=$_POST['answer'];

$op1=$_POST['op1'];
$op2=$_POST['op2'];
$op3=$_POST['op3'];
$op4=$_POST['op4'];

$query="INSERT INTO `question` VALUES('$quizid','$quesno','$questext','$answer');
		INSERT INTO `option` VALUES('$quizid','$quesno','$op1','1');
		INSERT INTO `option` VALUES('$quizid','$quesno','$op2','2');
		INSERT INTO `option` VALUES('$quizid','$quesno','$op3','3');
		INSERT INTO `option` VALUES('$quizid','$quesno','$op4','4');
		UPDATE quiz SET numques=numques+1 WHERE quizID='$quizid';";
include 'mysql_connect.php';
if(mysqli_multi_query($conn,$query))
{
	$_SESSION['quesno']++;
	header("Location:../newQuiz.php");
	die();
}
else
{
	echo "Error";
	die();
}

?>