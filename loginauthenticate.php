<?php
session_start();
if(isset($_SESSION['id'])==true)
{
  if(time()-$_SESSION['ltime']<43200)
  {
      $_SESSION['ltime']=time();
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
        $id=$_SESSION['id'];
        $sql = mysqli_query($conn,"SELECT * From userdetails Where id='$id'");
        $res = mysqli_fetch_assoc($sql);
        if($res['role']=="HOD")
        {
          header('location: hod.php');
        }
        elseif($res['role']=="ADMIN")
        {
          header('location: admin.php');
        }
      }
  }
  else
  {
    header('location: logout.php');
  }
}
else
{
  if(isset($_POST['login']))
  {
    $id = filter_input(INPUT_POST, 'rid');
    $pass = filter_input(INPUT_POST, 'pass');
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
     	$sql = mysqli_query($conn,"SELECT * From userdetails Where id='$id'");
     	$res = mysqli_fetch_assoc($sql);
      if($res['role']=="HOD"&&$res['password']==$pass)
     	{
          $_SESSION['id']=$id;
          $_SESSION['ltime']=time();
          $_SESSION['alertamount'] = $res['alertamount'];
          $_SESSION['role']=$res['role'];
          header('location: hod.php');
      }
     	elseif($res['role']=="ADMIN"&& $res['password']==$pass)
     	{
          $_SESSION['alertamount'] = $res['alertamount'];
          $_SESSION['ltime']=time();
          $_SESSION['id']=$id;
          $_SESSION['role']=$res['role'];
          header('location: admin.php');
      }
      else
      { 
        header('location: loginauthenticate.php?error=0');
    	}
    }
  }
}
?>
<!DOCTYPE html>
<html>
 <meta charset="UTF-8">

  <title>Log-in</title>

    <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
<head>

  <center><font color="white" size="46">Welcome To Budget Tracker</center></font>

</head></br></br></br></br>

<body>

  <div class="login-card">
   <h1><b><font color="black">Log-in</h1></b><br></font>
  <form method="post">
    <?php
      if(isset($_GET['error'])==true)
      {
        echo "<p><center>Invalid Credentials</p></center>";
      }
    ?>
    <input type="text" name="rid" placeholder="Register Number ">
    <input type="password" name="pass" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>
  <div class="login-help">
   <center>New User? Then <a style="color: black" href="signup.html">Sign up</a></center></br>
   <a style="color: black" href="fp1.php">Forgot Password</a>
  </font>
  </div>
</div>
</body>

</html>
}