<?php 
session_start();
if($_SESSION['id']==true)
{
	$host="localhost";
	$username="root";
	$password="";
	$dbname="bts";
	$conn = new mysqli($host,$username,$password,$dbname);
	if(mysqli_connect_error())
	{
		die("Error has occured: (".mysqli_connect_error().')'.mysqli_connect_error());
	}
	else
	{
		$id = $_SESSION['id'];
		$sql = mysqli_query($conn,"SELECT * from userdetails where id = '$id'");
		$result = mysqli_fetch_assoc($sql);
		$balance = $result['bal'];
		$total = $result['totalamount'];
		$sql = mysqli_query($conn,"SELECT * from expenses where id = '$id'");
		$count = mysqli_num_rows($sql);
		$s_no = '1';
		$total_amount = '0';
	}
	if(isset($_POST['goback']))
	{
		header('location: loginauthenticate.php');
	}
}
?>
<!DOCTYPE html>
<html>
<style type="text/css">
th{
  font-family: sans-serif;
  background-color: black;
  opacity: .9;
  line-height: 40px;
  text-align: center;
  font-size: 30px; 
  color: red;
}
td{ 
  font-family: serif;
  background-color: black;
  opacity: .9;
  line-height: 40px;
  text-align: center;
  font-size: 30px; 
  color: white;
}
.login-submit {
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #000080;
  width: 100px;
  height: 40px;
  border-radius: 30px;
}

.login-submit:hover {
	width: 120px;
	height: 45px;
  border: 40px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #191970;
  cursor: pointer;
}
</style>

</style>
<body background="im2.jpg">
<font size="26" face="italic" color="Black"><center><u><head>Your Expenses</head></u></center></font></br>
<table align="center" cellpadding="10" cellspacing="10" border="10" >
<tr><th colspan="5">Your Activity</th></tr>
<tr>
	<th>S No.</th>
	<th>Date</th>
	<th>Transaction_Id</th>
	<th>Reason</th>
	<th>Amount</th>
</tr>
<?php 
if($count)
{
	while($result = mysqli_fetch_assoc($sql))
	{
		$date = $result['date'];
		$amount = $result['amount'];
		$reason = $result['reason'];
		$trans_id = $result['trans_id'];
		echo "<tr><td>$s_no</td><td>$date</td><td>$trans_id</td><td>$reason</td><td>$amount Rs/-</td></tr>";
		$total_amount = $total_amount + $amount;
		$s_no += 1;
	}
	echo "<tr>
	<th colspan='4'>Total Income</th>
	<td>$total Rs/-</td>
</tr>
<tr>
	<th colspan='4'>Total spent</th>
	<td>$total_amount Rs/-</td>
</tr>
<tr>
	<th colspan='4'>Remaining Balance</th>
	<td>$balance Rs/-</td>
</tr>";

}
else
{
	echo "<tr><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>";
}
?>
</table></br></br></br>
<center>
<form method="post">
<input type="submit" name="goback" class="login login-submit" value="Go Back">
</form></center>
</body>
</html>