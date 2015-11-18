<?php	
	session_start();
	if(isset($_SESSION['type']) && $_SESSION['type']!=1)
		header("Location:index.php");
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
window.onload = function() {
	if(window.innerWidth<600)
	{
		document.getElementById('viewport').content='width=600, initial-scale=1';
	}
	
}
var subjectFine=false;	//a flag to check whether subjectID entered is available or not
var quizFine=false;
function makeVisible(num)
{
	var field=['subform','modform','addquiz'];
	var i;
	for(i=0;i<field.length;++i)
	{
		if(i!=num)
		{
			document.getElementById(field[i]).style.display='none';
			document.getElementById("li"+i.toString()).className='';
		}
		else
		{
			document.getElementById(field[i]).style.display='block';
			document.getElementById("li"+i.toString()).className='active';
		}
	}
}
function showSubject(subnum,totalSubs)
{
	var i;
	for(i=1;i<=totalSubs;++i)
	{
		if(i!=subnum)
			document.getElementById("sub"+i.toString()).style.display='none';
		else
			document.getElementById("sub"+i.toString()).style.display='block';
	}
}
function checkSubject(subid)
{
	if(subid=='')
	{
		document.getElementById('subjectCheck').innerHTML="";
		return false;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				subjectFine=true;
				document.getElementById('subjectCheck').innerHTML="";
				return true;
			}
			else if(xmlhttp.responseText=='1')
			{
				document.getElementById('subjectCheck').innerHTML="<p>Subject ID already in use!</p>";
				document.getElementById('subjectCheck').style.color="red";
				subjectFine=false;
				return false;
			}
			else
			{
				document.getElementById('subjectCheck').innerHTML="<p>Error!</p>";
				document.getElementById('subjectCheck').style.color="red";
				subjectFine=false;
				return false;
			}
		}
	}
	
	xmlhttp.open("POST", "res/checkSubjectID.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "subid="+subid;
	xmlhttp.send(sendString);
	subjectFine=false;
	return false;
}
function validateAddSub()
{
	var ar = [document.forms['subform']['subid'].value,document.forms['subform']['subname'].value];
	var i;
	
	for(i=0;i<ar.length;++i)
	{
		if(ar[i]==null || ar[i]=="")
		{
			document.getElementById('addSubError').innerHTML="<p>All fields are necessary!</p>";
			document.getElementById('addSubError').style.color="red";
			return false;
		}
	}
	
	if(subjectFine==true)
	{
		alert("Succesfully added Subject "+document.getElementById('subname').value);
		return true;
	}
	else
	{
		document.getElementById('addSubError').innerHTML="<p>Kindly resolve the issues marked in red</p>";
		document.getElementById('addSubError').style.color="red";
		return false;
	}
}

function validateAddQuiz()
{
	var ar = [document.forms['quizform']['quizid'].value,document.forms['quizform']['quizname'].value,document.forms['quizform']['qsubid'].value,document.forms['quizform']['time'].value,document.forms['quizform']['duration'].value];
	var i;
	
	for(i=0;i<ar.length;++i)
	{
		if(ar[i]==null || ar[i]=="")
		{
			document.getElementById('addQuizError').innerHTML="<p>All fields are necessary!</p>";
			document.getElementById('addQuizError').style.color="red";
			return false;
		}
	}
	
	if(quizFine==true)
	{
		return true;
	}
	else
	{
		document.getElementById('addQuizError').innerHTML="<p>Kindly resolve the issues marked in red</p>";
		document.getElementById('addQuizError').style.color="red";
		return false;
	}
}

