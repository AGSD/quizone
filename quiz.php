<?php
session_start();
if(!isset($_SESSION['uid']) && $_SESSION['type']!=3 && !isset($_SESSION['quizid']))
{
	header("Location:index.php");
	die();
}
$uid = $_SESSION['uid'];
$quizid=$_SESSION['quizid'];
$quesno=$_SESSION['quesno'];


include 'res/mysql_connect.php';
$query="SELECT * FROM quiz WHERE quizID='$_SESSION[quizid]'";

if($result=mysqli_query($conn,$query))
{
	if($result->num_rows==0)
	{
		header("Location:index.php");
		die();
	}
	$row=$result->fetch_assoc();
	$status=$row['status'];
	
	if($status==2)
	{
		header("Location:result.php");
		die();
	}
}
else
{
	die(mysqli_error($conn));
}

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
 $(document).ready(function(){
     setInterval(ajaxcall, 1000);
 });
 function ajaxcall(){
     $.ajax({
         url: 'res/gettime.php',
         success: function(data) {
			 if(data=='-1')
				 window.location.reload();
             else
				$('#timeLeft').html(data);//alert(data);
         }
     });
 }
</script>
</head>
<body>
<?php include "res/header.php"; ?>
<div class='container-fluid'>
	<div class='row' style="margin:5px;">
		<div class='col-sm-3'></div>
		<div class='col-sm-6 component'>
			<div id='placeHolder'>
				<!--<h3 class="text-center" style="color:#7AA3CC"></h3>-->
			</div>
			<?php include 'res/mysql_connect.php';
			$_SESSION['status']=$status;
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
			if($status==0)
			{
				echo "<div class='row' ><h3 class='text-center' style='color:#7AA3CC' id='timeLeft'>--:--:--</h3></div>";
			}
			else if($status==1)
			{
				echo "<div class='row' ><h3 class='text-center' style='color:#7AA3CC' id='timeLeft'>--:--:--</h3></div>";
				$query="SELECT opno FROM response WHERE loginID='$uid' AND quizID='$quizid' AND quesno='$quesno'";
				if($result=mysqli_query($conn,$query))
				{
					if($result->num_rows!=0)
					{
						$row=$result->fetch_assoc();
						$checked=$row['opno'];
					}
					else
					{
						$checked=0;
					}
				}
				else
				{
					die(mysqli_error($conn));
				}
				$query="SELECT * FROM question WHERE quizID='$quizid' AND quesno='$quesno'";
				if($result=mysqli_query($conn,$query))
				{
					if($result->num_rows==0)
					{
						echo "No question";
						die();
					}
					$row=$result->fetch_assoc();
					echo "<div class='row'><h2 class='text-center'>Question $quesno</h2></div>";
					echo "<div class='row'><div class='col-sm-1'></div><div class='col-sm-10'>$row[questext]</div><div class='col-sm-1'></div></div>";
				}
				else
				{
					die(mysqli_error($conn));
				}
				$query="SELECT * FROM `option` WHERE quizID='$quizid' AND quesno='$quesno'";
				if($result=mysqli_query($conn,$query))
				{
					if($result->num_rows==0)
					{
						echo "no options";
						die();
					}
					
					echo "";
					echo "<div class='row'><div class='col-sm-1'></div><div class='col-sm-10'><form name='ansform' action='res/submitAnswer.php' method='post'>";
					$i=1;
					while($row=$result->fetch_assoc())
					{
						$name='op'.$i;
						if($i==$checked)
						{
							echo "<div class='radio bg-info'>
							<label><input type='radio' name='op' value='$row[opno]'>$row[optext]</label>
							</div>";
						}
						else
						{
							echo "<div class='radio'>
							<label><input type='radio' name='op' value='$row[opno]'>$row[optext]</label>
							</div>";
						}
						$i++;
					}
					echo "<div class='form-group'>        
					  <div class=' col-sm-12'>
						<button type='submit' class='btn btn-primary'>Submit Answer</button><button type='reset' class='btn btn-warning'>Reset</button>";
					if($_SESSION['quesno']!=1)
							echo "<button type='submit' formaction='res/prevQues.php' class='btn btn-info'>Previous Question</button>";
					if($_SESSION['numques']>$_SESSION['quesno'])
						echo"<button type='submit' formaction='res/nextQues.php' class='btn btn-info'>Next Question</button>";
					 
					 
					 echo "</div></div>";
					
					echo "<div class='col-sm-1'></div></div>";
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
	<div>
</div>
</body>
</html>