<?php
if(isset($_POST['subid']))
{
	$subid = $_POST['subid'];
	session_start();
	$uid = $_SESSION['uid'];
	include "mysql_connect.php";
	$query="INSERT INTO `student` VALUES('$subid','$uid',1)";
	if(mysqli_query($conn,$query))
	{
		header("Location:../student.php");
		die();
	}
	else
	{
		mysqli_error($conn);
		die();
	}
}
else
{
	header("Location:../index.php");
	echo "error";
	die();
}

?>