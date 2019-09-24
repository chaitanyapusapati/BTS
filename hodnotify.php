<?php 
	session_start();
	if (isset($_SESSION['time_stamp'])==true) 
	{
		if(time()-$_SESSION['ltime'] < 43200)
		{
			$_SESSION['ltime'] = time();
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
	 			$id = $_SESSION['id'];
	 			$sql = mysqli_query($conn,"SELECT * FROM notification where viewstate = '0' and hodviewstate ='1' and id='$id'");
	 			$result = mysqli_fetch_assoc($sql);
	 			$time = $result['time'];
	 			$_SESSION['amount']=$result['amount'];
	 			if($result['approvestate'])
	 			{
	 				header('location: hod.php?decline=1');
	 			}
	 			else
	 			{
					header('location: hod.php?accept=1');
	 			}
	 			$sql = mysqli_query($conn,"UPDATE notification SET hodviewstate = '0'  WHERE time='$time'");
			}
		}
	}
	else
	{
		header('location: hod.php');
	}
 ?>