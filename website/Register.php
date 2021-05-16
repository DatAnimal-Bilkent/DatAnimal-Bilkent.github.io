<?php
	//include the index page
	ob_start();
	include('GroupTour.php');
	ob_end_clean();
	if(!isset($_SESSION)) {
        	session_start();
    }
?>

<html>
    <?php ob_end_clean(); ?>
    <a href = "Logout.php">Logout </a>
    <br><br>
    <?php echo "<a href = 'VisitorHomePage.php'>Home Page </a>"?>
    <?php echo "<br>";echo "<br>";?>
    <br><br>
    <head>
        <title>Register to Group tour</title>
    </head>
    <body>
        <fieldset Organization>
                    <legend><b>Group Tour</b></legend>
        <?php
            $org_id = $_GET['varJS'];
            $visitor_id = $_SESSION['visitor_id'];
            $query = "SELECT e.name, e.date, e.location, e.user_id, g.price, g.visitor_qouta
                       FROM Events e, Group_Tours g
                       WHERE g.event_id = e.event_id AND e.event_id = '$org_id'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $loc = $row['location'];
            $cordi = $row['user_id'];
            $date = $row['date'];
            $name = $row['name'];
            $price = $row['price'];
            $cordi_id = $row['user_id'];
            $quota = $row['visitor_qouta'];
            $query = "SELECT name FROM Users WHERE user_id = '$cordi_id'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $cordi = $row['name'];
            echo"<br><b>Name:    </b>".$name;
            echo"<br><b>Location:   </b>".$loc;
            echo"<br><b>Quota:   </b>".$quota;
            echo"<br><b>Date:   </b>".$date;
            echo"<br><b>Price:   </b>".$price. "$";
            echo"<br><b>Coordinator:   </b>".$cordi;
            $query = "SELECT Total_amount_of_money FROM Visitors WHERE user_id = '$visitor_id'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $money = $row['Total_amount_of_money'];
            if ($_POST['submit']) {
              if ($price <= $money){
                  $id = $_POST['idToDelete'];
                  $query = "INSERT INTO Attends VALUES('$visitor_id', '$org_id', 0)";
                  $result = mysqli_query($conn,$query);
                  $money = $money - $price;
                  $query = "UPDATE Visitors SET Total_amount_of_money = '$money' WHERE user_id = '$visitor_id'";
                  $result = mysqli_query($conn,$query);
                  $quota = $quota - 1;
                  $query = "UPDATE Group_Tours SET visitor_qouta = '$quota' WHERE event_id = '$org_id'";
                  $result = mysqli_query($conn,$query);
                  echo "<script>";
                  echo "window.location.href = 'GroupTour.php'";
                  echo "</script>";
              }
              else{
                echo '<script language="javascript">';
                echo "if(!alert('You Do not have Enough Credit in your account :)))))')){
                      window.location.href = 'GroupTour.php';
                      }";
                echo '</script>';
              }

           }
        ?>
        </fieldset >
        <form method="post" action="">
            <input type="submit" name="submit" value="Pay and Attend "
            onclick="return confirm('Are you sure you want to pay and participate in this Group Tour?')" />
        </form>
    </body>
    <br><br>
       <a href = "GroupTour.php">Back </a>
</html>
