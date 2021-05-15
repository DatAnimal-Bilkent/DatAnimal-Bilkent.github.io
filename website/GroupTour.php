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
		<title>Group Tour</title>
	</head>

	<body>
	    <a href = "VisitorHomePage.php">Home Page </a>
        <?php echo "<br>"; echo "<br>"; ?>
        <?php echo "<br>"; echo "<br>"; ?>


        <h1>We Will be Happy if You Attend in Our Group Tours</h1>
        <?php echo "<br>"; echo "<br>"; ?>
        <fieldset Donations>
            <legend>Your Attend In our Group Tours</legend>
	    <table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>location</th>
                <th>Date </th>
                <th>spent Money</th>
            </tr>
            <?php
                $visitor_name = $_SESSION['visitor_name'];
                $visitor_id = $_SESSION['visitor_id'];
                $query = "SELECT event_id, payment FROM Attends WHERE user_id = '$visitor_id'";
                $result = mysqli_query($conn,$query);
                if ($result->num_rows  > 0){
                    while ($row = $result->fetch_assoc()){
                        $ev_id = $row['event_id'];
                        $amount = $row['payment'];
                        $query1 = "SELECT* FROM Events WHERE event_id = '$ev_id'";
                        $result1 = mysqli_query($conn,$query1);
                        $row1 = mysqli_fetch_assoc($result1);
                        echo "<br><tr><td>". $ev_id. "</td><td>". $row1["name"]. "</td><td>". $row1["location"]. "</td><td>". $row1["date"]. "</td><td>". $amount. " $";

                    }

                }
                else{
                    echo "---------------You Have Not Attend any Group Tours Yet---------------";
                }
           ?>
       	</table>
       	</fieldset>


        <fieldset Organization>
            <legend>Group Tours</legend>
       	<div id="container">
            <div id="info">
                <form action = "" method="post">
                    <?php echo "<br>"; echo "<br>"; ?>
                    <label for="GroupTour"> Group Tour</label>
                    <input type="text" name="GroupTour" placeholder="ID/Name"><br />
                    <input type="submit" value="Search" />
                </form>
            </div>
        </div>


        <table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0'>
            <tbody>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>location</th>
                <th>Date </th>
                <th>Visitor Quota </th>
                <th>Price </th>
            </tr>
            </tbody>
        <?php
            ob_start();
            $visitor_id = $_SESSION['visitor_id'];
            $query = "SELECT e.event_id, e.name, e.location, e.date, g.price, g.visitor_qouta
                      FROM Events AS e, Group_Tours AS g, Attends a
                      WHERE e.event_id = g.event_id AND  (e.event_id NOT IN (SELECT event_id FROM Attends WHERE user_id = '$visitor_id')) ";
            $result = mysqli_query($conn,$query);

            if ($result->num_rows  > 0){
                while ($row = $result->fetch_assoc()){
                    $colMoney = $row['price'];
                    $_SESSION['money'] = $colMoney;
                    echo "<br><tr><td>". $row["event_id"]. "</td><td>".$row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $row["visitor_qouta"]. "</td><td>". $colMoney. " $";
                    echo "<td> <button onClick=makeDonate('$row[event_id]');> Donate </button> </td> ";
                }
            }
            else{
                echo "---------------There is not any Group_Tours For Attending---------------";
            }
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $organ= mysqli_real_escape_string($conn, $_POST['GroupTour']);
                if(is_numeric($organ)){
                    $query = "SELECT price FROM Group_Tours WHERE event_id = '$organ' And event_id NOT IN (SELECT event_id FROM Attends WHERE user_id = '$visitor_id')";
                    $result = mysqli_query($conn,$query);
                    if ($result->num_rows  > 0){
                        $row = mysqli_fetch_assoc($result);
                        $colMoney = $row['price'];
                        $query = "SELECT name, location, date FROM Events WHERE event_id = '$organ'";
                        $result = mysqli_query($conn,$query);
                        $row= mysqli_fetch_assoc($result);
                        ob_end_clean();
                        echo "<br><tr><td>". $organ. "</td><td>". $row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $colMoney. " $";
                        echo "<td> <button onClick=makeDonate('$organ');> Register </button> </td> ";
                    }
                    else{
                        echo '<script>alert("There is not any Group_Tours by this ID or you are already register for that. Please check Group Tour ID.")</script>';
                    }
                }
                else{
                    $organ= mysqli_real_escape_string($conn, $_POST['Group_Tours']);
                    $query = "SELECT e.event_id, e.name, e.location, e.date, g.price
                                FROM Events AS e, Group_Tours AS g, Attends As a
                                WHERE e.name= '$organ' AND e.event_id = g.event_id AND g.event_id = a.event_id AND NOT a.user_id = '$visitor_id'";
                    $result = mysqli_query($conn,$query);
                    if ($result->num_rows  > 0){
                        $row = mysqli_fetch_assoc($result);
                        $colMoney = $row['price'];
                        ob_end_clean();
                        echo "<br><tr><td>". $organ. "</td><td>". $row["name"]. "</td><td>". $row["location"]. "</td><td>". $row["date"]. "</td><td>". $colMoney. " $";
                        echo "<td> <button onClick=makeDonate('$row[event_id]');> Register </button> </td> ";
                    }
                    else{
                        echo '<script>alert("There is not any Group_Tours by this ID or you are already register for that. Please check Group Tour Name.")</script>';
                    }
                }
            }
        ?>
        </fieldset>
        <script>
        function makeDonate(a) {
            var page='Register.php?varJS='+a;
            document.location.href= page;

        }
        </script>
	</body>
</html>
