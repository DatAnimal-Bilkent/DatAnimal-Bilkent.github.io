<?php
session_start();
$uid = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>

<body>
    <form name="formLog" action="../index.php" method="POST">
        <input type="submit" value="Logout">
    </form>
    <b1><br />
        <form name="formLog" action="facilityworker.php" method="POST">
            <input type="submit" value="Go Back ">
        </form>
        <br></br>

        <?php



        $uid = $_SESSION['username'];
        ?>
        <br><br />
        <form method="get">

            <?php
            $queryStr = "SELECT * FROM Facility_Worker NATURAL JOIN Facilities where user_id = $uid;";

            $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = mysqli_query($conn, $queryStr)->fetch_array();
            $facname = $result['name'];
            $facid = $result['facility_id'];
            $balance = $result['collected_money'];
            echo "Current Stocks of Facility \"$facname\":<br><br />";
            $queryStr = "SELECT * FROM Item_Stocks NATURAL JOIN Stocks NATURAL JOIN Has_Stock WHERE facility_id=$facid;";
            $result = mysqli_query($conn, $queryStr);

            echo "<table id='maintable' class='table-fill' cellpadding='0' border='1' cellspacing='0' >
            <tr>
                <th>Stock ID</th>
                <th>Item</th>
                <th>Amount</th>
                <th>Unit</th>
            </tr> ";
            $cnt = 0;
            
            while($row = $result->fetch_array())
            {
                echo "<tr><td>".$row["stock_id"]."</td><td>".$row["item_type"]."</td><td> ".$row["amount"]."</td><td> ".$row["unit"]."</td></tr>";
            }

            echo "</table>";
            echo "Facility balance: $balance<br><br />";
            echo "<br><br />Purchase Stock<br><br />";
            ?>

            <?php
            echo "Item: <br><br />";
            ?>
            <input type="text" name="item" value="">
            <br><br />
            <?php
            echo "Amount: <br><br />";
            ?>
            <input type="number" name="amount" value="1" min="1">
            <br><br />
            <?php
            echo "Unit: <br><br />";
            ?>
            <input type="text" name="unit" value="">
            <br><br />
            <?php
            echo "Price: <br><br />";
            ?>
            <input type="number" name="price" value="1" min="1">
            <br><br />
            <input type="submit" name="submit" value="Purchase" action=>

        </form>

        <?php
        function buttonAction($facid, $uid)
        {
            echo "<br><br />";
            if ($_GET['item'] == "" || $_GET['amount'] == "" || $_GET['unit'] == "" || $_GET['price'] == "") {
                echo "You have to fill all fields. \n";
                return;
            }

            $conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
            //echo "Clicked";
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $queryStr = "SELECT max(stock_id)+1 as tmp from Stocks";
            $result = mysqli_query($conn, $queryStr);
            $row = mysqli_fetch_array($result);
            $stockid = $row['tmp'];
            $unit = $_GET['unit'];
            $item = $_GET['item'];
            $amount = $_GET['amount'];
            $price = $_GET['price'];
            $currentDate = date("Y-m-d");

            $queryStr = "SELECT collected_money from Facilities WHERE facility_id = $facid";
            $result = mysqli_query($conn, $queryStr);
            $row = mysqli_fetch_array($result);
            if($row['collected_money'] < $price)
            {
                echo "Your facility does not have enough money for this purchase. \n";
                return;
            }
            $remainingMoney = $row['collected_money'] - $price;

            $queryStr = "INSERT INTO Stocks VALUES($stockid, '$unit', '$currentDate' );";
            $result = mysqli_query($conn, $queryStr);

            $queryStr = "INSERT INTO Item_Stocks VALUES($stockid, '$item', $amount );";
            $result = mysqli_query($conn, $queryStr);

            $queryStr = "INSERT INTO Purchase_Stock VALUES($uid, $stockid);";
            $result = mysqli_query($conn, $queryStr);

            $queryStr = "INSERT INTO Has_Stock VALUES($stockid, $facid);";
            $result = mysqli_query($conn, $queryStr);
            
            $queryStr = "UPDATE Facilities SET collected_money = $remainingMoney WHERE facility_id = $facid";
            $result = mysqli_query($conn, $queryStr);
            echo "<script>alert('Purchased new stock succesfully'); window.location.href='purchaseStock.php';</script>";
        }

        if (array_key_exists('submit', $_GET))
            buttonAction($facid, $uid);

        ?>

</body>

</html>