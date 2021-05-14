
<?php
	//include dataabase for connecting into the database
	include("DatabaseConnection.php");
	session_start();
?>

<html>
    <head>
    		<title>Visitors Home Page</title>
    </head>
	<body>
	    <?php
	        echo "Welcome Mr/Miss ask from ligin page this";
	    ?>

	    <?php echo "<br>"; echo "<br>"; ?>

        <fieldset>

	    <form action ="/Donate.php">
	        <input type="submit" value="Donate DatAnimal" />
	    </form>


	    <form action ="/PastVisit.php">
            <input type="submit" value="Your Past Visits" />
        </form>

        <form action ="/AttendGroupTour.php">
            <input type="submit" value="Attend a Group Tour" />
        </form>

        <form action ="/Complaints.php">
            <input type="submit" value="Your Complaints" />
        </form>

        </fieldset>

        <?php echo "<br>"; echo "<br>"; ?>

        <a href = "Logout.php">Logout </a>
	</body>
</html>
