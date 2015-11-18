<?php
@session_start();
if(isset($_SESSION['uid']) && $_SESSION['type']!=1)
{
	header("Location:../index.php");
	die();
}
include "mysql_connect.php";
$uid = $_SESSION['uid'];

$query="SELECT T.subjectID AS subjectID, T.name AS name, sum(case when student.status=0 then 1 else 0 end)AS enrolled, sum(case when student.status=1 then 1 else 0 end) AS pending FROM student RIGHT JOIN ( SELECT * FROM subject WHERE subject.loginID='$uid') AS T ON student.subjectID=T.subjectID GROUP BY T.subjectID ORDER BY T.subjectID ASC";

if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
	{
		echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>No Subjects Added!</p>";
	}
	else
	{	echo "<div id='subjects'>";
		echo "<table class='table table-striped table-hover'><thead><tr><th>SubjectID</th><th>Name</th><th>Students Enrolled</th><th>Requests Pending</th><th></th></tr></thead><tbody>";
		for($i=1;$i<=$result->num_rows;$i++)
		{
			$name='subDetails'.$i;
			$enrName = 'sub'.$i.'enr';
			$pendName = 'sub'.$i.'pend';
			$row = $result->fetch_assoc();
			echo "<tr id='$name' title='click to view students' onclick='showSubject($i,$result->num_rows)'><td>$row[subjectID]</td><td>$row[name]</td><td id='$enrName'>$row[enrolled]</td><td id='$pendName'>$row[pending]</td>";
			echo "<td class='text-right'><button class='btn btn-danger' onclick='runQuery(\"$name\",0,\"$row[subjectID]\")'>delete</button></td></tr>";
		}
		echo "</tbody></table>";
		/*End of subject listing, now start specific subject student lists*/
		
		$result->data_seek(0);
		for($i=1;$i<=$result->num_rows;$i++)
		{
			$row=$result->fetch_assoc();
			$name='sub'.$i;
			echo "<div id='$name' style='display:none'>";
			echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Students for SubjectID:$row[subjectID] Subject Name:$row[name]</p>";
			$query = "SELECT loginID,name,email FROM user JOIN (SELECT loginID AS login,subjectID FROM student WHERE subjectID='$row[subjectID]' AND status=0) AS B ON B.login=loginID ORDER BY loginID";
			if($res1=mysqli_query($conn,$query))
			{
				if($res1->num_rows>0)
					echo "<table class='table table-striped'><thead><tr><th>LoginID</th><th>Name</th><th>Email</th><th></th></tr></thead><tbody>";
				else
					echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>No students found!</p>";
				for($j=1;$j<=$res1->num_rows;$j++)
				{
					$row1 = $res1->fetch_assoc();
					$name1 = $name.'enr'.$j;
					echo "<tr id='$name1'><td>$row1[loginID]</td><td>$row1[name]</td><td>$row1[email]</td>";
					echo "<td class='text-right'><button class='btn btn-danger' onclick='runQuery(\"$name1\",1,\"$row[subjectID]\",\"$row1[loginID]\")'>remove</button></td></tr>";
				}
				echo "</tbody></table>";
			}
			else
				die(mysqli_error($conn));
			
			echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Pending requests:</p>";
			$query = "SELECT loginID,name,email FROM user JOIN (SELECT loginID AS login FROM student WHERE subjectID='$row[subjectID]' AND status=1) AS B ON B.login=loginID ORDER BY loginID";
			if($res1=mysqli_query($conn,$query))
			{
				if($res1->num_rows>0)
					echo "<table class='table table-striped'><thead><tr><th>LoginID</th><th>Name</th><th>Email</th><th></th></tr></thead><tbody>";
				else
					echo "<p class='text-center' style='font-weight:bold;color:#7AA3CC'>No requests found!</p>";
				for($j=1;$j<=$res1->num_rows;$j++)
				{
					$row1 = $res1->fetch_assoc();
					$name1 = $name.'pend'.$j;
					echo "<tr id='$name1'><td>$row1[loginID]</td><td>$row1[name]</td><td>$row1[email]</td>";
					echo "<td class='text-right'><button class='btn btn-success' onclick='runQuery(\"$name1\",2,\"$row[subjectID]\",\"$row1[loginID]\")'>accept</button>";
					echo "<button class='btn btn-danger' onclick='runQuery(\"$name1\",3,\"$row[subjectID]\",\"$row1[loginID]\")'>reject</button></td></tr>";
				}
				echo "</tbody></table>";
			}
			else
				die(mysqli_error($conn));
			
			
			echo "</div>";	//ending of one subject div
		}
		
		echo "</div>";		//ending of the entire subjects div
	}
}
else
{
	die(mysqli_error($conn));
}

$query="SELECT * FROM quiz JOIN (SELECT subjectID FROM subject WHERE loginID='$uid') AS T ON quiz.subjectID=T.subjectID ORDER BY quiz.time";
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
