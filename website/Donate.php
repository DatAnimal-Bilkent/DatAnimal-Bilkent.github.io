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
        <h1>We Will be Happy if You Donate Our Organization</h1>
        <?php
              $visitor_id = $_SESSION['visitor_id'];
              $query = "SELECT Total_amount_of_money FROM Visitors WHERE user_id = '$visitor_id' ";
              $result = mysqli_query($conn,$query);
              $row = mysqli_fetch_assoc($result);
              $credit = $row['Total_amount_of_money'];
              echo "Your Credit: <b>".$credit."$<b>";
        ?>
        <?php echo "<br>"; echo "<br>"; ?>
        <fieldset Donations>
            <legend>Your Past Donations</legend>
	    <table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0'>
            <tr>
                <th>Event Name</th>
                <th>location</th>
                <th>Date of Organization</th>
                <th>Total of your Donation</th>
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
                        echo "<br><tr><td>". $row1["name"]. "</td><td>". $row1["location"]. "</td><td>". $row1["date"]. "</td><td>". $amount. " $";
                    }

                }
                else{
                    echo "---------------You Have Not Donate Yet---------------";
                }
           ?>
       	</table>
       	</fieldset>


        <fieldset Organization>
            <legend>Organizations For Your Donation</legend>
       	<div id="container">
            <div id="info">
                <form action = "" method="post">
                    <?php echo "<br>"; echo "<br>"; ?>
                    <label for="Organization"> Organization</label>
                    <input type="text" name="Organization" placeholder="ID/Name"><br />
                    <input type="submit" value="Search" />
                </form>
            </div>
        </div>


        <table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0'>
            <tbody>
            <tr>
                <th>Event Name</th>
                <th>location</th>
                <th>Date of Organization</th>
                <th>Total Donated Money </th>
                <th>Donate </th>
            </tr>
            </tbody>
        <?php
            ob_start();
            $query = "SELECT DISTINCT e.event_id, e.name, e.location, e.date, c.CollectedMoney FROM Events AS e, Conservation_Organizations AS c WHERE e.event_id = c.event_id";
            $result = mysqli_query($conn,$query);
            if ($result->num_rows  > 0){
                while ($row = $result->fetch_assoc()){
                    $colMoney = $row['CollectedMoney'];
                    $_SESSION['money'] = $colMoney;
                    echo "<br><tr><td>". $row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $colMoney. " $";
                    echo "<td> <button onClick=makeDonate('$row[event_id]');> Donate </button> </td> ";
                }
            }
            else{
                echo "---------------There is not any Organization for Donate---------------";
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $organ= mysqli_real_escape_string($conn, $_POST['Organization']);
                if(is_numeric($organ)){
                    $query = "SELECT CollectedMoney FROM Conservation_Organizations WHERE event_id = '$organ'";
                    $result = mysqli_query($conn,$query);
                    if ($result->num_rows  > 0){
                        $row = mysqli_fetch_assoc($result);
                        $colMoney = $row['CollectedMoney'];
                        $query = "SELECT name, location, date FROM Events WHERE event_id = '$organ'";
                        $result = mysqli_query($conn,$query);
                        $row= mysqli_fetch_assoc($result);
                        ob_end_clean();
                        echo "<br><tr><td>". $row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $colMoney. " $";
                        echo "<td> <button onClick=makeDonate('$organ');> Donate </button> </td> ";
                    }
                    else{
                        echo '<script>alert("There is not any Organization by this ID")</script>';
                    }
                }
                else{
                    $organ= mysqli_real_escape_string($conn, $_POST['Organization']);
                    $query = "SELECT e.event_id, e.name, e.location, e.date, c.CollectedMoney FROM Events AS e, Conservation_Organizations AS c WHERE e.name= '$organ' AND e.event_id = c.event_id";
                    $result = mysqli_query($conn,$query);
                    if ($result->num_rows  > 0){
                        $row = mysqli_fetch_assoc($result);
                        $colMoney = $row['CollectedMoney'];
                        ob_end_clean();
                        echo "<br><tr><td>". $row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $colMoney. " $";
                        echo "<td> <button onClick=makeDonate('$row[event_id]');> Donate </button> </td> ";
                    }
                    else{
                        echo '<script>alert("There is not any Organization by this Name")</script>';
                    }
                }
            }
        ?>
        </fieldset>
        <script>
        function makeDonate(a) {
            var page='MakeDonation.php?varJS='+a;
            document.location.href= page;

        }
        </script>
	</body>
</html>
