<?php 
if(isset($_POST['login']))
{
	$login = $_POST['login'];
	$pass = md5($_POST['pass']);
	$email = $_POST['email'];
	$name = $_POST['name'];
	$type = $_POST['type'];
	include("mysql_connect.php");
	$query="INSERT INTO `user` VALUES('$login','$pass','$email','$name','',$type)";
	if(mysqli_query($conn,$query))
	{
		header("Location:../admin.php");
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
	//header("Location:../index.php");
	echo "fuck";
	die();
}
?>