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
    <br><br /> 
    <?php
    //$sname = $_SESSION['name'];
    echo "Create Group Tour\n";
    ?>
       

    <form method="get" >
        
        <br><br />
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
        <input type="text" name="name" value="">
        <br><br />
        <?php
        echo "Quota: <br><br />";
        ?>
        <input type="number" name="quota" value="1" min="1">
        <?php
        echo "<br><br />Price:";
        ?>
        <br><br />
        <input type="number" name="price" value="1" min="1">
        <br><br />
        
        <input type="submit" name="submit" value="Create" action=>
        <br><br />
    </form>
        <br><br />
        
    
    
        <?php
        function buttonAction()
        {
            if($_GET['date'] == "" || $_GET['location'] == "" || $_GET['name'] == "" || $_GET['price'] == "" || $_GET['quota'] == "" )
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
            
            $currentUser = $_SESSION['username'];
            $eventid = 0;
            
            $queryStr = "SELECT max(event_id)+1 as tmp from Events";
            $result = mysqli_query($conn, $queryStr);
            $row = mysqli_fetch_array($result);
            $eventid = $row['tmp'];
    
            $queryStr = "INSERT INTO  Events (event_id, date, location, user_id, name) 
            VALUES(".$eventid.", '".$_GET['date']."', '".$_GET['location']."', ".$currentUser.", '".$_GET['name']."');
            ";
            
            $result = mysqli_query($conn, $queryStr);
            
    
            $queryStr = "INSERT INTO Group_Tours(event_id, visitor_qouta, price) 
            VALUES(".$eventid.",".$_GET['quota'].",".$_GET['price'].");";
    
            $result = mysqli_query($conn, $queryStr);
            echo $queryStr;
            echo ".......".$result.".......";
            echo "<script>alert('Created new Group Tour Successfully'); window.location.href='CoordinatorMain.php';</script>";
            //header("Location: CoordinatorMain.php");
        }

        

        if (array_key_exists('submit', $_GET)) {
            buttonAction();
        }

        //if(array_key_exists('eventtype', $_GET))
        //    radioButtonFunction();

        ?>
    
</body>

</html>