<?php 
if(!isset($_POST['subid']))
{
	header("Location:../index.php");
}

$subid = $_POST['subid'];

include 'mysql_connect.php';

$query="SELECT * FROM `subject` WHERE `subjectID`='$subid'";
if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
		echo "0";	//available or Not already present, so can't be used by a student for a request
	else
		echo "1";	//unavailable or already present, so can be used by a student for a request
}
else
{
	echo "2"; //Error: Could not pass query!
}

?>