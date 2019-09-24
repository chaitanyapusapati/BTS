<?php
$email = filter_input(INPUT_POST, 'email');
$mobile = filter_input(INPUT_POST, 'mobile_no');

if(!empty($email)||!empty($mobile))
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
 		$sql = mysqli_query($conn,"SELECT * from userdetails Where email='$email' and mobile='$mobile' ");
 		if (mysqli_num_rows($sql)>0) {
 			session_start();
 			$_SESSION['email']=$email;
 			header('location: fp2.php');
 		}
 		else
 		{
 			header('location: fp1.php?error=1');
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
    <input type="text" name="email" placeholder="Email-id" required="required">
    <input type="text" name="mobile_no" placeholder="Mobile No." required="required">
  </br></br></br>
    <input type="submit" name="next" class="login login-submit" value="NEXT">
    <?php
    	if(isset($_GET['error'])==true)
    	{
    		echo "<p><center>Please enter register E-mail and Mobile number</p></center>";
    	}
    ?>
  </form>
</div>
</body>

</html>