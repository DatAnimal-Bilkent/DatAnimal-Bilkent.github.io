<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
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
    echo "Send E-mail to Visitors\n";
    ?>  
    <br><br />
    <form method="get" >
        <?php
        echo "Event: <br><br />";
        ?>
        <select name="events" id="eve">
        <?php
        $queryStr = "SELECT event_id, name FROM Events NATURAL JOIN Group_Tours;";
        session_start();
        // Create connection
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $result = mysqli_query($conn, $queryStr);
        while ($row = $result->fetch_array())
        {
            echo " <option value=\"".$row['event_id']."\">".$row['name']."</option>";
        }
        ?>
        </select>

        <br><br />
        <?php
        echo "Subject: <br><br />";
        ?>
        <input type="text" name="subject" value="">
        <br><br />
        <?php
        echo "Message: <br><br />";
        ?>
        <textarea name="message" value="" rows=20 cols=100></textarea>
        <br><br />
        <br><br />
        
        <input type="submit" name="submit" value="Send" action=>
        <br><br />
    </form>
    <?php

    function buttonAction()
    {
        echo $_GET['events'];
        $queryStr = "SELECT email FROM Attends NATURAL JOIN Users NATURAL JOIN Group_Tours WHERE event_id =".$_GET['events'];
        $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $result = mysqli_query($conn, $queryStr);

        //require_once('PHPMailer/PHPMailerAutoload.php');
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->SMTPAuth = true;;
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = '465';
        $mail->isHTML();
        $mail->Username   = 'datanimal.bilkent@gmail.com';
        $mail->Password   = 'datanimal123&&';
        
        $mail->SetFrom('noreply@datanimal.org');
        $mail->Subject = $_GET['subject'];
        $mail->Body = $_GET['message'];

        while ($email = $result->fetch_array()['email'])
        {
            try
            {
                $mail->AddAddress($email);
            }
            catch(Exception $e)
            {

            }
                
        }

        $mail->Send();
        echo "<script>alert('Sent Email(s) Successfully'); window.location.href='CoordinatorMain.php';</script>";

        //header("Location: CoordinatorMain.php");
    }

    if (array_key_exists('submit', $_GET)) {
        buttonAction();
    }

    ?>
</body>

</html>