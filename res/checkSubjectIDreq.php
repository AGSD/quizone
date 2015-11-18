<?php 
if(!isset($_POST['subid']))
{
	header("Location:../index.php");
}
session_start();
$subid = $_POST['subid'];
$uid = $_SESSION['uid'];
include 'mysql_connect.php';

$query="SELECT * FROM `subject` WHERE `subjectID`='$subid'";
if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
		echo "0";	//Not already present, so can't be used by a student for a request
	else //already present, so can be used by a student for a request
	{
		//now check if student is already enrolled or so
		$query="SELECT status FROM student WHERE loginID='$uid' AND subjectID='$subid'";
		if($result=mysqli_query($conn,$query))
		{
			if($result->num_rows==0)
				echo "1";	//Everything fine, can be used
			else
			{
				$row=$result->fetch_assoc();
				$status = $row['status'];
				if($status==0)
					echo "2";
				else if($status==1)
					echo "3";
				else if($status==2)
					echo "4";
				else if($status==3)
					echo "5";
				
			}
		}
		else
		{
			echo "10"; //Error
		}
		
	}
}
else
{
	echo "2"; //Error: Could not pass query!
}

?>