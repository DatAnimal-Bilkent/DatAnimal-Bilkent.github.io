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
    echo "Assign Cages To Keepers\n";

    // TODO
    // $uid = $_SESSION['uid'];
    $uid = 1;
    ?>  
    <br><br />
    <form method="get" >
        <?php
        echo "Filters: <br><br />";
        ?>
        <input type="radio" name="filters" value="no">No Filters
        <br><br />
        <input type="radio" name="filters" value="without">Show only cages without any assigned keeper
        <br><br />
        <input type="radio" name="filters" value="byme">Show only cages assigned to keepers by me
        <br><br />
        <input type="submit" name="applyfilters" value="Apply Filters" action=>
    
    <br><br />
    <?php
        $queryStr = "";
        if($_GET['filters'] == "" || $_GET['filters'] == "no")
        {
            $queryStr = "SELECT * FROM Cages";
        }
        
        else if($_GET['filters'] == "without")
        {
            $queryStr = "select * from Cages where cage_id not in (select cage_id from Assigns_Cage);";
        }

        else if($_GET['filters'] == "byme")
        {
            
            $queryStr = "SELECT * FROM Cages WHERE cage_id IN (SELECT cage_id FROM Assigns_Cage WHERE coordinator_user_id = ".$uid.");";
        }
        
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $result = mysqli_query($conn, $queryStr);
        echo "<table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0' >
            <tr>
                <th>Cage ID</th>
                <th>Location</th>
                <th>Population</th>
                <th>Ecosystem</th>
                <th>Temperature</th>
                <th>Action</th>
            </tr> ";
        $cnt = 0;
        while($row = $result->fetch_array())
        {
            echo "<tr>";
            $cciidd = $row["cage_id"];
            echo "<td>".$row["cage_id"]."</td><td>".$row["location"]."</td><td> ".$row["population"]."</td><td> ".$row["ecosystem"]."</td><td> ".$row["temperature"]."</td>";

            $queryStr = "SELECT * FROM Assigns_Cage NATURAL JOIN Users WHERE keeper_user_id = user_id AND cage_id =".$row["cage_id"].";";
            $result2 = mysqli_query($conn, $queryStr);
            if($result2->num_rows == 0)
            {
                echo "<td>Assign to:  ";
                echo "<select name=select$cnt>";
                $queryStr2 = "SELECT user_id, name FROM Keepers NATURAL JOIN Users;";
                $result3 = mysqli_query($conn, $queryStr2);
                while($row = $result3->fetch_array())
                {
                    $ki = $row['user_id'];
                    $kn = $row['name'];
                    echo "<option value='$ki'>$kn</option>";
                    
                }
                    
                echo "</select>  ";
                echo "<button name=assign$cnt value=$cciidd>Assign </button></th>";
            }
            
            else
            {
                $row =$result2->fetch_array();
                echo "<td>Already assigned to: ".$row['name']."  ";
                $cc = $row['cage_id'];
                echo "<a href='removeAssignment.php?cid=$cc'>Remove Assignment</a></td>";
            }
                
            echo "</tr>";
            $cnt ++;
        }
        echo "</table>";
    ?>
    </form>

    <?php
        for($i = 0; $i < $cnt; $i ++)
        {
            if (array_key_exists("assign$i", $_GET))
            {
                $keeperid = $_GET["select$i"];
                $cageid = $_GET["assign$i"];
                //echo "$keeperid  $cageid";
                $queryStr = "INSERT INTO Assigns_Cage VALUES($uid, $keeperid, $cageid);";
                echo $queryStr;
                $result = mysqli_query($conn, $queryStr);
                echo "<script>alert('Assigned Keeper Successfully'); window.location.href='cages.php';</script>";
            }
        }
    ?>
</body>

</html>