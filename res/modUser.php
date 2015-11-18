<?php 
session_start();
if(isset($_POST['pass']))
{
	$pass = md5($_POST['pass']);
	$email = $_POST['email'];
	$name = $_POST['name'];
	$type = $_POST['type'];
	$uid = $_SESSION['uid'];
	include("mysql_connect.php");
	
	if($pass!='')
	{
		$query="UPDATE `user` SET `password`='$pass' WHERE `loginID`='$uid'";
		mysqli_query($conn,$query);
	}
	if($email!='')
	{
		$query="UPDATE `user` SET `email`='$email' WHERE `loginID`='$uid'";
		mysqli_query($conn,$query);
	}
	if($name!='')
	{
		$query="UPDATE `user` SET `name`='$name' WHERE `loginID`='$uid'";
		mysqli_query($conn,$query);
	}
	header("Location:../index.php");
}
else
{
	header("Location:../index.php");
}


?>