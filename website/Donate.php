<?php
	//include the index page
	ob_start();
	include('VisitorHomePage.php');
	ob_end_clean();
	if(!isset($_SESSION)) {
        	session_start();
    }
?>
<html>

	<head>
		<title>Donation Page</title>
	</head>

	<body>
	    <a href = "VisitorHomePage.php">Home Page </a>
        <?php echo "<br>"; echo "<br>"; ?>
        <?php echo "<br>"; echo "<br>"; ?>


        <h1>We will be Happy if You Donate our Organization</h1>
        <?php echo "<br>"; echo "<br>"; ?>
        <?php echo "<br>"; echo "<br>"; ?>
        <fieldset Donations>
            <legend>Your Donations</legend>
	    <table>
            <tr>
                <th>Event Name</th>
                <th>location</th>
                <th>Date</th>
                <th>Amount of Donation</th>
            </tr>
            <?php
                $visitor_name = $_SESSION['visitor_name'];
                $visitor_id = $_SESSION['visitor_id'];
                $query = "SELECT event_id, donation_amount FROM Make_Donation WHERE user_id = '$visitor_id'";
                $result = mysqli_query($conn,$query);
                if ($result->num_rows  > 0){
                    while ($row = $result->fetch_assoc()){
                        $ev_id = $row['event_id'];
                        $amount = $row['donation_amount'];
                        $query1 = "SELECT* FROM Events WHERE event_id = '$ev_id'";
                        $result1 = mysqli_query($conn,$query1);
                        $row1 = mysqli_fetch_assoc($result1);
                        echo "<br><tr><td>---". $row1["name"]. "</td><td>---". $row1["location"]. "</td><td>---". $row1["date"]. "</td><td>---". $amount. " $";
                    }

                }
                else{
                    echo "---------------You Have Not Donate Yet---------------";
                }
           ?>
       	</table>
       	</fieldset>


       	<div id="container">
        		<div id="info">
        		    <form action = "" method="post">
        			<fieldset Organization>
                                <legend>Organizations </legend>
        			    <input type="text" name="companyID" placeholder="12345678"><br />
        			    <label for="companyID"> Company ID</label>
        			    <input type="submit" value="Submit" />
        			</fieldset>
        		    </form>
        		</div>
        	</div>
	</body>
</html>