function checkOldPass(pass)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				document.getElementById('newpass').disabled=false;
			}
			else if(xmlhttp.responseText=='1')
			{
				document.getElementById('newpass').disabled=true;
			}
			else
			{
				
				alert("Error in oldPass"+xmlhttp.responseText);
			}
			
		}
	}
	
	xmlhttp.open("POST", "res/checkOldPass.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "pass="+pass;
	xmlhttp.send(sendString);
	return false;
}
function runQuery(name,option,val1,val2)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				document.getElementById(name).style.display='none';
				if(option==0)
				{
					name="sub"+name.substring(10);
					document.getElementById(name).innerHTML='';
				}
				else
				{
					var i;
					for(i=3;!isNaN(name.charAt(i));++i);
					name=name.substring(0,i);
					if(option==1)
					{
						var enr=parseInt(document.getElementById(name+'enr').innerHTML);
						document.getElementById(name+'enr').innerHTML=enr-1;
					}
					else if(option==2)
					{
						var pend=parseInt(document.getElementById(name+'pend').innerHTML);
						document.getElementById(name+'pend').innerHTML=pend-1;
						
						var enr=parseInt(document.getElementById(name+'enr').innerHTML);
						document.getElementById(name+'enr').innerHTML=enr+1;
					}
					else if(option==3)
					{
						var pend=parseInt(document.getElementById(name+'pend').innerHTML);
						document.getElementById(name+'pend').innerHTML=pend-1;
					}
				}
			}
			else
			{
				alert('Could not complete action!'+xmlhttp.responseText);
			}
		}
	}
	var sendString;
	switch(option)
	{
		case 0:
			sendString="op=0&subjectID="+val1;
			break;
		case 1:
			sendString="op=1&subjectID="+val1+"&loginID="+val2;
			break;
		case 2:
			sendString="op=2&subjectID="+val1+"&loginID="+val2;
			break;
		case 3:
			sendString="op=3&subjectID="+val1+"&loginID="+val2;
			break;
		
	}
	
	xmlhttp.open("POST","res/subcoordMenuQuery.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(sendString);
}
function checkQuiz(quizid)
{
	if(quizid=='')
	{
		document.getElementById('subjectCheck').innerHTML="";
		return false;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				quizFine=true;
				document.getElementById('quizCheck').innerHTML="";
				return true;
			}
			else if(xmlhttp.responseText=='1')
			{
				document.getElementById('quizCheck').innerHTML="<p>Quiz ID already in use!</p>";
				document.getElementById('quizCheck').style.color="red";
				quizFine=false;
				return false;
			}
			else
			{
				document.getElementById('quizCheck').innerHTML="<p>Error!</p>";
				document.getElementById('quizCheck').style.color="red";
				quizFine=false;
				return false;
			}
		}
	}
	
	xmlhttp.open("POST", "res/checkQuizID.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "quizid="+quizid;
	xmlhttp.send(sendString);
	quizFine=false;
	return false;
}
function tabTo(str)
{
	if(str=='sub')
	{
		document.getElementById('quizzes').style.display='none';
		document.getElementById('subjects').style.display='block';
		
		document.getElementById('quiz').className='';
		document.getElementById('sub').className='active';
	}
	else if(str=='quiz')
	{
		document.getElementById('quizzes').style.display='block';
		document.getElementById('subjects').style.display='none';
		
		document.getElementById('quiz').className='active';
		document.getElementById('sub').className='';
	}
}
function runQuizQuery(quizid)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				window.location='result.php';
			}
			else
			{
				alert('Could not complete action!'+xmlhttp.responseText);
			}
		}
	}
	var sendString="quizid="+quizid;
	
	xmlhttp.open("POST","res/preQuizSubcoord.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(sendString);
}
function account()
{
	alert("Account already open!");
}
</script>
</head>
<body>
<?php include "res/header.php"; ?>
<div class='container-fluid'>
	<div class='row' style="margin:5px;">
		<div class='col-sm-1'></div>
		<div class='col-sm-10 component' style='padding:5px;'>
			<ul class='nav nav-pills'>
				<li id='li0'><a onclick="makeVisible(0)">Add Subject</a></li>
				<li id='li1'><a onclick="makeVisible(1)">Modify account details</a></li>
				<li id='li2'><a onclick="makeVisible(2)">Add new Quiz</a></li>
				<li><a href='res/logout.php'>Logout</a></li>
			</ul>
		</div>		
		<div class='col-sm-1'></div>
	</div>
	<div class='row' style="margin:5px;">
		<div class='col-sm-3'></div>
		<div class='col-sm-6 component'>
			<div id='placeHolder'>
				<h3 class="text-center" style="color:#7AA3CC">Subject Coordinator panel</h3>
			</div>
			<div id='subform' style="display:none">
				<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Enter details to add a new subject:</p>
				<form class="form-horizontal" role="form" name='subform' method='post' action='res/addSub.php' onsubmit="return validateAddSub()">
					<div class="form-group">
					  <label class="control-label col-sm-4" for="subid">SubjectID:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='subid' id='subid' placeholder="Enter Subject ID" onkeyup="checkSubject(this.value)" autocomplete='off'>
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='subjectCheck' class='col-sm-8'></div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="subname">Subject Name:</label>
					  <div class="col-sm-8">          
						<input type="text" class="form-control" name='subname' id="subname" placeholder="Enter Subject name">
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='addSubError' class='col-sm-8'></div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-offset-9 col-sm-12">
						<button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					</div>
			  </form>
			</div>
			<div id='modform' style="display:none">
				<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Enter details to be modified for your account:</p>
				<form class="form-horizontal" role="form" name='modform' method='post' action='res/modUser.php'>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="oldpass">Old Password:</label>
					  <div class="col-sm-8">          
						<input type="password" class="form-control" id="oldpass" placeholder="Enter old password" onkeyup='checkOldPass(this.value)'>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="newpass" >New Password:</label>
					  <div class="col-sm-8">          
						<input type="password" class="form-control" name='pass' id="newpass" placeholder="Enter new password" disabled>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="newemail">Email:</label>
					  <div class="col-sm-8">          
						<input type="email" class="form-control" name='email' id="newemail" placeholder="Enter Email">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="newname">Full Name:</label>
					  <div class="col-sm-8">          
						<input type="text" class="form-control" name='name' id="newname" placeholder="Enter Name">
					  </div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-offset-9 col-sm-12">
						<button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					</div>
				</form>
			</div>
			<div id='addquiz' style="display:none">
				<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Enter details to add a new Quiz:</p>
				<form class="form-horizontal" role="form" name='quizform' method='post' action='res/addQuiz.php' onsubmit="return validateAddQuiz()">
					<div class="form-group">
					  <label class="control-label col-sm-4" for="quizid">QuizID:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='quizid' id='quizid' placeholder="Enter Quiz ID" onkeyup="checkQuiz(this.value)" autocomplete='off'>
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='quizCheck' class='col-sm-8'></div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="quizname">Quiz Name:</label>
					  <div class="col-sm-8">          
						<input type="text" class="form-control" name='quizname' id="quizname" placeholder="Enter Quiz name">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="qsubid">SubjectID:</label>
					  <div class="col-sm-8">          
						<select type="text" class="form-control" name='qsubid' id="qsubid" placeholder="Select type">
							<?php 
								include "res/mysql_connect.php";
								$query="SELECT subjectID FROM subject WHERE loginID='$_SESSION[uid]'";
								if($result=mysqli_query($conn,$query))
								{
									for($i=0;$i<$result->num_rows;$i++)
									{
										$row=$result->fetch_assoc();
										echo "<option value='$row[subjectID]'>$row[subjectID]</option>";
									}
								}
								else
									alert(mysqli_error($conn));
								mysqli_close($conn);
							?>
						</select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="time">Start Time:</label>
					  <div class="col-sm-8">          
						<input type="datetime-local" class="form-control" name='time' id="time" placeholder="Enter start time">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="duration">Duration:</label>
					  <div class="col-sm-8">          
						<input type="time" class="form-control" name='duration' id="duration" placeholder="Enter Quiz duration">
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='addQuizError' class='col-sm-8'></div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-offset-9 col-sm-12">
						<button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					</div>
			  </form>
			
			</div>
		</div>
		<div class='col-sm-3'></div>
	</div>
	<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10 component'>
			<div class='row' name='tab-holder'>
				<div class='col-sm-12'>
					<ul class='nav nav-tabs' style='float:center'>
						<li id='sub' class='active'><a onclick="tabTo('sub')">My Subjects</a></li>
						<li id='quiz'><a onclick="tabTo('quiz')">My Quizzes</a></li>
					</ul>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12' id='menuPopulater'>
					<?php include 'res/populateSubcoordMenu.php'; ?>
				</div>
			</div>
		</div>
		<div class='col-sm-1'></div>
	</div>
</div>
<div id='footer'></div>
</body>
</html>