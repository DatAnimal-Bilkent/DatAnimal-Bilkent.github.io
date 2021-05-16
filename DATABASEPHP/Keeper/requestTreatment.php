<?php
session_start();
$userID = $_SESSION['username'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");


$insertOutput = 0;
if (!empty($_POST['treatmentAnimal']))
{
    $queryAnimalName = $_POST['treatmentAnimal'];
    $animalIDQuery = "Select * from Animals where name='$queryAnimalName'";
    $animalIDResult = mysqli_query($con, $animalIDQuery);
    
    $queryVetName = $_POST['treatmentVet'];
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
        $date = $_POST['treatmentData'];
        
        $insertQuery = "insert into Request_Treatment values('$animalID', '$userID', '$vetID', '$date', '$cageID', 'Incomplete', 'no idea')";
        if( mysqli_query($con, $insertQuery)){
            echo "Insertion succesful";
        }else{
            echo "Insertion unsuccesful";
        }
    }
}


$query = "Select * from Animals natural join Request_Treatment where keeper_user_id='$userID'";
$result = mysqli_query($con, $query);

mysqli_close($con);
?>

<!DOCTYPE HTML>  
<html>
<form name ="formLog" onsubmit="return validateForm()" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
</form>
<b1><br/>
<button onclick='history.go(-1);'>Go Back </button>

<?php
    echo "<br><br/>";
	echo "<h3>Requested Treatments :</h3>";
	if($result->num_rows > 0){
		while($resultRow = $result->fetch_array()){
			$treatmentDate = $resultRow["date_time"];
            $animalID = $resultRow["animal_id"];
            $vetID = $resultRow["vet_user_id"];
            $treatmentStatus = $resultRow["treatment_status"];

            $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
            $vetNameQuery = "Select name from Users where user_id='$vetID'";
            $result = mysqli_query($con, $vetNameQuery);
            $resultRow = $result->fetch_array();
            $vetName = $resultRow["name"];

            $animalNameQuery = "Select name from Animals where animal_id='$animalID'";
            $result = mysqli_query($con, $animalNameQuery);
            $resultRow = $result->fetch_array();
            $animalName = $resultRow["name"];

            mysqli_close($con);
			echo "<b>Date:</b> $treatmentDate <b>Animal Name:</b> $animalName <b>Vet Name:</b> $vetName <b>Status:</b> $treatmentStatus";
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
        <label>Animal</label>
        <input type = "text" name = "treatmentAnimal">
        <label>Vet</label>
        <input type = "text" name = "treatmentVet">
        <br><br/>
        <input type="submit" value="Request"> 
</form>


<script>
	function validateForm() 
	{
        if (document.forms["treatmentForm"]["treatmentAnimal"].value == "" || 
        document.forms["treatmentForm"]["treatmentVet"].value == "" ||
        document.forms["treatmentForm"]["treatmentDate"].value == "" ){
        	alert("Fields can not be empty");
        	return false;
    	}       
    }
</script>


</html> 