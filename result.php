<?php
session_start();
if(!isset($_SESSION['quizid']) && !isset($_SESSION['uid']) && !($_SESSION['type']==1 || $_SESSION['type']==3))
{
	header("Location:index.php");
	die();
}

$uid = $_SESSION['uid'];
$quizid=$_SESSION['quizid'];
$type = $_SESSION['type'];
$numques = $_SESSION['numques'];

?>
<!DOCTYPE html>
<html lang='en'>
<head><title>Quizone - The Network Quizzing platform</title>
<meta charset="utf-8">
<meta name="viewport" id='viewport' content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="res/style/main.css">
<script src="res/js/jquery.js"></script>
<script src="res/bootstrap/js/bootstrap.min.js"></script>
<script>

</script>
</head>
<body>
<?php include "res/header.php"; ?>
<div class='container-fluid'>
	<div class='row' style="margin:5px;">
		<div class='col-sm-3'></div>
		<div class='col-sm-6 component'>
			<div id='placeHolder'>
			</div>
			<?php include 'res/mysql_connect.php';
			$query="SELECT * FROM quiz WHERE quizid='$_SESSION[quizid]'";
			if($result=mysqli_query($conn,$query))
			{
				$row=$result->fetch_assoc();
				echo "<p>";
				echo "<div class='control-label col-sm-6 text-right' style='font-weight:bold'>Quiz ID:</div><div class='col-sm-6'>$row[quizID]</div>";
				echo "<div class='control-label col-sm-6 text-right' style='font-weight:bold'>Quiz Name:</div><div class='col-sm-6'>$row[name]</div>";
				echo "<div class='control-label col-sm-6 text-right' style='font-weight:bold'>Subject ID:</div><div class='col-sm-6'>$row[subjectID]</div>";
				echo "</p>";
			}
			else
				alert(mysqli_error($conn));
			?>
		</div>
		<div class='col-sm-3'></div>
	</div>
	<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10 component'>
			<?php
				if($type==1)
				{
					include 'res/mysql_connect.php';
					$query="SELECT evaluated,status FROM quiz WHERE quizID='$quizid'";
					if($result=mysqli_query($conn,$query))
					{
						$res = $result->fetch_assoc();
						$evaluated=$res['evaluated'];
						
						if($res['status']!=2)
						{
							die("<h3 class='text-center' style='color:#7AA3CC'>Quiz has not finished</h3>");
						}
						
						if($evaluated==0)
						{
							$query="SELECT loginID FROM student JOIN (SELECT subjectID FROM quiz WHERE quizID='$quizid') AS T ON student.subjectId=T.subjectID ORDER BY loginID";
							if($result=mysqli_query($conn,$query))
							{
								for($i=1;$i<=$result->num_rows;$i++)	//iterate over all students
								{
									$row=$result->fetch_assoc();
									$userid = $row['loginID'];
									$query = "SELECT T.opno as opno,q.answer AS answer FROM (SELECT answer,quesno FROM question WHERE quizID='$quizid') AS q LEFT JOIN (SELECT * FROM response WHERE loginID='$userid' AND quizID='$quizid') AS T ON T.quesno=q.quesno";
									if($res=mysqli_query($conn,$query))
									{
										$correct=0;
										$incorrect=0;
										for($j=1;$j<=$res->num_rows;$j++)	//iterate over all answers
										{
											$val = $res->fetch_assoc();
											$selected = $val['opno'];
											$answer = $val['answer'];
											if($selected!='')
											{
												if($selected==$answer)
													$correct++;
												else
													$incorrect++;
											}
										}
										
										$query="INSERT INTO result VALUES('$userid','$quizid','$correct','$incorrect','$numques')";
										mysqli_query($conn,$query) or die(mysqli_error($conn));
									}
									else
										die(mysqli_error($conn));
								}
								
								$query="UPDATE quiz SET evaluated=1 WHERE quizID='$quizid'";
								mysqli_query($conn,$query) or die(mysqli_error($conn));
								echo "<h3 class='text-center' style='color:#7AA3CC'>Results have been evaluated, refresh the page!</h3>";
							}
							else
								die(mysqli_error($conn));
						}
						else	//evaluation has been done
						{
							$query="SELECT user.loginID AS loginID,name,T.correct AS correct,T.incorrect AS incorrect, T.total AS total FROM user JOIN (SELECT * FROM result WHERE quizID='$quizid' ORDER BY loginID ASC) AS T ON T.loginID=user.loginID";
							if($result=mysqli_query($conn,$query))
							{
								echo "<table class='table table-striped table-hover'><thead><tr><th>LoginID</th><th>Student Name</th><th>Correct</th><th>Incorrect</th><th>Total</th></tr></thead><tbody>";
								for($i=1;$i<=$result->num_rows;$i++)
								{
									$row = $result->fetch_assoc();
									echo "<tr><td>$row[loginID]</td><td>$row[name]</td><td>$row[correct]</td><td>$row[incorrect]</td><td>$row[total]</td></tr>";
								}
								echo "</tbody></table>";
							}
							else
								die(mysqli_error($conn));
						}
					}
					else
					{
						die(mysqli_error($conn));
					}
				}
				else if($type==3)
				{
					include 'res/mysql_connect.php';
					$$query="SELECT evaluated,status FROM quiz WHERE quizID='$quizid'";
					if($result=mysqli_query($conn,$query))
					{
						$res = $result->fetch_assoc();
						$evaluated=$res['evaluated'];
						
						if($res['status']!=2)
						{
							die("<h3 class='text-center' style='color:#7AA3CC'>Quiz has not finished</h3>");
						}
						
						if($evaluated==1)
						{
							$query="SELECT user.loginID AS loginID,name,T.correct AS correct,T.incorrect AS incorrect,T.total AS total FROM user JOIN (SELECT * FROM result WHERE quizID='$quizid' AND loginID='$uid' ORDER BY loginID ASC) AS T ON T.loginID=user.loginID";
							if($result=mysqli_query($conn,$query))
							{
								echo "<table class='table table-striped table-hover'><thead><tr><th>LoginID</th><th>Student Name</th><th>Correct</th><th>Incorrect</th><th>Total</th></tr></thead><tbody>";
								for($i=1;$i<=$result->num_rows;$i++)
								{
									$row = $result->fetch_assoc();
									echo "<tr><td>$row[loginID]</td><td>$row[name]</td><td>$row[correct]</td><td>$row[incorrect]</td><td>$row[total]</td></tr>";
								}
								echo "</tbody></table>";
							}
							else
								die(mysqli_error($conn));
						}
						else
						{
							echo "<h3 class='text-center' style='color:#7AA3CC'>Result not declared!</h3>";
						}
					}
					else
					{
						die(mysqli_error($conn));
					}
				}
			?>
		<div class='col-sm-12 text-center'><a href='index.php' class="btn btn-primary">Back to Account</a></div>
		</div>
		<div class='col-sm-1'></div>
		
	</div>
	
</div>
</body>
</html>