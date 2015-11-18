<?php
if(!isset($_POST['quizid']))
{
	header("Location:index.php");
	die();
}
session_start();
$quizid=$_POST['quizid'];
$uid=$_SESSION['uid'];

include 'mysql_connect.php';
$query="SELECT * FROM student JOIN (SELECT subjectID FROM quiz WHERE quizID='$quizid') AS T ON student.subjectID = T.subjectID WHERE loginID='$uid' AND status=0";
if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
	{
		echo "1";
	}
	else
	{
		$query="SELECT *,UNIX_TIMESTAMP(ADDTIME(time,duration)) AS finalTime, UNIX_TIMESTAMP(time) AS startTime FROM quiz WHERE quizID='$quizid'";
		if($result=mysqli_query($conn,$query))
		{
			$row=$result->fetch_assoc();
			$_SESSION['quizid']=$quizid;
			$_SESSION['quesno']=1;
			$_SESSION['numques']=$row['numques'];
			$_SESSION['status']=$row['status'];
			$_SESSION['finalTime']=$row['finalTime'];
			$_SESSION['startTime']=$row['startTime'];
			echo "0";
		}
	}
	
}
else
{
	die(mysqli_error($conn));
}
?>