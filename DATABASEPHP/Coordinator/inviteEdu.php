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
    echo "Invite Veterinarians To Educational Programs\n";

    
    // TODO
    // $uid = $_SESSION['id'];
    $uid = 1;
    ?>  
    
    <br><br />
    <form method="get" >
        <?php
        echo "Educational Program: <br><br />";
        echo "<select name='programs'>";

        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $queryStr = "SELECT event_id, name FROM Educational_Program NATURAL JOIN Events;";
        
        $result = mysqli_query($conn, $queryStr);

        while($row = $result->fetch_array())
        {
            $id = $row['event_id'];
            $name = $row['name'];
            echo "<option value='$id' name = '$name' >$name</option>";
        }

        echo "</select>";
        echo "<br></br>";
        echo "Veterinarian: <br><br />";
        echo "<select name='vets'>";
        $queryStr = "SELECT user_id, name FROM Veterinarians NATURAL JOIN Users;";
        $result = mysqli_query($conn, $queryStr);

        while($row = $result->fetch_array())
        {
            $id = $row['user_id'];
            $name = $row['name'];
            echo "<option value='$id' name = '$name' >$name</option>";
        }

        echo "</select>";
        echo "<br></br>";
        ?>

        <br><br />
        <input type="submit" name="submit" value="Invite" action=>
    </form>
    
    <?php
    function buttonAction()
    {
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $vetid = $_GET['vets'];
        $eventid = $_GET['programs'];
        
        // TODO
        // $uid = $_SESSION['uid'];
        $uid = 1; 

        $queryStr = "INSERT INTO Invites_Edu VALUES($vetid, $uid, $eventid,'pending')";
        $result = mysqli_query($conn, $queryStr);
        echo ".............".$result.".............";

        if($result)
        {
            echo "<script>alert('Veterinarian Invited To Educational Program Succesfully.'); window.location.href='CoordinatorMain.php';</script>";
        }
        else
        {
            echo "<script>alert('This Veterinarian Already Invited To This Program.'); window.location.href='inviteEdu.php';</script>";
        }
    }

    if (array_key_exists('submit', $_GET))
        buttonAction();
    ?>
    
</body>

</html>