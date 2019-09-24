<?php
	
	//viewstate to 0;
session_start();
if (isset($_SESSION['name'])==true)
{
	$s_id = $_SESSION['id'];
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
    	//check and update admin balance
 		$sql = mysqli_query($conn,"SELECT * from notification WHERE time='$time'");
	    $result= mysqli_fetch_assoc($sql);
	    $amount=$result['amount'];
	    $dept = $result['department'];
	    $id = $result['id'];
    	$sql = mysqli_query($conn,"SELECT * from userdetails where id='$s_id'");
	    $result = mysqli_fetch_assoc($sql);
	    $admin_balance = $result['bal'];
    	if($amount<=$admin_balance)
    	{
    		//change approved state
	    	
	    	$sql = mysqli_query($conn,"UPDATE notification SET viewstate = '0',approvestate ='0'  WHERE time='$time'");
	    	
	    	$date = date('ymd');
	    	$sql = mysqli_query($conn,"SELECT * from userdetails where id='$id'");
	    	$result = mysqli_fetch_assoc($sql);
	    	$total = $result['totalamount'];
	    	$balance = $result['bal'];
	    	$balance = $balance + $amount;
	    	$total = $total+$amount;
	    	
	    	//update total and balance of hod
	    	
	    	$sql = mysqli_query($conn,"UPDATE userdetails SET totalamount='$total',bal='$balance' WHERE id='$id'");
	    	
	    	$reason = "For $dept Department";
	    	$current_time = time();
	    	$trans_id = rand();
	    	
	    	//add to admin expenses
	    	
	    	$sql = mysqli_query($conn,"INSERT INTO expenses (id,amount,reason,date,time,trans_id) values ('$s_id','$amount','$reason','$date','$current_time','$trans_id')");
	    	
	    	//update admin balance
	    	
	    	$admin_balance = $admin_balance-$amount;
	    	$sql = mysqli_query($conn,"UPDATE userdetails SET bal='$admin_balance' WHERE id='$s_id'");
	    	header('location: admin.php?message=1');
	    	unset($_SESSION['name']);
	    	unset($_SESSION['time_stamp']);
    	}
    	else
    	{
    		header('location: aord.php?insbal=1');
    	}
    }
}
else
{
	header('location: loginauthenticate.php');
}
	



?>
