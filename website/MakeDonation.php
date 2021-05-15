<?php
	//include the index page
	ob_start();
	include('Donate.php');
	ob_end_clean();
	if(!isset($_SESSION)) {
        	session_start();
    }
?>

<html>
    <?php ob_end_clean();?>
    <head>
            <title>Make Donation</title>
    </head>

    <body>

        <?php
              echo "<a href = 'VisitorHomePage.php'>Home Page </a>";
              echo "<br>"; echo "<br>";
              $org_id = $_GET['varJS'];
              $visitor_id = $_SESSION['visitor_id'];
              $query = "SELECT name, gender FROM Users WHERE user_id = '$visitor_id' ";
              $result = mysqli_query($conn,$query);
              $row = mysqli_fetch_assoc($result);
              if ($row > 0){
                  if ($row['gender'] == 'Female'){
                      echo "We can Continue because of your donation Mr.<b>". $row['name']."</b>";
                      echo "<br>"; echo "<br>";
                      echo "<br>"; echo "<br>";
                  }
                  else{
                      echo "We can Continue because of your donation Ms.<b>". $row['name']."</b>";
                      echo "<br>"; echo "<br>";
                      echo "<br>"; echo "<br>";
                  }
              }
              else{
                  echo "<br>ERROR IN FINDING NAME OF VISITOR USER IN MAKEDONATION.PHP<br>";
              }
              $query = "SELECT name, location, user_id FROM Events WHERE event_id = '$org_id'";
              $result = mysqli_query($conn,$query);
              $row = mysqli_fetch_assoc($result);
              if($row > 0){
                   $name = $row['name'];
                   $location = $row['location'];
                   $cordi = $row['user_id'];
                   $query = "SELECT name FROM Users WHERE user_id = '$cordi'";
                   $result = mysqli_query($conn,$query);
                   $row = mysqli_fetch_assoc($result);
                   if($row > 0){
                        $cordi = $row['name'];
                        $query = "SELECT collectedMoney FROM Conservation_Organizations WHERE event_id = '$org_id'";
                        $result = mysqli_query($conn,$query);
                        $row = mysqli_fetch_assoc($result);
                        $colMoney = $row['collectedMoney'];
                        echo "<fieldset>";
                        echo "<legend>Information of Organization</legend>";
                        echo "<br><b>Name of Organization: </b>". $name;
                        echo "<br><b>Location of organization: </b>". $location;
                        echo "<br><b>Coordinator: </b>". $cordi;
                        echo "<br><b>Amount of Money Collected until now: </b>". $colMoney;
                        echo '<br>'; echo '<br>';
                   }
                   else{
                        echo "<br>ERROR IN FINDING COORDINATOR USER_ID IN MAKEDONATION.PHP<br>";
                   }
              }
              else{
                echo "ERROR IN FINDING EVENT_ID IN MAKEDONATION.PHP";
              }

        echo "
            <div id='container'>
                <div id='info'>
                    <form action = '' method='post'>
                        <label for='Money for Donation'> Money</label>
                        <input type='text' name='Money' placeholder='$$$'><br />
                        <input type='submit' value='Donate'/>
                        </fieldset>
                    </form>
                </div>
            </div>";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $money= mysqli_real_escape_string($conn, $_POST['Money']);
            $query = "SELECT Total_amount_of_money FROM Visitors WHERE user_id = '$visitor_id' ";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            if ($row > 0){
                if ($money > $row['Total_amount_of_money']){
                    echo '<script language="javascript">';
                    echo 'alert("you do not have that much money in your account")';
                    echo '</script>';
                }
                else{
                    $colMoney = $colMoney + $money;
                    $query = "UPDATE Conservation_Organizations SET collectedMoney = '$colMoney' WHERE event_id= '$org_id'";
                    $result = mysqli_query($conn,$query);
                    $query = "SELECT Total_amount_of_money FROM Visitors WHERE user_id = '$visitor_id'";
                    $result = mysqli_query($conn,$query);
                    $row = mysqli_fetch_assoc($result);
                    if($row > 0){
                        $colMoney = $row['Total_amount_of_money'] - $money;
                        $query = "UPDATE Visitors SET  Total_amount_of_money = '$colMoney' WHERE user_id = '$visitor_id'";
                        $result = mysqli_query($conn,$query);
                        $query = "SELECT donation_amount FROM Make_Donation WHERE user_id = '$visitor_id' AND event_id = $org_id";
                        $result = mysqli_query($conn,$query);
                        $row = mysqli_fetch_assoc($result);
                        if ($row > 0){
                            $newDonate = $row['donation_amount'] + $money;
                            $query = "UPDATE Make_Donation SET donation_amount = '$newDonate' WHERE user_id = '$visitor_id' AND event_id = $org_id";
                            $result = mysqli_query($conn,$query);
                            echo '<script language="javascript">';
                            echo "if(!alert('Thank You For Donation :)))))')){
                                        window.location.href = 'Donate.php';
                                    }";
                            echo '</script>';
                        }
                        else{
                            $query = "INSERT INTO Make_Donation VALUES('$org_id', '$visitor_id', '$money')";
                            $result = mysqli_query($conn,$query);
                            echo '<script language="javascript">';
                            echo "if(!alert('Thank You For Donation :)))))')){
                                        window.location.href = 'Donate.php';
                                    }";
                            echo '</script>';
                        }

                    }
                }
            }
        }
        ?>
    </body>
    <script>
    </script>
</html>