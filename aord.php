<?php
  session_start();
  if (isset($_SESSION['admin'])==true)
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
      $sql=mysqli_query($conn,"SELECT * from notification where viewstate='1'");
      $result = mysqli_fetch_assoc($sql);
      $count  = mysqli_num_rows($sql);
      if($count==0)
      {
        header('location: admin.php?notification=1');
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

    <title>Budget Request</title>

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
          <h1 class="jumbotron-heading">Budget Request</h1></br>
          <p class="lead text-muted">
          <?php 
            echo "HOD of ''".$result['department']."'' department ''".$result['name']."'' has requested you ".$result['amount']." Rs/- on ".$result['date']."</center>";
            $_SESSION['name'] = $result['name'];
            $_SESSION['time_stamp'] = $result['time'];
          ?></br>
          <p>
            <a href="accept.php" class="btn btn-primary my-2">Accept</a>
            <a href="decline.php" class="btn btn-secondary my-2">Decline</a>
          </p>
          <?php 
              if(isset($_GET['insbal'])==true)
              {
                echo "<p>In-sufficient Balance please check your Balance</p>";
              }
          ?>
        </div>
      </section>
      </div>

    </main>
  </body>
</html>
