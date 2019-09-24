<?php
session_start();
if (isset($_SESSION['admin'])==true)
{
	$_SESSION['ltime']=time();
    $name=$_SESSION['name'];
    $time = $_SESSION['time_stamp'];
    $host="localhost";
    $dbUsername="root";
    $dbPassword="";
    $dbname="bts";
    $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);
    if(mysqli_connect_error())
    {
  		die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
    }
    else 
    {
    	//amount in hods account and money sent should update account balance of hod and add expense to admin
    	$sql = mysqli_query($conn,"UPDATE notification SET viewstate = '0',approvestate ='1'  WHERE time='$time'");
        header('location: admin.php?message1=1');
    }
    unset($_SESSION['name']);
    unset($_SESSION['time_stamp']);
}