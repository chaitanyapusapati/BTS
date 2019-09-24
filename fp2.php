<?php
$pass = filter_input(INPUT_POST, 'pass');
$cpass = filter_input(INPUT_POST, 'cpass');
if(!empty($pass)||!empty($cpass))
	{
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
		 	if($pass!=$cpass)
		 	{
		 		header('location: fp2.php?error=1');
		 	}
		 	elseif(strlen($pass)<8)
		 	{
		 		header('location: fp2.php?error1=0');
		 	}
		 	else
		 	{
		 		session_start();
		 		$email = $_SESSION['email'];
				$sql = mysqli_query($conn,"UPDATE userdetails set password='$pass' where email='$email' ");
		 		session_destroy();
		 		header('location: passchange.html');
		 	}
		}
	}
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Change your Password</title>

    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />

</head>

<body>

  <div class="login-card">
    <h1><b><font color="black">Change Password</h1><br></b></font>
  <form method="post">
    <input type="password" name="pass" placeholder="Password" required="required">
    <input type="password" name="cpass" placeholder="Confirm Password" required="required">
  </br></br></br>
    <input type="submit" name="next" class="login login-submit" value="SUBMIT">
    <?php
    if (isset($_GET['error'])==true) {
    	echo "<p><center>password Missmatch</p></center>";
    }
    if (isset($_GET['error1'])==true) {
    	echo "<p><center>password length must be greater than 8...</p></center>";
    }
    

    ?>
  </form>
</div>
</body>
</html>