<?php
	$event_id = $_GET['varJS'];
	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "UPDATE Invites_Edu SET invites_status = 'rejected' WHERE event_id = '$event_id'";
	$result = mysqli_query($con, $query);
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
<h2>Invitation REJECTED !</h2>
