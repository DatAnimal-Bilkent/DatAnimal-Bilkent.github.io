<?php
session_start();
$username = $_POST['username'];
$pass     = $_POST['password'];

if ($username == 'admin' && $pass == 'admin')
{
		header("Location: registerEmployee.php");
		exit();
}
else
{
	echo "<a href='registerAdminLog.php'>PRESS HERE TO TRY AGAIN!</a>";
	echo "<br><br/>";
	echo "Username and password didnt match.!";
	mysqli_close($con);
}
#echo "<br><br/>";
#echo "<a href = 'index.php'>LOGOUT</a>";
?>
