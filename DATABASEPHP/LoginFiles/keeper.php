<?php
session_start();
echo "Welcome: ";
$username = $_SESSION['username'];
session_start();
$noOfApply = 0;
$password = $_SESSION['password'];
echo $username;
echo " ID: ";
echo $password;
session_start();
$_SESSION['password'] = $password;
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
$query = "SELECT * FROM company A, apply B WHERE B.cid = A.cid AND B.sid = '$password';";
$result = mysqli_query($con, $query);
echo "<br><br/>";
echo "<br><br/>";
echo "Company id - Company Name - Quota";
echo "<br><br/>";
if($result-> num_rows > 0){
	while( $row = $result->fetch_assoc()){
		$noOfApply = $noOfApply+1;
		echo $row["cid"];
		echo " - ";
		echo $row["cname"];
		echo " - ";
		echo $row["quota"];
		echo " ";
		echo "<a href = 'cancel.php?rn=$row[cid]'>Delete</a>";
		echo "<br><br/>";
	}
}
echo "<br><br/>";
echo "<br><br/>";

if($noOfApply > 2){
echo " You cant apply a new because u acceed 3 limit";
}else{
echo "<a href = 'newapply.php'>apply for new internship</a>";
}
echo "<br><br/>";
echo "<a href = 'index.php'>LOGOUT</a>";
mysqli_close($con);
?>
