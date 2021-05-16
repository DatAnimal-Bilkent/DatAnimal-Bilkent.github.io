<?php
session_start();
$uid = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<body>

    

    <?php
    //$sname = $_SESSION['name'];
    echo "Create Event\n";
    ?>
    <br><br />
    <?php
        echo "Event Type: ";
        $_GET['eventtype'] = 'edu';
        
        function radioButtonFunction()
        {
            header("Refresh:0");
        }
    ?>
    <br><br />
    
    

    <form method="get" >
        <input type="radio" name="eventtype" value="edu" checked onclick="radioButtonFunction()">Educational    
        <input type="radio" name="eventtype" value="group" onclick="radioButtonFunction()">Group Tour
        
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
        <input type="text" name="oname" value="">
        <br><br />
        <?php
        echo "Quota: <br><br />";
        ?>
        <input type="number" name="quota" value="1" min="1">
        <br><br />
        <input type="submit" name="submit" value="Create" action=>
        <br><br />
    </form>
        
        <?php

        
        $answer = $_GET["eventtype"];  
        echo "............".$answer."............";
        if ($answer == "edu")
        {
            echo "<br><br />Subject:";
            echo "<br><br />";
            echo "<input type=\"text\" name=\"subject\" value=\"\">";
            echo "<br><br />";
        } 
        else if($answer == "group")
        {
            echo "<br><br />Price:";
            echo "<br><br />";
            echo "<input type=\"number\" name=\"price\" value=\"1\" min=\"1\">";
            echo "<br><br />";
        }
        ?>
        <br><br />
        
    
    
        <?php
        function buttonAction()
        {
            
        }

        

        if (array_key_exists('submit', $_GET)) {
            buttonAction();
        }

        //if(array_key_exists('eventtype', $_GET))
        //    radioButtonFunction();

        ?>
    
</body>

</html>