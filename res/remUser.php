<?php
if(isset($_POST['login']))
{
	$login = $_POST['login'];
	
	include("mysql_connect.php");
	$query="DELETE FROM user WHERE loginID='$login'";
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