<?php
session_start();
$userID = $_SESSION['username'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

if( $_POST['foodItems'] != ''){
    $foodItemName = $_POST['foodItems'];
    $cage = $_POST['cages'];
    echo "$foodItemOption";

    $query = "select food_id from Foods where name='$foodItemName';";
    $result = mysqli_query($con, $query);
    $resultRow = $result->fetch_array();
	$foodID = $resultRow["food_id"];
    $today = date("Y-m-d");

    $insertQuery = "insert into Regularizes_Food values('$userID', '$cage', '$foodID', '$today')";
    if( mysqli_query($con, $insertQuery)){
        echo "<script type='text/javascript'>alert('Insertion Succesful!');</script>";
    }else{
        echo "<script type='text/javascript'>alert('Insertion Unsuccesful!');</script>";
    }

}
$query = "Select cage_id, Foods.name fName, expiration_date, amount, food_type, unit from (Regularizes_Food natural join Foods natural join Food_Stocks natural join Stocks) where user_id='$userID';";
$result = mysqli_query($con, $query);


mysqli_close($con);
?>
<script type="text/javascript">
        function typeSelect($argument, $argument2) 
        {
                document.getElementById($argument2).value = $argument;
        }  
</script>

<script type="text/javascript">
function validateForm() {
        if (document.getElementById("cages").value == ""){
        	alert("Cage and Food Item options can not be empty!");
        	return false;
    	} 
        if (document.getElementById("foodItems").value == ""){
        	alert("Cage and Food Item options can not be empty!");
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
<form name ="formLog" action = "regulateFoods.php" method = "POST">
        <input type="submit" value="Go Back "> 
</form>

<?php
        echo "<br><br/>";
        echo "<h3>Cage Food Stocks:</h3>";
	if($result->num_rows > 0){
		while($resultRow = $result->fetch_array()){
			$expirationDate = strtotime($resultRow["expiration_date"]);
                        $foodName = $resultRow["fName"];
                        $cage_id = $resultRow["cage_id"];
                        $foodAmount = $resultRow["amount"];
                        $unit = $resultRow["unit"];
                        $foodType = $resultRow["food_type"];
                        $usefulDate = date('Y-m-d',$expirationDate);

			echo "<b>Cage:</b> Cage $cage_id  <b>Food Type:</b> $foodType($foodName) <b>Amount:</b> $foodAmount $unit  <b>Expiration Date:</b> $usefulDate";
                        echo "<br><br/>";
		}
	}else{
		echo "No food have been assigned";
	}
	echo "<br><br/>";
?>

<b1><br/>
<h3>Assign Food Item to a Cage</h3>

<?php
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$query = "select cage_id from Assigns_Cage where keeper_user_id='$userID';";
$result = mysqli_query($con, $query);


echo "<form name ='inputForm' onsubmit='return validateForm()' action ='regulateFoods.php' method='POST'>";
echo "<label for='cages'>Choose a Cage:</label>";
echo "<select name='cages' id='cages'> form=inputForm'";
echo "<option value=''></option>";
for($i=0; $i < $result->num_rows; $i++){
        $resultRow = $result->fetch_array();
        $cageOption = $resultRow['cage_id'];
        echo "<option value='$cageOption'>Cage $cageOption</option>";
}
echo "</select><br></br>             ";

$query = "select food_type from Food_Stocks;";
$result = mysqli_query($con, $query);

$iT = $_POST['foodTypes'];
$cage = $_POST['cages'];
echo "<script type='text/javascript'> typeSelect('$cage', 'cages'); </script>";
$query = "select name, amount, unit, food_id from Foods natural join Food_Stocks natural join Stocks where food_type='$iT';";

$itemResult = mysqli_query($con, $query);
$temp = $itemResult->num_rows;

echo "<label for='foodItems'>Choose Food Item:</label>";
echo "<select name='foodItems' id='foodTypes'> '";
echo "<option value=''></option>";
for($i=0; $i < $itemResult->num_rows; $i++){ 
    $resultRow = $itemResult->fetch_array();
    $foodItemOption = $resultRow['name'];
    $foodItemAmount = $resultRow['amount'];
    $foodItemUnit = $resultRow['unit'];

    $foodID = $resultRow['food_id'];
    $query2 = "select food_id from Regularizes_Food where food_id='$foodID';";
    $query2Result = mysqli_query($con, $query2);

    if($query2Result->num_rows == 0){
        echo "<option value='$foodItemOption'>$foodItemOption($foodItemAmount $foodItemUnit)</option>";
    }
}
echo "</select>";
echo "<br></br>";
echo "<input type='submit' value='Assign'>";
echo "</form>";

mysqli_close($con);


?>

<b1><br/>
<b1><br/>

</html> 