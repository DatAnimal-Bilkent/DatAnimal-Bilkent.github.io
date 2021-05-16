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
    <br><br /> 
    <?php
    //$sname = $_SESSION['name'];
    
    echo "Create Conservation Organization\n";
    ?>
    <br><br />
    <form method="get" >
        <?php
        echo "Date: <br><br />";
        ?>
        <input type="date" name="date" value="">
        <br><br />
        <?php
        echo "Location: <br><br />";
        ?>
        <input type="text" name="location" value="">
        <br><br />
        <?php
        echo "Name: <br><br />";
        ?>
        <input type="text" name="oname" value="">
        <br><br />
        <?php
        echo "Subject: <br><br />";
        ?>
        <input type="text" name="subject" value="">
        <br><br />
        <?php
        echo "Quota: <br><br />";
        ?>
        <input type="number" name="quota" value="1" min="1">
        <br><br />
        <input type="submit" name="submit" value="Create"  action=>
    </form>

    <?php

    function buttonAction()
    {
        if($_GET['date'] == "" || $_GET['location'] == "" || $_GET['oname'] == "" || $_GET['subject'] == "" || $_GET['quota'] == "" )
        {
            echo "You have to fill all fields. \n";
            return;
        }
        session_start();
        // Create connection
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        //echo "Clicked";
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // TODO
        //$currentUser = $_SESSION['userid'];
        $currentUser = 1;
        $eventid = 0;
        
        $queryStr = "SELECT max(event_id)+1 as tmp from Events";
        $result = mysqli_query($conn, $queryStr);
        $row = mysqli_fetch_array($result);
        $eventid = $row['tmp'];

        $queryStr = "INSERT INTO  Events (event_id, date, location, user_id, name) 
        VALUES(".$eventid.", '".$_GET['date']."', '".$_GET['location']."', ".$currentUser.", '".$_GET['oname']."');
        ";
        $result = mysqli_query($conn, $queryStr);
        echo ".......".$result.".......";

        $queryStr = "INSERT INTO Conservation_Organizations(event_id, collectedMoney) 
        VALUES(".$eventid.",0);";

        $result = mysqli_query($conn, $queryStr);

        //header("Location: CoordinatorMain.php");
        echo "<script>alert('Created new Conservation Organization Successfully'); window.location.href='CoordinatorMain.php';</script>";
    }

    if (array_key_exists('submit', $_GET)) {
        buttonAction();
    }

    ?>
</body>

</html>