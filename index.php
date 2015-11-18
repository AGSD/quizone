<?php
	if(!file_exists("res/mysql_connect.php"))
		header("Location:init/init.php");
	
	session_start();
	if(isset($_SESSION['uid']))
	{
		if($_SESSION['type']==0)
		{
			header("Location:admin.php");
			die();
		}
		else if($_SESSION['type']==1)
		{
			header("Location:subcoord.php");
			die();
		}
		else if($_SESSION['type']==2)
		{
			header("Location:invig.php");
			die();
		}
		else if($_SESSION['type']==3)
		{
			header("Location:student.php");
			die();
		}
	}
	
	include 'res/mysql_connect.php';
	mysqli_query($conn,"SET GLOBAL event_scheduler = ON") or die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Quizone - The Network Quizzing platform</title>
<meta charset="utf-8">
<meta name="viewport" id='viewport' content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="res/style/main.css">
<script src="res/js/jquery.js"></script>
<script src="res/bootstrap/js/bootstrap.min.js"></script>
<script>
function validate()
{
	var ar = [document.forms['login']['uid'].value,document.forms['login']['pass'].value];
	var i;
	
	for(i=0;i<ar.length;++i)
	{
		if(ar[i]==null || ar[i]=="")
		{
			document.getElementById('error').innerHTML="All fields are necessary!";
			return false;
		}
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			if(xmlhttp.responseText!="")
			{
				document.getElementById("error").innerHTML = xmlhttp.responseText;
				return false;
			}
			else
			{
				location.reload();
			}				
		}
	}
	xmlhttp.open("POST", "res/auth.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "uid="+ar[0]+"&pass="+ar[1];
	xmlhttp.send(sendString);
	return false;
}
function account()
{
	alert("Please login to view your account!");
	document.getElementById("login").focus();
	document.getElementById("login").style.border="2px solid #CCFF66";
}
</script>
</head>
<body background="">
<?php include "res/header.php"; ?>
<div class='container-fluid'>
	<div class="row" style="margin:5px">
		<div class="col-sm-1"></div>
		<div class="col-sm-10 component"><h1>Welcome to Quizone!</h1><p>Quizone is a network based test taking platform for ease of access, evaluation
		and record retrieval.</p>
		</div>
		<div class="col-sm-1"></div>
	</div>
	<div class='row' style="margin:5px">
		<div class='col-sm-1'></div>
		<div class='col-sm-3 component' id="login">
			<h2 >User login:</h2>
			<form role="form" name='login' method='post' action='res/auth.php' onsubmit='return validate()'>
			  <div class="form-group">
				<label for="loginID">LoginID:</label>
				<input class="form-control" name="uid" id="loginID">
			  </div>
			  <div class="form-group">
				<label for="pwd">Password:</label>
				<input type="password" class="form-control" name="pass" id="pwd">
			  </div>
			  <div style="color:red"><p id='error'></p></div>
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>
			
		</div>
		<div class='col-sm-4'></div>
		<div class='col-sm-3'></div>
		<div class='col-sm-1'></div>
	</div>
</div>
</body>
</html>