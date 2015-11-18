<?php
session_start();
if(isset($_SESSION['uid']))
{
	header("Location:../index.php");
	die();
}

include("mysql_connect.php");

$login = $_POST['uid'];
$password = md5($_POST['pass']);

$query = "SELECT * FROM `user` WHERE `loginID`='$login' AND `password`='$password'";
$final = strip_tags($query);

$result = mysqli_query($conn,$final);

if($result==false)
{
	echo "<center>Error: Could not pass query!</center>";
	die();
}

if($result->num_rows>0)
{
	$row = $result->fetch_assoc();
	
	mysqli_free_result($result);
	
	$_SESSION['uid']=$row["loginID"];
	$_SESSION['type']=$row["type"];
	$_SESSION['name']=$row["name"];
	
	if($row['type']=='0')
	{
		echo "";
		die();
	}
	echo "";
	die();
}
else
{
	echo "Invalid login details!";
}
?>