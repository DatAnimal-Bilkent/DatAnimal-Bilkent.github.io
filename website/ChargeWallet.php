<?php
	//include the index page
	ob_start();
	include('VisitorHomePage.php');
	ob_end_clean();
	if(!isset($_SESSION)) {
        	session_start();
    }
?>

<html>
    <head>
    		<title>Wallet</title>
    </head>
    <?php echo "<a href = 'VisitorHomePage.php'>Home Page </a>";
          echo "<br>"; echo "<br>";
    ?>
    <h1> Charge Your DatAnimal Wallet </h1>

    <body>
            <?php

                  $visitor_id = $_SESSION['visitor_id'];
                  $query = "SELECT name, gender FROM Users WHERE user_id = '$visitor_id' ";
                  $result = mysqli_query($conn,$query);
                  $row = mysqli_fetch_assoc($result);
                  if ($row > 0){
                      if ($row['gender'] == 'Female'){
                          echo "You can charge your wallet from here Mr.<b>". $row['name']."</b>";
                          echo "<br>"; echo "<br>";
                          echo "<br>"; echo "<br>";
                      }
                      else{
                          echo "You can charge your Wallet from here Ms.<b>". $row['name']."</b>";
                          echo "<br>"; echo "<br>";
                          echo "<br>"; echo "<br>";
                      }
                  }
                  else{
                      echo "<br>ERROR IN FINDING NAME OF VISITOR USER IN MAKEDONATION.PHP<br>";
                  }
                  $query = "SELECT Total_amount_of_money FROM Visitors WHERE user_id = '$visitor_id' ";
                  $result = mysqli_query($conn,$query);
                  $row = mysqli_fetch_assoc($result);
                  $credit = $row['Total_amount_of_money'];
                  echo "Your Credit: <b>".$credit."$<b>";
                  echo "<br>"; echo "<br>";
                  echo "<br>"; echo "<br>";
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $money = mysqli_real_escape_string($conn, $_POST['Money']);
                        if( $money> 0){
                            $money = $credit + mysqli_real_escape_string($conn, $_POST['Money']);
                            $query = "UPDATE Visitors SET Total_amount_of_money = '$money' WHERE user_id = '$visitor_id'";
                            $result = mysqli_query($conn,$query);
                            echo "<script>";
                            echo "window.location.href = 'ChargeWallet.php'";
                            echo "</script>";
                        }
                        else{
                            echo "Wrong Information";
                        }
                  }
            ?>
            <fieldset>
                <legend> Your Card Information</legend>
                    <div id="container">
                        <div id="info">
                            <form action = "" method="post">
                                <?php echo "<br>"; echo "<br>"; ?>
                                <label for="Money"> Amount of Money</label>
                                <input type="text" name="Money" placeholder="$$$$$$$$$$"><br />
                                <label for="CardNumber"> Your Card Number</label>
                                <input type="text" name="CardNumber" placeholder="123456789"><br />
                                <label for="DateOfIssue"> Data Of Issue</label>
                                <input type="text" name="DateOfIssue" placeholder="MM.YY"><br />
                                <label for="CVV"> CVV</label>
                                <input type="text" name="CVV" placeholder="1234"><br />
                                <input type="submit" name="submit" value="Charge"
                                        onclick="return confirm('Are you sure you?')" />
                            </form>
                        </div>
                    </div>
                </fieldset>
    </body>

</html>