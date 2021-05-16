<?php
	session_start();	
	$userID = $_SESSION['userid'];
	$counterB = $_GET['varJS'];
	
	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Request_Treatment R, Veterinarians V, Users C WHERE V.user_id = '$userID' && R.vet_user_id = V.user_id && R.acc_status ='pending' && R.keeper_user_id = C.user_id;";
	$result = mysqli_query($con, $query);
	echo "<br><br/>";
	$counter = 0;
	if ($result->num_rows  > 0){
		while ($row = $result->fetch_assoc()){
			$animal_id = $row["animal_id"];
			$keeper_user_id = $row["keeper_user_id"];
			$date_time = $row["date_time"];
			if($counter == $counterB){
				break;
			}
			$counter = $counter + 1;
		}

	}else{
		echo "There is no waiting treatment";
	}
	echo "<br><br/>";
	mysqli_close($con);
	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "UPDATE Request_Treatment SET acc_status = 'accepted' WHERE animal_id = '$animal_id' && keeper_user_id = '$keeper_user_id' && vet_user_id = '$userID' && date_time = '$date_time'";
	$result = mysqli_query($con, $query);
	mysqli_close($con);

?>
<!DOCTYPE HTML>  
<html>
<form name ="formLog" onsubmit="return validateForm()" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
</form>

<form name ="formLog" action = "veterinarian.php" method = "POST">
        <input type="submit" value="Go Back "> 
</form>

<br><br/>
<h2>Treatment Accepted !</h2>
