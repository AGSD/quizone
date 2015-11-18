<?php
session_start();
if(!isset($_SESSION['status']))
{
	echo 'nhp';
	die();
}

function secondsToTime($seconds) {
    $dtF = new DateTime("@0");
    $dtT = new DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

if($_SESSION['status']==0)
{
	$date = new DateTime();
	$initial= $date->getTimestamp();
	$final=$_SESSION['startTime'];
	$secsLeft=$final-$initial;
	
	if($secsLeft<=0)
	{
		echo "-1";
		die();
	}
	echo secondsToTime($secsLeft)." to quiz";
}
else if($_SESSION['status']==1)
{
	$date = new DateTime();
	$initial= $date->getTimestamp();
	$final=$_SESSION['finalTime'];
	$secsLeftSave=$final-$initial;
	$secsLeft=$secsLeftSave;
	$seconds=$secsLeft%60;
	$secsLeft=floor($secsLeft/60);
	$mins=$secsLeft%60;
	$secsLeft=floor($secsLeft/60);
	$hours=$secsLeft;
	
	if(floor($seconds/10)==0)
		$seconds='0'.$seconds;
	
	if(floor($mins/10)==0)
		$mins='0'.$mins;
	
	if(floor($hours/10)==0)
		$hours='0'.$hours;
	
	if($secsLeftSave<=0)
	{
		echo "-1";
		die();
	}
	echo $hours.":".$mins.":".$seconds." left";
}
else
	echo '2';

?>