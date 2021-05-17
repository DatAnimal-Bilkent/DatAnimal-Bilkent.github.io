<?php
session_start();
$userID = $_SESSION['username'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

if( $_POST['animals'] != ''){
    $animalName = $_POST['animals'];
    $date = $_POST['trainingDate'];
    $type = $_POST['trainingType'];

    $query = "select animal_id from Animals where name='$animalName';";
    $result = mysqli_query($con, $query);
    $resultRow = $result->fetch_array();
    $animalID = $resultRow["animal_id"];

    $insertQuery = "insert into Schedules_Training values('$animalID', '$userID', '$date', '$type')";
    if( mysqli_query($con, $insertQuery)){
        echo "<script type='text/javascript'>alert('Insertion Succesful!');</script>";
    }else{
        echo "<script type='text/javascript'>alert('Insertion Unsuccesful!');</script>";
    }

}
$query = "Select date_time, name, type,species from Schedules_Training natural join Animals where user_id='$userID';";
$result = mysqli_query($con, $query);


mysqli_close($con);
?>

<script type="text/javascript">
function validateForm() {
        if (document.getElementById("animals").value == ""){
        	alert("Options can not be empty!");
        	return false;
    	} 
        if (document.forms["inputForm"]["trainingDate"].value == ""){
        	alert("Options can not be empty!");
        	return false;
    	}   
        if (document.forms["inputForm"]["trainingType"].value == ""){
        	alert("Options can not be empty!");
        	return false;
    	}       
}
</script>

<!DOCTYPE HTML>  
<html>
<form name ="formLog" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
</form>
<b1><br/>
<form name ="formLog" action = "keeper.php" method = "POST">
        <input type="submit" value="Go Back "> 
</form>

<?php
        echo "<br><br/>";
        echo "<h3>Scheduled Trainings:</h3>";
	if($result->num_rows > 0){
		while($resultRow = $result->fetch_array()){
			$trainingDate = strtotime($resultRow["date_time"]);
                        $animalName = $resultRow["name"];
                        $type = $resultRow["type"];
                        $species = $resultRow["species"];
                        $usefulDate = date('Y-m-d',$trainingDate);

			echo "<b>Date:</b> $usefulDate <b>Animal:</b> $animalName($species) <b>Training Type:</b> $type";
                        echo "<br><br/>";
		}
	}else{
		echo "No training have been assigned";
	}
	echo "<br><br/>";
?>

<b1><br/>
<h3>Schedule Training for an Animal</h3>

<?php
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$query = "select name, species from Assigns_Cage natural join Animals natural join Cages where keeper_user_id='$userID';";
$result = mysqli_query($con, $query);


echo "<form name ='inputForm' onsubmit='return validateForm()' action ='scheduleTraining.php' method='POST'>";
echo "<label>Date</label>";
echo "<input type = 'date' name = 'trainingDate'>";
echo "<br></br>";

echo "<label for='animals'>Choose an Animal:</label>";
echo "<select name='animals' id='animals'> form=inputForm'";
echo "<option value=''></option>";
for($i=0; $i < $result->num_rows; $i++){
        $resultRow = $result->fetch_array();
        $animalName = $resultRow['name'];
        $animalSpecies = $resultRow['species'];
        echo "<option value='$animalName'>Cage $animalName ($animalSpecies)</option>";
}
echo "</select><br></br>             ";

echo "<label>Training Type</label>";
echo "<input type = 'text' name = 'trainingType'>";

echo "<br></br>";
echo "<input type='submit' value='Assign'>";
echo "</form>";

mysqli_close($con);


?>

<b1><br/>
<b1><br/>

</html> 