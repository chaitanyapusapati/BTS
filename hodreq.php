<?php
if(isset($_POST['request']))
{
  session_start();
  if (isset($_SESSION['hod'])==true)
  {
    $_SESSION['ltime']=time();
    $amount = filter_input(INPUT_POST, 'amount_budget');
    if(is_numeric($amount)&&$amount>0&&$amount<100000000)
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
          $id=$_SESSION['id'];
          $sql = mysqli_query($conn,"SELECT * FROM userdetails where id='$id'");
          $result = mysqli_fetch_assoc($sql);
          $name= $result['name'];
          $dept = $result['department'];
          $date = date('ymd');
          $time = time();
          $sql = mysqli_query($conn,"INSERT Into notification (name,id,department,amount,viewstate,approvestate,hodviewstate,date,time) values('$name','$id','$dept','$amount','1','1','1',$date,'$time')");
          header('location: hodreq.php?error1=1');
          echo "$date";
        }
    }
    else
    {
        header('location: hodreq.php?error=1');
    }
  }
  else
  {
    header('location: loginauthenticate.php');
  }
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

    <title>Request Budget</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/album/">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="album.css" rel="stylesheet">
  </head>

  <body background="copy.jpg">

    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="hod.php" class="navbar-brand d-flex align-items-center">
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
          <h1 class="jumbotron-heading">Request Budget</h1></br></br>
          <form method="post"><input type="text" name="amount_budget" placeholder="Enter Amount" required="required"></br>
          
          <center><input type="submit" name="request" value="Request" class="btn btn-primary my-2"></center>
          <?php
            if(isset($_GET['error'])==true)
            {
              echo "<p><b>please enter a valid amount</p></b>";
            }
            if(isset($_GET['error1'])==true)
            {
              echo "<p><b>Request Sent.Wait for approval</p></b>";
            }
          ?>
          </form></p>
        </div>
      </section>
      </div>

    </main>
  </body>
</html>