<?php
 	session_start(); 
	if (isset($_SESSION['id']) == true && $_SESSION['role']== "ADMIN") 
	{
		if(time()-$_SESSION['ltime'] < 43200)
		{
			$_SESSION['admin']='1';
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
	 			$totalamount = $result['totalamount'];
	 			$balance = $result['bal'];
	 			$sql=mysqli_query($conn,"SELECT * from notification where viewstate='1'");
      			$count = mysqli_num_rows($sql);
      			$sql1 = mysqli_query($conn,"SELECT * from expenses where id='$id'");
      			$aamount = 0;
      			$alertamount =$_SESSION['alertamount'];
      			while ($res = mysqli_fetch_assoc($sql1)) {
      				$aamount = $aamount+$res['amount'];
      			}

      			if ($aamount >= $alertamount ) 
      			{
      				if($_GET['alert']!= true)
      				{
      					header('location: admin.php?alert=1');
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
		<li><a href="admin.php">HOME</a></li>
		<li><a>SERVICES</a>
			<ul>
				<li><a href="change_max_expense">Add Income</a></li>
				<li><a href="addexpense">Add Expense</a></li>
				<li><a href="alertamount.php">Set Alert Amount</a></li>
				<li><a href="viewactivity.php">View Activity</a></li>
			</ul>
		</li>
		<li>
				<?php 
				if($count>0)
				{
					echo "<a href='aord.php'>Notification ($count)</a>
								<ul>";
					while ($result = mysqli_fetch_assoc($sql)) {
						echo "<li><a href='aord.php' >Request from ".$result['department']."</a></li>";
					}
				}
				else
				{
					echo "<a href='nonot.php'>Notification (0)</a>
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
				<li><a href="account_info.php">ACCOUNT INFO</a></li>
				<li><a href="logout.php">LOG OUT</a></li>
			</ul>
		</li>
	</ul></br></br></br></br></br></br></br></br><?php
			if (isset($_GET['message'])==true) {
				echo "<div class='hello'><center><p>your transaction is sucessfull</p></center</div>";
			}
			elseif(isset($_GET['message1'])==true)
			{
				echo "<div class='hello'><center><p>Request has been declined</p></center</div>";
			}
			elseif(isset($_GET['notification'])==true)
			{
				echo "<div class='hello'><center><p>No Notifications</p></center</div>";
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