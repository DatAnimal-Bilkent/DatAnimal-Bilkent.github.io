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
    <form name ="formLog" action = "seeComplaints.php" method = "POST">
            <input type="submit" value="Go Back "> 
    </form> 
    <br></br>

    <?php
    //$sname = $_SESSION['name'];
    echo "Complaint Details\n";
    
    ?> 
    
    <br><br />
    <form method="get" >
        
        
    
        <br><br />
        <?php
        $cd = $_GET['cid'];
        echo "<input type='hidden' name = 'cid' value = $cd>";
        
        $uid = $_SESSION['username'];

        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $queryStr = "SELECT * FROM Complaint_Form NATURAL JOIN Users where complaint_id=$cd";
        $result = mysqli_query($conn, $queryStr)->fetch_array();
        $by = $result['name'];
        $topic = $result['topic'];
        $body = $result['text'];
        echo "Written By: $by<br><br />Topic: $topic<br><br /> Message:<br><br />$body<br><br />";
        
        echo "<br><br />";
        $queryStr = "SELECT * FROM Respond_complaint where complaint_id = $cd";
        $result = mysqli_query($conn, $queryStr);

        if($result->num_rows != 0)
            echo "You cannot respond to this complaint because it is already replied.<br><br />";
        else
        {
            echo "Your reply:<br><br />";
            echo "<textarea name='message' value='' rows=20 cols=100></textarea><br><br /><br><br />";
            echo "<input type='submit' name='submit' value='Send' action=> <br><br />";
        }
        ?>
    </form>

    <?php
    function buttonAction()
    {
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $cd = $_GET['cid'];

        $uid = $_SESSION['username'];

        $ttxt = $_GET['message'];
        $currentDate = date("Y-m-d");

        $queryStr = "INSERT INTO Respond_complaint VALUES($cd, $uid, '$ttxt', $currentDate);";
        $result = mysqli_query($conn, $queryStr);
        echo "<script>alert('Complaint Replied Successfully'); window.location.href='seeComplaints.php';</script>";
    }

    if (array_key_exists('submit', $_GET))
        buttonAction();
    ?>

</body>

</html>