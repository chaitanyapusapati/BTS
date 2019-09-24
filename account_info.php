<?php
session_start();
if (isset($_SESSION['id'])==true)
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
   		$_SESSION['ltime']=time();
    	$id=$_SESSION['id'];
    	$sql = mysqli_query($conn,"SELECT * FROM userdetails where id='$id'");
    	$result = mysqli_fetch_assoc($sql);
    	$name= $result['name'];
    	$role = $result['role'];
    	$email = $result['email'];
    	$mobile = $result['mobile'];
    	$dept = $result['department'];
	}
	if(isset($_POST['back']))
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
  width: 80px;
  height: 30px;
  border-radius: 30px;
}

.login-submit:hover {
  width: 100px;
  height: 35px;
  border: 40px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #191970;
  cursor: pointer;
}
</style>

</style>
<body background="im2.jpg">
<font size="26" face="italic" color="Black"><center><u><head>Your Details</head></u></center></font></br>
<table align="center" cellpadding="10" cellspacing="10" border="10" >
  <tr>
    <th>Name</th>
    <td><?php echo "$name";
    ?></td> 
  </tr>
  <tr>
    <th>Register Id</th>
    <td><?php echo "$id"; ?></td>
  </tr>
  <tr>
    <th>E-Mail </th>
    <td><?php echo "$email"; ?></td>
  </tr>
  <tr>
    <th>Mobile No.</th>
    <td><?php echo "$mobile"; ?></td>
  </tr>
  <tr>
    <th>Role</th>
    <td><?php echo "$role"; ?></td>
  </tr>
  <tr>
    <th>Department</th>
    <td><?php echo "$dept"; ?></td>
  </tr>
</table></br>
<center><form method="post"><input type="submit" name="back" class="login login-submit" value="Go Back"></form></center>
</body>
</html>
