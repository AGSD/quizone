<?php 
if(!isset($_POST['quizid']))
{
	header("Location:../index.php");
}

$quizid = $_POST['quizid'];

include 'mysql_connect.php';

$query="SELECT * FROM `quiz` WHERE `quizID`='$quizid'";
if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
		echo "0";	//Can be used
	else
		echo "1";	//Can't be used
}
else
{
	echo "2"; //Error: Could not pass query!
}

?>