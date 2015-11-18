<?php
if(!isset($_POST['quizid']))
{
	header("Location:index.php");
	die();
}
session_start();
$quizid=$_POST['quizid'];
$uid=$_SESSION['uid'];

include 'mysql_connect.php';

$query="SELECT * FROM quiz WHERE quizID='$quizid'";
if($result=mysqli_query($conn,$query))
{
	$row=$result->fetch_assoc();
	$_SESSION['quizid']=$quizid;
	$_SESSION['numques']=$row['numques'];
	echo "0";
}
else
	die(mysqli_error($conn));

?>