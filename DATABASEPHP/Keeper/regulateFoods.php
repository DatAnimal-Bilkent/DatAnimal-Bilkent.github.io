<?php
session_start();
$userID = $_SESSION['username'];
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

$query = "Select cage_id, Foods.name fName, expiration_date, amount, food_type, unit from (Regularizes_Food natural join Foods natural join Food_Stocks natural join Stocks) where user_id='$userID';";
$result = mysqli_query($con, $query);

mysqli_close($con);
?>
<script type="text/javascript">
        function typeSelect($argument) 
        {
                document.getElementById("foodTypes").value = $argument;
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
<h3>Request New Treatment</h3>

<?php
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
$query = "select food_type from Food_Stocks;";
$result = mysqli_query($con, $query);



echo "<label for='foodTypes'>Choose a Food Type:</label>";
echo "<form name ='itemTypeBtn' action ='regulateFoods.php' method='POST'>";
echo "<select name='foodTypes' id='foodTypes'> form=itemType'";
echo "<option value=''></option>";
for($i=0; $i < $result->num_rows; $i++){
        $resultRow = $result->fetch_array();
        $foodTypeOption = $resultRow['food_type'];
        echo "<option value='$foodTypeOption'>$foodTypeOption</option>";
}
echo "</select>             ";
echo "<input type='submit' value='Confirm Type'> 
</form>";


if($_POST['foodTypes'] != ''){
        $iT = $_POST['foodTypes'];
        echo "<script type='text/javascript'> typeSelect('$iT'); </script>";
        $query = "select name, amount, unit from Foods natural join Food_Stocks natural join Stocks where food_type='$iT';";
        $itemResult = mysqli_query($con, $query);
        $temp = $itemResult->num_rows;

        echo "<label for='foodItems'>Choose a Food Item:</label>";
        echo "<form name ='foodItemBtn' action ='regulateFoods.php' method='POST'>";
        echo "<select name='foodItems' id='foodTypes'> '";
        echo "<option value=''></option>";
        for($i=0; $i < $itemResult->num_rows; $i++){ 
                $resultRow = $itemResult->fetch_array();
                $foodItemOption = $resultRow['name'];
                $foodItemAmount = $resultRow['amount'];
                $foodItemUnit = $resultRow['unit'];
                echo "<option value='$foodItemOption'>$foodItemOption($foodItemAmount $foodItemUnit)</option>";
        }
        echo "</select>";
        echo "<input type='submit' value='Confirm Item'> 
        </form>";
}
mysqli_close($con);


?>

<b1><br/>
<b1><br/>

</html> 