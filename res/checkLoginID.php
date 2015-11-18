<?php 
if(!isset($_POST['login']))
{
	header("Location:../index.php");
}

$login = $_POST['login'];

include 'mysql_connect.php';

$query="SELECT * FROM `user` WHERE `loginID`='$login'";
if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
		echo "0";	//available
	else
		echo "1";	//unavailable
}
else
{
	echo "2"; //Error: Could not pass query!
}

?>