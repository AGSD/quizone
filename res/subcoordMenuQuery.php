<?php 
session_start();
if((isset($_SESSION['uid']) && $_SESSION['type']!=1) && isset($_POST['op']))
{
	header("Location:../index.php");
	die();
}
$op=$_POST['op'];
$subjectID=$_POST['subjectID'];
include 'mysql_connect.php';
switch($op)
{
	case 0:
		$query="DELETE FROM subject WHERE subjectID='$subjectID'";
		break;
	case 1:
		$loginID=$_POST['loginID'];
		$query="DELETE FROM student WHERE subjectID='$subjectID' AND loginID='$loginID'";
		break;
	case 2:
		$loginID=$_POST['loginID'];
		$query="UPDATE student SET status=0 WHERE subjectID='$subjectID' AND loginID='$loginID'";
		break;
	case 3:
		$loginID=$_POST['loginID'];
		$query="UPDATE student SET status=2 WHERE subjectID='$subjectID' AND loginID='$loginID'";
		break;
}

if(mysqli_query($conn,$query))
	echo '0';		//signifies succeful query run
else
	echo '1'		//unsuccessful query run

?>