<?php
	if(file_exists("../res/mysql_connect.php"))
	{
		header("Location:../index.php");
		die();
	}
	session_start();
	if(isset($_SESSION['name']))
	{
		header("Location:valbuild.php");
		die();
	}
?>
<!DOCTYPE html>
<html>
<head><title>Get started with Quizone!</title>
<link rel="stylesheet" type="text/css" href="../res/style/init.css">
</head>
<body>

<div id='main'>
	<div id='top'><img src='../pics/logo100.png'></div>
	<div id='content'>
		<div id='text'>
		<span>Welcome to Quizone!</span></br>The free network based platform for tests and quizes!</br>
		<p>To start using Quizone, access to the MySQL server is required.</br>Please enter the username and password,
		to provide database access to Quizone:</p>
		</div>
		<div id='form'>
		<center>
		<?php
			if(isset($_SESSION['invalid']))
			{
				echo "<div id='error'>Incorrect values, could not access MySQL server!</br>Please try again</div>";
				unset($_SESSION['invalid']);
			}
		?>
		<form method='POST' action='valbuild.php'>
		<table>
		<tr><td>username:</td><td><input size='15' name='user'></td></tr>
		<tr><td>password:</td><td><input size='15' type='password' name='pass'></td></tr>
		</table>
		<p><button>Validate</button></p>
		</form>
		</center></div>
	</div>
	
</div>
</body>
</html>