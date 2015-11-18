<?php
@session_start();
if(isset($_SESSION['uid']) && $_SESSION['type']!=3)
{
	header("Location:../index.php");
	die();
}
include "mysql_connect.php";
$uid = $_SESSION['uid'];

$query="SELECT T.subjectID AS subjectID, subject.name AS name, T.status AS status FROM subject JOIN ( SELECT * FROM student WHERE student.loginID='$uid') AS T ON subject.subjectID=T.subjectID ORDER BY T.subjectID ASC";

if($result=mysqli_query($conn,$query))
{
	echo "<div id='subjects' style='display:block'>";
	if($result->num_rows==0)
	{
		echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>No Subjects Added!</p>";
	}
	else
	{	
		echo "<table class='table table-striped table-hover'><thead><tr><th>SubjectID</th><th>Name</th><th>Status</th><th></th></tr></thead><tbody>";
		$row = $result->fetch_assoc();
		for($i=1;$i<=$result->num_rows;$i++)
		{
			$name='subDetails'.$i;
			switch($row['status'])
			{
				case 0:
					$status='enrolled';
					break;
				case 1:
					$status='Request pending';break;
				case 2:
					$status='Request rejected';break;
				case 3:
					$status='Banned';break;
			}
			echo "<tr id='$name'><td>$row[subjectID]</td><td>$row[name]</td><td>$status</td><td></td></tr>";
			$row = $result->fetch_assoc();
		}
		echo "</tbody></table>";
		echo "</div>";		//ending of the entire subjects div
		
	}
}
else
{
	die(mysqli_error($conn));
}

$query="SELECT * FROM quiz JOIN (SELECT subjectID FROM student WHERE loginID='$uid' AND status=0) AS T ON quiz.subjectID=T.subjectID ORDER BY quiz.time";
if($result=mysqli_query($conn,$query))
{
	echo "<div id='quizzes' style='display:none'>";
	if($result->num_rows==0)
	{
		echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>No Quizzes present!</p>";
	}
	else
	{
		
		echo "<table class='table table-striped table-hover'><thead><tr><th>SubjectID</th><th>QuizID</th><th>Quiz Name</th><th>Scheduled time</th></tr></thead><tbody>";
		$row = $result->fetch_assoc();
		for($i=1;$i<=$result->num_rows;$i++)
		{
			$name='quizDetails'.$i;
			echo "<tr id='$name' onclick='runQuizQuery(\"$row[quizID]\")'><td>$row[subjectID]</td><td>$row[quizID]</td><td>$row[name]</td><td>$row[time]</td></tr>";
			$row = $result->fetch_assoc();
		}
		echo "</tbody></table>";		
		echo "</div>";
	}
}
else
{
	die(mysqli_error($conn));
}
?>
