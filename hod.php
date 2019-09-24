<?php
 	session_start();
	if (isset($_SESSION['id'])==true && $_SESSION['role']=="HOD") 
	{
		if(time()-$_SESSION['ltime'] < 43200)
		{
			$_SESSION['hod']='1';
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
	 			$sql = mysqli_query($conn,"SELECT * FROM userdetails where id='$id'");
	 			$result = mysqli_fetch_assoc($sql);
	 			$name= $result['name'];
	 			$balance = $result['bal'];
	 			$sql = mysqli_query($conn,"SELECT * FROM notification where viewstate = '0' and hodviewstate ='1' and id='$id'");
	 			$count = mysqli_num_rows($sql);
	 			$sql1 = mysqli_query($conn,"SELECT * FROM notification where viewstate = '0' and hodviewstate ='1' and id='$id'");
	 			$res = mysqli_fetch_assoc($sql1);
	 			$time=$res['time'];
	 			$sql2 = mysqli_query($conn,"SELECT * from expenses where id='$id'");
      			$aamount = 0;
      			$alertamount =$_SESSION['alertamount'];
      			while ($res1 = mysqli_fetch_assoc($sql2)) {
      				$aamount = $aamount+$res1['amount'];
      			}
      			if ($aamount >= $alertamount ) 
      			{
      				if($_GET['alert']!= true)
      				{
      					header('location: hod.php?alert=1');
      				}	
      			}
			}
		}
		else
		{
			header('location: loginauthenticate.php');
		}
	}
	else
	{
		header('location: loginauthenticate.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="landpage.css">
	<title>
		Welcome <?php echo $name; ?>
	</title>
</head>
<body>
	<ul>
		<li><a href="hod.php">HOME</a></li>
		<li><a>SERVICES</a>
			<ul>
				<li><a href="hodreq.php">Request Budget</a></li>
				<li><a href="addexpense.php">Add Expense</a></li>
				<li><a href="alertamount.php">Set Alert Amount</a></li>
				<li><a href="viewactivity.php">View Activity</a></li>
			</ul>
		</li>
		<li>
			<?php 
			if($count>0)
			{
				$_SESSION['time_stamp']=$time;
				echo "<a href='hodnotify.php'>Notification ($count)</a>
							<ul>";
				while ($result = mysqli_fetch_assoc($sql)) {
					echo "<li><a href='hodnotify.php'>From ADMIN</a></li>";
				}
			}
			else
			{
				echo "<a href='hodnonot.php'>Notification (0)</a>
							<ul>";
			}
		?></ul>
		</li>
		<li><a>ABOUT</a>
			<ul>
				<li><a href="team.html">OUR TEAM</a></li>
				<li><a>OUR SERVICES</a></li>
				<li><a>HOW IT WORKS</a></li>
			</ul></li>
		<li><a>SETTINGS</a>
			<ul>
				<li><a href="account_info">ACCOUNT INFO</a></li>
				<li><a href="logout.php">LOG OUT</a></li>
			</ul>
		</li>
	</ul></br></br></br></br></br></br></br></br>
	<?php
		if(isset($_GET['notification'])==true)
		{
			echo "<div class='hello'><center><p>No Notifications</p></center</div>";
		}
		elseif(isset($_GET['decline'])==true)
		{
			echo "<div class='hello'><center><p>Your request of ".$_SESSION['amount']." Rs/- from admin has been declined </p></center</div>";
		}
		elseif(isset($_GET['accept'])==true)
		{
			echo "<div class='hello'><center><p>Your request of ".$_SESSION['amount']." Rs/- from admin has been accepted and It has been credited into your account</p></center</div>";
		}
		elseif(isset($_GET['alert'])==true)
		{
			echo "<div class='hello'><center><p>ALERT:You have crossed ".$_SESSION['alertamount']." Rs/- .<p>Please reset your ''Alert Amount''</p></div><div class='bal'><center>Your account balance is ''$balance'' Rs/-</center></div>";
		}
		else
		{
			echo "<center><div class='hello'><p>HELLO $name</p></div><p>Welcome to Budger Tracker.</p>
				<p>We are very happy to see you.Now you can use our services.</p><p>Your account balance is <div class='bal'>''$balance Rs/-''</div></center>";
		}
	?>
</body>
</html>