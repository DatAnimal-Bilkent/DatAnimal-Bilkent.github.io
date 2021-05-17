<?php
session_start();
$uid = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<body>

    <?php
    
    $uname = $_SESSION['username'];
    
    

    $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");

    $query = "Select * from Users where user_id='$userID'";
    $result = mysqli_query($con, $query);

    if ($result->num_rows == 1) {
    $resultRow = $result->fetch_array();
    $uname = $resultRow["name"];
    }

    echo "Welcome $uname\n";

    ?>
    <br><br />
    <form method="get" >
        <input type="submit" name="button1" value="Purchase Stock" action=>
        <br><br />
    </form>

    <form name ="formLog" action = "../index.php" method = "POST">
        <br><br />
        <input type="submit" value="Logout"> 
    </form>
    <?php

    function button1Action()
    {
        header("Location: purchaseStock.php");
    }
    

    if (array_key_exists('button1', $_GET))
        button1Action();

    ?>

</body>

</html>