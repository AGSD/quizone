<?php 
if(!isset($_POST['pass']))
{
	header("Location:../index.php");
	die();
}

include 'mysql_connect.php';

session_start();
$uid = $_SESSION['uid'];
$pass= md5($_POST['pass']);
$query="SELECT `name` FROM `user` WHERE `loginID`='$uid' AND `password`='$pass'";

if($result=mysqli_query($conn,$query))
{
	if($result->num_rows>0)
		echo "0";	//password was correct
	else
		echo "1";	//password was incorrect
}
else
{
	echo "2"; //ERROR
}

?>