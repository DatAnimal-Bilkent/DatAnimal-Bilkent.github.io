<?php
session_start();
$userID = $_SESSION['username'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$insertOutput = 0;
if (!empty($_POST['animals']))
{
    $queryAnimalName = $_POST['animals'];
    $animalIDQuery = "Select * from Animals where name='$queryAnimalName'";
    $animalIDResult = mysqli_query($con, $animalIDQuery);
    
    $queryVetName = $_POST['vets'];
    $VetIDQuery = "Select user_id from Users where name='$queryVetName'";
    $VetIDResult = mysqli_query($con, $VetIDQuery);

    if($animalIDResult->num_rows == 0 || $VetIDResult->num_rows == 0){
        $insertOutput = -1;
    }

    if($insertOutput != -1){
        $resultRow = $animalIDResult->fetch_array();
        $animalID = $resultRow["animal_id"];
        $cageID = $resultRow["cage_id"];
        $resultRow = $VetIDResult->fetch_array();
        $vetID = $resultRow["user_id"];
        $date = $_POST['treatmentDate'];
        

        $insertQuery = "insert into Request_Treatment values('$animalID', '$userID', '$vetID', '$date', '$cageID', 'Incomplete', 'pending')";
        if( mysqli_query($con, $insertQuery)){
            $insertOutput = 1;
        }else{
            $insertOutput = -1;
        }
    }
}


$query = "Select Animals.name aName, Users.name vName, date_time, acc_status from (Animals natural join Request_Treatment inner join Users on vet_user_id=user_id) where keeper_user_id='$userID';";
$result = mysqli_query($con, $query);

mysqli_close($con);
?>

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
	echo "<h3>Requested Treatments :</h3>";
	if($result->num_rows > 0){
		while($resultRow = $result->fetch_array()){
			$treatmentDate = strtotime($resultRow["date_time"]);
            $animalName = $resultRow["aName"];
            $vetName = $resultRow["vName"];
            $accStatus = $resultRow["acc_status"];
            $usefulDate = date('Y-m-d',$treatmentDate);
            
			echo "<b>Date:</b> $usefulDate <b>Animal Name:</b> $animalName <b>Vet Name:</b> $vetName <b>Acceptance Status:</b> $accStatus";
            echo "<br><br/>";
		}
	}else{
		echo "No treatments have been assigned";
	}
	echo "<br><br/>";
?>

<b1><br/>
<h3>Request New Treatment</h3>

<form name ="treatmentForm" onsubmit="return validateForm()" action = "requestTreatment.php" method = "POST">
        <label>Date</label>
        <input type = "date" name = "treatmentDate">
        <label for='animals'>Animal</label>
        <select name='animals' id='animals'>
        <option value=''></option>
        <?php
            $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
            $query = "select name, species from Assigns_Cage natural join Animals natural join Cages where keeper_user_id='$userID';";
            $result = mysqli_query($con, $query);
            for($i=0; $i < $result->num_rows; $i++){
                $resultRow = $result->fetch_array();
                $animalName = $resultRow['name'];
                $animalSpecies = $resultRow['species'];
                echo "<option value='$animalName'>$animalName ($animalSpecies)</option>";
            }
            mysqli_close($con);
        ?>
        </select><br></br>
        
        <label for='vets'>Vet</label>
        <select name='vets' id='vets'>
        <option value=''></option>
        <?php
            $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
            $query = "select name, speciality from Users natural join Veterinarians;";
            $result = mysqli_query($con, $query);
            for($i=0; $i < $result->num_rows; $i++){
                $resultRow = $result->fetch_array();
                $vetName = $resultRow['name'];
                $vetSpeciality = $resultRow['speciality'];
                echo "<option value='$vetName'>$vetName ($vetSpeciality)</option>";
            }
            mysqli_close($con);
        ?>
        </select><br></br>

        <input type="submit" value="Request"> 
</form>
<b1><br/>

<?php
    if($insertOutput == 1){
        echo "Treatment has been succesfuly requested";
    }else if($insertOutput == -1){
        echo "ERROR! Request Failed - A Treatment with the same values already exists!";
    }   
?>

<script>
	function validateForm() 
	{
        if (document.getElementById("animals").value == "" || 
        document.getElementById("vets").value == ""  ||
        document.forms["treatmentForm"]["treatmentDate"].value == "" ){
        	alert("Fields can not be empty");
        	return false;
    	}       
    }
</script>


</html> 