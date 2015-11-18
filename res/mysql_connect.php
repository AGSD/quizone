<?php
$conn=@mysqli_connect('localhost','root','') or die('Error: Could not connect to the MySQL server!');
@mysqli_select_db($conn,'quizone') or die('Error: Could not connect to the Quizone database!');
?>