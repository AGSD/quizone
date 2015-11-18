<?php	
	session_start();
	if(isset($_SESSION['type']) && $_SESSION['type']!=0)
		header("Location:index.php");
?>
<!DOCTYPE html>
<html lang='en'>
<head><title>Quizone - The Network Quizzing platform</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="res/style/main.css">
<script src="res/js/jquery.js"></script>
<script src="res/bootstrap/js/bootstrap.min.js"></script>
<script>
window.onload = function() {
	if(window.innerWidth<500)
	{
		document.getElementById('viewport').content='width=500, maximum-scale=1';
	}
	
}
var loginFine=false;	//a flag to check whether loginID entered is available or not
var remloginFine=false;
function makeVisible(num)
{
	var field=['addform','modform','remform','reset'];
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
function checkLogin(login)
{
	if(login=='')
	{
		document.getElementById('loginCheck').innerHTML="";
		return false;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				document.getElementById('loginCheck').innerHTML="<p>login ID available!</p>";
				document.getElementById('loginCheck').style.color="green";
				loginFine=true;
				return true;
			}
			else if(xmlhttp.responseText=='1')
			{
				document.getElementById('loginCheck').innerHTML="<p>login ID unavailable!</p>";
				document.getElementById('loginCheck').style.color="red";
				loginFine=false;
				return false;
			}
			else
			{
				document.getElementById('loginCheck').innerHTML="<p>Error!</p>";
				document.getElementById('loginCheck').style.color="red";
				loginFine=false;
				return false;
			}
		}
	}
	
	xmlhttp.open("POST", "res/checkLoginID.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "login="+login;
	xmlhttp.send(sendString);
	loginFine=false;
	return false;
}
function checkPassword(pass){
	if(pass=='')
	{
		document.getElementById('passwordCheck').innerHTML="";
		return false;
	}
	
	var passOne = document.getElementById('pass').value;
	if(pass==passOne)
	{
		document.getElementById('passwordCheck').innerHTML="<p>Passwords match!</p>";
		document.getElementById('passwordCheck').style.color="green";
		return true;
	}
	else
	{
		document.getElementById('passwordCheck').innerHTML="<p>Passwords do not match!</p>";
		document.getElementById('passwordCheck').style.color="red";
		return false;
	}
}
function checkPasswordWrap()
{
	var passre=document.getElementById('passre').value;
	if(passre!='')
		checkPassword(passre);
}
function validateAdd()
{
	var ar = [document.forms['addform']['login'].value,document.forms['addform']['pass'].value,document.forms['addform']['passre'].value,document.forms['addform']['email'].value,document.forms['addform']['name'].value];
	var i;
	
	for(i=0;i<ar.length;++i)
	{
		if(ar[i]==null || ar[i]=="")
		{
			document.getElementById('addError').innerHTML="<p>All fields are necessary!</p>";
			document.getElementById('addError').style.color="red";
			return false;
		}
	}
	var passre = document.getElementById('passre').value;
	var login  = document.getElementById('login').value;
	if(checkPassword(passre) && loginFine==true)
	{
		alert("Succesfully added User "+document.getElementById('name').value);
		return true;
	}
	else
	{
		document.getElementById('addError').innerHTML="<p>Kindly resolve the issues marked in red</p>";
		document.getElementById('addError').style.color="red";
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
				document.getElementById('newpass').value='';
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
function remLoginCheck(login)
{
	if(login=='')
	{
		document.getElementById('loginCheck').innerHTML="";
		return false;
	}
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			if(xmlhttp.responseText=='0')
			{
				document.getElementById('remLoginCheck').innerHTML="<p>login ID not present!</p>";
				document.getElementById('remLoginCheck').style.color="red";
				remloginFine=false;
				return false;
			}
			else if(xmlhttp.responseText=='1')
			{
				document.getElementById('remLoginCheck').innerHTML="";
				remloginFine=true;
				return false;
			}
			else
			{
				document.getElementById('remLoginCheck').innerHTML="<p>Error!</p>";
				document.getElementById('remLoginCheck').style.color="red";
				remloginFine=false;
				return false;
			}
		}
	}
	
	xmlhttp.open("POST", "res/checkLoginID.php", true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	var sendString = "login="+login;
	xmlhttp.send(sendString);
	remloginFine=false;
	return false;
}
function validateRemove()
{
	return remloginFine;
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
				<li id='li0'><a onclick="makeVisible(0)">Add new User account</a></li>
				<li id='li1'><a onclick="makeVisible(1)">Modify account details</a></li>
				<li id='li2'><a onclick="makeVisible(2)">Remove user account</a></li>
				<li id='li3'><a onclick="makeVisible(3)">Reset Quizone database</a></li>
				<li><a href='res/logout.php'>Logout</a></li>
			</ul>
		</div>		
		<div class='col-sm-1'></div>
	</div>
	<div class='row' style="margin:5px;">
		<div class='col-sm-3'></div>
		<div class='col-sm-6 component'>
			<div id='placeHolder'>
				<h3 class="text-center" style="color:#7AA3CC">Admin Control panel</h3>
			</div>
			<div id='addform' style="display:none">
				<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Enter details to make a new user account:</p>
				<form class="form-horizontal" role="form" name='addform' method='post' action='res/addUser.php' onsubmit="return validateAdd()">
					<div class="form-group">
					  <label class="control-label col-sm-4" for="login">LoginID:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='login' id='login' placeholder="Enter loginID" onkeyup="checkLogin(this.value)" maxlength='10' autocomplete='off'>
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='loginCheck' class='col-sm-8'></div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="pass">Password:</label>
					  <div class="col-sm-8">          
						<input type="password" class="form-control" name='pass' id="pass" placeholder="Enter password" onkeyup='checkPasswordWrap()'>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="passre">Re-enter:</label>
					  <div class="col-sm-8">          
						<input type="password" class="form-control" id="passre" placeholder="Re-enter password" onkeyup="checkPassword(this.value)">
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='passwordCheck' class='col-sm-8'></div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="email">Email:</label>
					  <div class="col-sm-8">          
						<input type="email" class="form-control" name='email' id="email" placeholder="Enter Email">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="name">Full Name:</label>
					  <div class="col-sm-8">          
						<input type="text" class="form-control" name='name' id="name" placeholder="Enter Name">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-sm-4" for="type">User type:</label>
					  <div class="col-sm-8">          
						<select type="text" class="form-control" name='type' id="type" placeholder="Select type">
							<option value='0'>Administrator</option>
							<option value='1'>Subject Coordinator</option>
							<!--<option value='2'>Invigilator</option>-->
							<option value='3'>Student</option>
						</select>
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='addError' class='col-sm-8'></div>
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
				</table>
			</div>
			<div id='remform' style="display:none">
				<p class='text-center' style='font-weight:bold;color:#7AA3CC'>Enter login ID of account to be removed:</p>
				<form class="form-horizontal" role="form" name='remform' method='post' onsubmit="return validateRemove()" action='res/remUser.php' onsubmit="">
					<div class="form-group">
					  <label class="control-label col-sm-4" for="remlogin">LoginID:</label>
					  <div class="col-sm-8">
						<input type="text" class="form-control" name='login' id='remlogin' placeholder="Enter loginID" onkeyup="remLoginCheck(this.value)" autocomplete='off'>
					  </div>
					</div>
					<div>
						<div class='col-sm-4'></div>
						<div id='remLoginCheck' class='col-sm-8'></div>
					</div>
					<div class="form-group">        
					  <div class="col-sm-offset-9 col-sm-12">
						<button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					</div>
				</form>
			</div>
			<div id='reset' style="display:none">
			</div>
		</div>
		
		<div class='col-sm-3'></div>
	</div>
	<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10 component'>
			<h3 class='text-center' style='color:#7AA3CC'>Registered Subject coordinators:</h3>
				<?php
					include("res/mysql_connect.php");
					$query="SELECT `loginID`,`email`,`name` FROM `user` WHERE `type`=1";
					$result=mysqli_query($conn,$query);
					if($result->num_rows>0)
					{
						
						echo "<table class='table table-striped'><thead><tr><th>LoginID</th><th>Name</th><th>Email</th></tr></thead><tbody>";
						for($i=1;$i<=$result->num_rows;$i++)
						{
							$row = $result->fetch_assoc();
							$name='data'.$i;
							echo "<tr><td>$row[loginID]</td><td>$row[name]</td><td>$row[email]</td></tr>";
						}
						echo "</tbody></table>";
					}
				?>
		</div>
		<div class='col-sm-1'></div>
	</div>
</div>
<div id='footer'></div>
</body>
</html>