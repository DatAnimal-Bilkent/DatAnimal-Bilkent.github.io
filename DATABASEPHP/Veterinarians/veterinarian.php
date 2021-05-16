<?php
session_start();
$userID = $_SESSION['username'];
$password = $_SESSION['password'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$query = "Select * from Users where user_id='$userID'";
$result = mysqli_query($con, $query);
session_start();
$_SESSION['userid'] = $userID;
if ($result->num_rows == 1) {
	$resultRow = $result->fetch_array();
	$username = $resultRow["name"];
}else{
	echo "Error either no such user with id: $userID exists, or multiple users with same id!";
}

$query = "SELECT * FROM Invites_Edu E, Veterinarians V, Educational_Program P, Users C, Events F WHERE E.vet_user_id = V.user_id && V.user_id = '$userID' && P.event_id = E.event_id && C.user_id = E.coor_user_id&& F.event_id = P.event_id && E.invites_status ='pending';";
$result = mysqli_query($con, $query);

mysqli_close($con);
?>


<!DOCTYPE HTML>  
<html>
<form name ="formLog" onsubmit="return validateForm()" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
</form>

<h1>Veterinarian page</h1>

<body>
<style media="all">

h3, h3+p {display: inline;}

</style>
        
<?php
	echo "<br><br/>";
	echo "Welcome Veterinarian: $username with ID: $userID";
	echo "<h2>$username you have these invitations:</h2>";
	if ($result->num_rows  > 0){
		while ($row = $result->fetch_assoc()){
			echo "<br><tr><h3> Event ID: </h3><td>". $row["event_id"]. "</td><h3> Subject: </h3><td>".$row["subject"].  "</td><h3> Coordinator Name: </h3><td>". $row["name"]. "</td><h3> Date: </h3><td>". $row["date"]. "</td><h3> Location: </h3><td>". $row["location"]."</td><h3> Invitation Status: </h3><td>". $row["invites_status"]. "";
			echo "<td> <button onClick=accept('$row[event_id]');> Accept Invitation </button> </td> ";
			echo "<td> <button onClick=reject('$row[event_id]');> Reject Invitation</button> </td> ";
		}
	}else{
		echo "There are no waiting invitation";
	}
	echo "<br><br/>";

	echo "<h2>These treatments are requested:</h2>";

	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Request_Treatment R, Veterinarians V, Users C WHERE V.user_id = '$userID' && R.vet_user_id = V.user_id && R.acc_status ='pending' && R.keeper_user_id = C.user_id;";
	$result = mysqli_query($con, $query);
	echo "<br><br/>";
	$counter = 0;
	if ($result->num_rows  > 0){
		while ($row = $result->fetch_assoc()){
			$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
			$aid = $row["animal_id"];
			$newQuery = "SELECT * FROM Animals WHERE animal_id = $aid";
			$newResult = mysqli_query($con, $newQuery);
			$nrow = $newResult->fetch_assoc();
			echo "<br><tr><h3> Animal Name: </h3><td>". $nrow["name"]. "</td><h3> Keeper Name: </h3><td>".$row["name"].  "</td><h3> Cage ID: </h3><td>". $row["cage_id"]. "</td><h3> Date: </h3><td>". $row["date_time"]. "";
			echo "<td> <button onClick=acceptT('$counter');> Accept Treatment</button> </td> ";
			echo "<td> <button onClick=rejectT('$counter');> Reject Treatment</button> </td> ";
			$counter = $counter + 1;
		}
	}else{
		echo "There are no waiting invitation";
	}
	echo "<br><br/>";
	mysqli_close($con);


	echo "<h2>These treatments are accepted and waiting for complete:</h2>";

	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Request_Treatment R, Veterinarians V WHERE V.user_id = '$userID' && R.vet_user_id = V.user_id && R.acc_status ='accepted'&& R.treatment_status ='Incomplete';";
	$result = mysqli_query($con, $query);
	echo "<br><br/>";
	$counter = 0;
	if ($result->num_rows  > 0){
		while ($row = $result->fetch_assoc()){
			$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
			$aid = $row["animal_id"];
			$newQuery = "SELECT * FROM Animals WHERE animal_id = $aid";
			$newResult = mysqli_query($con, $newQuery);
			$nrow = $newResult->fetch_assoc();
			echo "<br><tr><h3> Animal Name: </h3><td>". $nrow["name"]. "</td><h3> Cage ID: </h3><td>". $row["cage_id"]. "</td><h3> Date: </h3><td>". $row["date_time"]. "</td><h3> Treatment Status: </h3><td>". $row["date_time"]. "";
			echo "<td> <button onClick=acceptC('$counter');> Complete Treatment</button> </td> ";
			$counter = $counter + 1;
		}
	}else{
		echo "There are no waiting treatment to complete";
	}
	echo "<br><br/>";
	
	mysqli_close($con);
?>

<script>
        function accept(a) {
            var page='InvitationAccept.php?varJS='+a;
            document.location.href= page;

        }
		function reject(a) {
            var page='InvitationReject.php?varJS='+a;
            document.location.href= page;

        }
		function acceptT(a) {
            var page='TreatmentAccept.php?varJS='+a;
            document.location.href= page;

        }
		function rejectT(a) {
            var page='TreatmentReject.php?varJS='+a;
            document.location.href= page;

        }
		function acceptC(a) {
            var page='CompleteTreatment.php?varJS='+a;
            document.location.href= page;

        }
</script>
</body>
</html> 