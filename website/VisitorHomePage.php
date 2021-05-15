
<?php
	//include dataabase for connecting into the database
	include("DatabaseConnection.php");
	session_start();
?>

<html>
    <head>
    		<title>Visitors Home Page</title>
    </head>
    <h1> Welcome to DatAnimal</h1>
	<body>
	    <?php
	        $query = "SELECT name, user_id FROM Users WHERE user_id = 1";
	        $result = mysqli_query($conn,$query);
	        $rowCount = mysqli_num_rows($result);
	        if ($rowCount == 1) {
	            $row = mysqli_fetch_assoc($result);
	            $_SESSION['visitor_id'] = $row['user_id'];
                $_SESSION['visitor_name'] = $row['name'];
                echo "<br>"; echo "<br>";
                echo "Welcome Mr/Miss  ";
                echo $_SESSION['visitor_name'];
                echo " ". $_SESSION['visitor_id'];
	        }

	    ?>

	    <?php echo "<br>"; echo "<br>"; ?>

        <fieldset >
            <legend>Select A Option</legend>
	    <form action ="/Donate.php">
	        <input type="submit" value="Donate DatAnimal" />
	    </form>


	    <form action ="/PastVisit.php">
            <input type="submit" value="Your Past Visits" />
        </form>

        <form action ="/GroupTour.php">
            <input type="submit" value="Attend a Group Tour" />
        </form>

        <form action ="/Complaints.php">
            <input type="submit" value="Your Complaints" />
        </form>

        </fieldset>

        <?php echo "<br>"; echo "<br>"; ?>

        <a href = "/Logout.php">Logout </a>
	</body>
</html>
