<?php
session_start();
if(!isset($_SESSION['quizid']))
{
	header("Location:../index.php");
	die();
}
$uid=$_SESSION['uid'];
$quizid=$_SESSION['quizid'];
$quesno=$_SESSION['quesno'];

if(isset($_POST['op']))
{
	include 'mysql_connect.php';
	$op=$_POST['op'];
	$query="SELECT * FROM response WHERE loginID='$uid' AND quizID='$quizid' AND quesno='$quesno'";
	if($result=mysqli_query($conn,$query))
	{
		if($result->num_rows==0)
		{
			$query="INSERT INTO response VALUES('$uid','$quizid','$quesno',$op)";
			mysqli_query($conn,$query) or die(mysqli_error($conn));
		}
		else
		{
			$query="UPDATE response SET opno=$op WHERE loginId='$uid' AND quizID='$quizid' AND quesno='$quesno'";
			mysqli_query($conn,$query) or die(mysqli_error($conn));
		}
	}
	else
	{
		die(mysqli_error($conn));
	}
}
else
{
	include 'mysql_connect.php';
	$query="DELETE FROM response WHERE loginID='$uid' AND quizID='$quizid' AND quesno='$quesno'";
	mysqli_query($conn,$query) or die(mysqli_error($conn));
}

header("Location:../quiz.php");




?>