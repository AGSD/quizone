<?php
	if(file_exists("../res/mysql_connect.php"))
	{
		header("Location:../index.php");
		die();
	}
	session_start();
	$name=$_SESSION['name'];
	$pass=$_SESSION['pass'];
	
	$conn = @mysqli_connect('localhost',$name,$pass);
	$db = @mysqli_select_db($conn,'quizone');
	
	if(!$conn || !$db)
		die("<center>Error: Could not establish connection!</center>");
	
	$login=$_POST['loginID'];
	$password=md5($_POST['pass']);
	$username=$_POST['name'];
	$email=$_POST['email'];
	
	$query = "INSERT INTO `user` VALUES('$login','$password','$email','$username',' ',0);";
	
	if(!mysqli_query($conn,$query))
		die("<center>Error: Could not run the Query!</center>");
		//die(mysqli_error($conn));
	
	/*Make the mysql_connect file for general use and also setting initialisation off*/
	$file = fopen("../res/mysql_connect.php","w");
	fwrite($file,"<?php\n\$conn=@mysqli_connect('localhost','$name','$pass') or die('Error: Could not connect to the MySQL server!');\n@mysqli_select_db(\$conn,'quizone') or die('Error: Could not connect to the Quizone database!');\n?>");
	fclose($file);
	session_destroy();
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
		<span>Thank you!</span>
		<p>You have successfully initiated Quizone and created your Administrator account!</p>
		<p>Click <a href='../index.php'>here</a> to go to the home page!</p>
		</div>
	</div>
</div>
</body>
</html>