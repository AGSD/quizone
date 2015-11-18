<?php
	/*Validate username password and build the database and tables required*/
	if(file_exists("../res/mysql_connect.php"))
	{
		header("Location:../index.php");
		die();
	}
	session_start();
	if(!isset($_SESSION['name']))
	{
		
		$name = $_POST['user'];
		$pass = $_POST['pass'];
		
		$conn = @mysqli_connect('localhost',$name,$pass);
		
		if(!$conn)
		{
			$_SESSION['invalid']=true;
			header("Location:init.php");
			die();
		}
		
		/*Successful connection, now build the required database using the following composite query*/
		$query = "CREATE DATABASE `quizone`;";
		if(!mysqli_query($conn,$query))
			die("<center>Error: Could not build the database!</center>");
			//die(mysqli_error($conn));
		
		if(!mysqli_select_db($conn,'quizone'))
			die("<center>Error: Could not select database!</center>");
		
		$query = "SET GLOBAL event_scheduler := 1;

CREATE TABLE user
(
loginID varchar(15) PRIMARY KEY,
password varchar(64),
email varchar(40),
name varchar(20),
photo varchar(20),
type int(1)
)ENGINE=Innodb;

CREATE TABLE subject
(
subjectID varchar(20) PRIMARY KEY,
name varchar(30),
loginID varchar(15),
FOREIGN KEY (loginID) REFERENCES user(loginID)
	ON DELETE CASCADE
)ENGINE=Innodb;

CREATE TABLE student
(
subjectID varchar(20),
loginID varchar(15),
status int(2),
CONSTRAINT sub_stu_pair PRIMARY KEY(subjectID,loginID),
FOREIGN KEY (subjectID) REFERENCES subject(subjectID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
FOREIGN KEY (loginID) REFERENCES user(loginID)
	ON DELETE CASCADE

)ENGINE=Innodb;

CREATE TABLE quiz
(
quizID varchar(20) PRIMARY KEY,
name varchar(30),
subjectID varchar(20),
type varchar(20),
time datetime,
duration time,
status int(2),
numques int(10),
evaluated int(2),
FOREIGN KEY (subjectID) REFERENCES subject(subjectID)
	ON DELETE CASCADE
	ON UPDATE CASCADE
)ENGINE=Innodb;

CREATE TABLE invigilator
(
assgn_quizID varchar(20),
auth int(2),
loginID varchar(20),
FOREIGN KEY (loginID) REFERENCES user(loginID)
	ON DELETE CASCADE,
FOREIGN KEY (assgn_quizID) REFERENCES quiz(quizID)
	ON DELETE CASCADE
	ON UPDATE CASCADE	
)ENGINE=Innodb;

CREATE TABLE question(
    quizID varchar(20),
    quesno int(4),
    questext varchar(500),
    answer int(1),
    PRIMARY KEY (quizID,quesno),
    FOREIGN KEY (quizID) REFERENCES quiz(quizID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=Innodb;

CREATE TABLE `option`(
    quizID varchar(20),
    quesno int(4),
    optext varchar(500),
    opno int(2),
    PRIMARY KEY (quizID,quesno,opno),
    FOREIGN KEY (quizID,quesno) REFERENCES question(quizID,quesno)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=Innodb;

CREATE TABLE `response`(
    loginID varchar(20),
    quizID varchar(20),
    quesno int(4),
    opno int(2),
    PRIMARY KEY (quizID,quesno,loginID),
    FOREIGN KEY (quizID,quesno) REFERENCES question(quizID,quesno)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (loginID) REFERENCES user(loginID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=Innodb;

CREATE TABLE `result`(
    loginID varchar(20),
    quizID varchar(20),
    correct int(10),
    incorrect int(10),
    total int(10),
    PRIMARY KEY (quizID,loginID),
    FOREIGN KEY (quizID) REFERENCES quiz(quizID)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY (loginID) REFERENCES user(loginID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE=Innodb;";
		
		if(!mysqli_multi_query($conn,$query))
			die("<center>Error: Could not make tables!</center>");
			//die(mysqli_error($conn));
		$_SESSION['name']=$name;
		$_SESSION['pass']=$pass;
		
	}
?>
<!DOCTYPE html>
<html>
<head><title>Get started with Quizone!</title>
<link rel="stylesheet" type="text/css" href="../res/style/init.css">
<script>
function validate()
{
	var ar = [document.forms['userForm']['loginID'].value,document.forms['userForm']['pass'].value,document.forms['userForm']['name'].value,document.forms['userForm']['email'].value];
	var i;
	
	for(i=0;i<ar.length;++i)
	{
		if(ar[i]==null || ar[i]=="")
		{
			document.getElementById('error').innerHTML="All fields are necessary!";
			return false;
		}
	}
	return true;
}
</script>
</head>
<body>

<div id='main'>
	<div id='top'><img src='../pics/logo100.png'></div>
	<div id='content'>
		<div id='text'>
		<p>Validation was successful!</br>Please fill the following details to create the web administrator account for Quizone:</p>
		</div>
		<div id='form'>
		<center>
		<p><div id='error'></div></p>
		<form name='userForm' method='POST' action='finished.php' onsubmit='return validate()'>
		<table>
		<tr><td>loginID:</td><td><input size='15' name='loginID' value='admin' readonly></td></tr>
		<tr><td>Password:</td><td><input size='15' type='password' name='pass'></td></tr>
		<tr><td>Name:</td><td><input size='15' name='name'></td></tr>
		<tr><td>Email:</td><td><input size='15' name='email'></tr></tr>
		</table>
		<p><button>Validate</button></p>
		</form>
		
		</center></div>
	</div>
	
</div>

</body>
</html>