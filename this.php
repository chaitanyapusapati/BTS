<?php
$name = $_POST['name'];
$rid = $_POST['rid'];
$email = $_POST['email'];
$mobile = $_POST['mobile_no'];
$password = $_POST['pass'];
$role = $_POST['type'];
$dept = $_POST['department'];

if (!empty($name)||!empty($rid)||!empty($email)||!empty($mobile)||!empty($password)||!empty($role)||!empty($dept))
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
 		$SELECT = "SELECT email From userdetails Where email=? Limit 1";
 		$INSERT = "INSERT Into userdetails (name,id,email,mobile,password,role,department) values (?,?,?,?,?,?,?)";
 		$stmt=$conn->prepare($SELECT);
 		$stmt->bind_param("s",$email);
 		$stmt->execute();
 		$stmt->bind_result($email);
 		$stmt->store_result();
 		$rnum = $stmt->num_rows;
 		if($rnum==0)
 		{
 			$stmt->close();
 			$stmt=$conn->prepare($INSERT);
 			$stmt->bind_param("ssssii",'$name','$rid','$email','$mobile','$password','$role','$dept');
 			$stmt->execute();
 			echo "Thank you for Registering <3";
 		}else
 		{
 			echo "Email Already exists";
 		}
 		$stmt->close();
 		$conn->close();
 	}
}
else
{
	echo "All fields are required";
	die();
}
?>