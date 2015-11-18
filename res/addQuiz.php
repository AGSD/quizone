<?php
if(isset($_POST['quizid']))
{
	$quizid = $_POST['quizid'];
	$quizname = $_POST['quizname'];
	$qsubid = $_POST['qsubid'];
	$time = $_POST['time'];
	$duration = $_POST['duration'];
	
	//echo $time."<br>";
	//echo $duration;
	
	session_start();
	
	
	//str_replace("T"," ",$time);
	for($i=0;$i<strlen($time) && $time[$i]!='T';$i++);
	$time[$i]=' ';
	$ftime = $time.":00";
	$fduration = $duration.":00";
	
	//echo '<br>'.$ftime."<br>";
	//echo $fduration;
	
	$eventStart=$quizid.'start';
	$eventStop=$quizid.'stop';
	
	include "mysql_connect.php";
	$query="INSERT INTO `quiz` VALUES('$quizid','$quizname','$qsubid','','$ftime','$fduration','0','0','0');";	//status is 0 for future quiz, 1 for active, 2 for over, evaluated is 0 for not evaluated, 1 for evaluated.
	$eventStartQuery="CREATE EVENT $eventStart ON SCHEDULE AT '$ftime' DO UPDATE quiz SET status='1' WHERE quizid='$quizid';";
	$eventStopQuery="CREATE EVENT $eventStop ON SCHEDULE AT ADDTIME('$ftime','$fduration') DO UPDATE quiz SET status='2' WHERE quizid='$quizid';";
	$finalQuery=$query.$eventStartQuery.$eventStopQuery;
	//echo '<br>'.$finalQuery;
	if(mysqli_multi_query($conn,$finalQuery))
	{
		$_SESSION['quizid']=$_POST['quizid'];
		$_SESSION['quesno']=1;
		header("Location:../newQuiz.php");
		echo "done!";
		die();
	}
	else
	{
		echo "error1";
		die(mysqli_error($conn));
	}
	
}
else
{
	header("Location:../index.php");
	echo "error2";
	die();
}
?>