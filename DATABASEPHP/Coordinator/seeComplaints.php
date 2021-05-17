<?php
session_start();
$uid = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>

<body>
    <form name ="formLog" action = "../index.php" method = "POST">
        <input type="submit" value="Logout"> 
    </form>
    <b1><br/>
    <form name ="formLog" action = "CoordinatorMain.php" method = "POST">
            <input type="submit" value="Go Back "> 
    </form>
    <br></br>
    <?php
    //$sname = $_SESSION['name'];
    echo "Complaints\n";

    $uid = $_SESSION['username'];
    
    ?>  
    
    <br><br />
    <form method="get" >
        <?php
        echo "Filters: <br><br />";
        ?>
        <input type="radio" name="filters" value="all">Show All Complaints
        <br><br />
        <input type="radio" name="filters" value="unreplied">Show Unreplied Complaints
        <br><br />
        <input type="submit" name="applyfilters" value="Apply Filters" action=>
        <?php
        $queryStr = "";

        if($_GET['filters'] == "" || $_GET['filters'] == "all")
        {
            $queryStr = "SELECT * FROM Complaint_Form NATURAL JOIN Users";
        }
        
        else if($_GET['filters'] == "unreplied")
        {
            $queryStr = "SELECT * FROM Complaint_Form NATURAL JOIN Users WHERE complaint_id NOT IN (SELECT complaint_id FROM Respond_complaint);";
        }

        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $result = mysqli_query($conn, $queryStr);
        echo "<table  id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0' >
            <tr>
                <th>Date</th>
                <th>Creator</th>
                <th>Topic</th>
                <th>Action</th>
            </tr> ";
        while($row = $result->fetch_array())
        {
            $cc = $row['complaint_id'];
            echo "<tr><td>".$row['complaint_date']."</td><td> ".$row['name']."</td><td> ".$row['topic']."</td> ";
            echo "<td><a href='showComplaintDetails.php?cid=$cc'>Show Details</a></td>";
            echo "<br><br />";
        }
        
        ?>
    </form>

    
</body>

</html>