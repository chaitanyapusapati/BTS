<?php
session_start();
if (isset($_SESSION['id'])==true )
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
        $sql = mysqli_query($conn,"SELECT * from userdetails where id='$id'");
        $result = mysqli_fetch_assoc($sql);
        if(isset($_POST['submit']))
        {
          
          $amount = filter_input(INPUT_POST, 'change_amount');
          if(is_numeric($amount)&&$amount>0&&$amount<1000000000)
          {
            $sql = mysqli_query($conn,"UPDATE userdetails set alertamount = '$amount' where id='$id'");
            header('location: alertamount.php?error1=1');
            $_SESSION['alertamount'] = $amount;
          }
          else
          {
            header('location: alertamount.php?error=1');
          }
        }
      }
}
else
{
  header('location: loginauthenticate.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Alert amount</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/album/">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="album.css" rel="stylesheet">
  </head>

  <body background="copy.jpg">

    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="loginauthenticate.php" class="navbar-brand d-flex align-items-center">
            <strong>HOME</strong>
          </a>
        </div>
        <div class="pull-right">
          <a href="logout.php" class="btn btn-danger my-2">LOGOUT</a>
        </div>
      </div>
    </header>

    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Add Alert Amount</h1>
          </br>
          <p class="lead text-muted">
            You will get a alert notification when you cross this amount.
          </p>
          <form method="post" id='myform'>
            <input type="text" name="change_amount" placeholder="Enter Amount" required="required"></br></br>
          <center><input type="submit" name="submit" value="submit" class="btn btn-primary my-2"></center>
          
          <?php
            if(isset($_GET['error'])==true)
            {
              echo "<p><b>please enter a valid amount</p></b>";
            }
            elseif(isset($_GET['error1'])==true)
            {
              echo "<p><b>Your alert amount is set.</p></b>";
            }
          ?>
          </form></p>
        </div>
      </section>
      </div>

    </main>
  </body>
</html>