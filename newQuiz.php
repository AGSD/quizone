<?php	
	session_start();
	if(isset($_SESSION['type']) && $_SESSION['type']!=1 && isset($_SESSION['quizid']))
		header("Location:index.php");
	
	$qno=$_SESSION['quesno'];
	$name='ques'.$qno;
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
				<h3 class="text-center" style="color:#7AA3CC">Add new quiz</h3>
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
	<div class='row' style='margin:5px'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10 component'>
			<form class="form-horizontal" role="form" name='questions' method='post' action='res/addQuestion.php' onsubmit="return validate()">
				<div class='form-group' id='ques'>
					<div class="form-group">
					  <?php echo"<label class='control-label col-sm-2' for='quesno'>Question $qno</label>"; ?>
					  <div class="col-sm-8">
						<?php echo "<input type='hidden' name='quesno' id='quesno' value='$qno'>"; ?>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="questext">Question text:</label>
					  <div class="col-sm-8">
						<textarea type="text" class="form-control" rows='5' name='questext' id='questext' placeholder="Question" autocomplete='off'></textarea>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="op1">Option 1:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='op1' id='op1' placeholder="Option 1" autocomplete='off'>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="op2">Option 2:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='op2' id='op2' placeholder="Option 2" autocomplete='off'>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="op3">Option 3:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='op3' id='op3' placeholder="Option 3" autocomplete='off'>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-2" for="op4">Option 4:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='op4' id='op4' placeholder="Option 4" autocomplete='off'>
					  </div>
					</div>
					<div class='form-group'>
						<label class='control-label col-sm-2' for='answer'>Answer:</label>
						<div class='col-sm-8'>
							<select class='form-control' name='answer' id='answer'>
								<option value='1'>Option 1</option>
								<option value='2'>Option 2</option>
								<option value='3'>Option 3</option>
								<option value='4'>Option 4</option>
							</select>
						</div>
					</div>
					<div class="col-sm-offset-9 col-sm-12">
						<button type="submit" class="btn btn-primary">Add Question</button>
					</div>
				</div>
			</form>
			<div class='col-sm-12 text-center'>
				<button type='button' class="btn btn-primary" onclick="window.location.href = 'res/finishQuiz.php'">Finish</button>
			</div>
		</div>
		<div class='col-sm-1'></div>
	</div>
</div>
<div id='footer'></div>
</body>
</html>