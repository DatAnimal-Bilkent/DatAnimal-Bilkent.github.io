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

    $query = "Select * from Users where user_id='$uid'";
    $result = mysqli_query($con, $query);

    if ($result->num_rows == 1) {
    $resultRow = $result->fetch_array();
    $uname = $resultRow["name"];
    }

    echo "Welcome $uname\n";

    ?>
    <br><br />
    <form method="get" >
        <input type="submit" name="button1" value="Complaints" action=>
        <br><br />
        <input type="submit" name="button2" value="Create Conservation Organization" action=>
        <br><br />
        <input type="submit" name="button3" value="Create Educational Program" action=>
        <br><br />
        <input type="submit" name="button31" value="Create Group Tour" action=>
        <br><br />
        <input type="submit" name="button4" value="Cages" action=>
        <br><br />
        <input type="submit" name="button5" value="Send Email To Visitors" action=>
        <br><br />
        <input type="submit" name="button6" value="Invite Veterinarians To Educational Programs" action=>
    </form>
    <form name ="formLog" action = "../index.php" method = "POST">
        <br><br />
        <input type="submit" value="Logout"> 
    </form>
    <?php

    function button1Action()
    {
        header("Location: seeComplaints.php");
    }
    function button2Action()
    {
        header("Location: createConservationOrganization.php");
    }
    function button3Action()
    {
        header("Location: createEducational.php");
    }
    function button31Action()
    {
        header("Location: createGroupTour.php");
    }
    function button4Action()
    {
        header("Location: cages.php");
    }
    function button5Action()
    {
        header("Location: sendEmail.php");
    }
    function button6Action()
    {
        header("Location: inviteEdu.php");
    }

    if (array_key_exists('button1', $_GET))
        button1Action();
    if (array_key_exists('button2', $_GET))
        button2Action();
    if (array_key_exists('button3', $_GET))
        button3Action();
    if (array_key_exists('button31', $_GET))
        button31Action();
    if (array_key_exists('button4', $_GET))
        button4Action();
    if (array_key_exists('button5', $_GET))
        button5Action();
    if (array_key_exists('button6', $_GET))
        button6Action();

    ?>

</body>

</html>