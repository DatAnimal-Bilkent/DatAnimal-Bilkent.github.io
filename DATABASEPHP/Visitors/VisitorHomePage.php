
<?php
session_start();
    define('ROOT', __DIR__);
	//include dataabase for connecting into the database
	include "/LoginFiles/login.php";
    include "DatabaseConnection.php";
?>

<html>

    <a href = "../Visitors/Logout.php">Logout </a>
    <head>
    		<title>Visitors Home Page</title>
    </head>
    <h1> Welcome to DatAnimal</h1>

	<body>
	    <?php
	        $userID = $_SESSION['username'];
	        $query = "SELECT* FROM Users WHERE user_id = '$userID'";
	        $result = mysqli_query($conn,$query);
	        $rowCount = mysqli_num_rows($result);
	        echo $row['user_id'];
	        if ($rowCount == 1) {
	            $row = mysqli_fetch_assoc($result);
	            $_SESSION['visitor_id'] = $row['user_id'];
                $_SESSION['visitor_name'] = $row['name'];
                if($row['gender'] == 'Female'){
                    echo "<br>"; echo "<br>";
                    echo "Welcome Miss.";
                    echo $_SESSION['visitor_name'];
                }
                else{
                    echo "<br>"; echo "<br>";
                    echo "Welcome Mr.";
                    echo $_SESSION['visitor_name'];
                }
	        }
	    ?>

	    <?php echo "<br>"; echo "<br>"; ?>

        <fieldset >
            <legend>Select A Option</legend>
	    <form action ="../Visitors/Donate.php">
	        <input type="submit" value="Donate DatAnimal" />
	    </form>

        <form action ="../Visitors/GroupTour.php">
            <input type="submit" value="Group Tours" />
        </form>

         <form action ="../Visitors/ChargeWallet.php">
                    <input type="submit" value="Your Wallet" />
         </form>

        <form action ="../Visitors/Complaint.php">
            <input type="submit" value="Your Complaints" />
        </form>

        </fieldset>

        <?php echo "<br>"; echo "<br>"; ?>


	</body>
</html>
