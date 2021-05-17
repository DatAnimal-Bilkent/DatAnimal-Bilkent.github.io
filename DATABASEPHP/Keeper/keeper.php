<?php
session_start();
$userID = $_SESSION['username'];
$password = $_SESSION['password'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$query = "Select * from Users where user_id='$userID'";
$result = mysqli_query($con, $query);

if ($result->num_rows == 1) {
	$resultRow = $result->fetch_array();
	$username = $resultRow["name"];
}else{
	echo "Error either no such user with id: $userID exists, or multiple users with same id!";
}

$query = "Select * from Assigns_Cage where keeper_user_id='$userID'";
$result = mysqli_query($con, $query);

mysqli_close($con);
?>


<!DOCTYPE HTML>  
<html>
<form name ="formLog" onsubmit="return validateForm()" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
</form>

<h1>Keeper page</h1>

<body>
<?php
	echo "<br><br/>";
	echo "Welcome Keeper: $username with ID: $userID";
	echo "<h2>This week $username is responsible for:</h2>";
	if($result->num_rows > 0){
		while($resultRow = $result->fetch_array()){
			$assignedCageID = $resultRow["cage_id"];
			echo "<t></t>Cage $assignedCageID";
			echo "<br><br/>";
		}
	}else{
		echo "No cage assigned";
	}
	echo "<br><br/>";
	

?>
<br><br/>

<form action="regulateFoods.php">
<button type="submit">Regulate Foods</button>
</form>
<br><br/>

<form action="requestTreatment.php">
<button type="submit">Request Treatment</button>
</form>
<br><br/>

<form action="scheduleTraining.php">
<button type="submit">Schedule Training</button>
</form>

</body>
</html> 