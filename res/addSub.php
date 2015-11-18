<?php
if(isset($_POST['subid']))
{
	$subid = $_POST['subid'];
	$subname = $_POST['subname'];
	session_start();
	$uid = $_SESSION['uid'];
	include "mysql_connect.php";
	$query="INSERT INTO `subject` VALUES('$subid','$subname','$uid')";
	if(mysqli_query($conn,$query))
	{
		header("Location:../subcoord.php");
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