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
    <?php echo "<a href = 'VisitorHomePage.php'>Home Page </a>"?>
    <?php echo "<br>";echo "<br>";?>
    <head>
        <title>Comment </title>
    </head>
     <h1> Your Comment Improves our Services </h1>
    <body>
    <body>

        <form action ="" method="post">
            <textarea name="textarea" rows="10" cols="50" class="box" placeholder="Your Comments."></textarea>
            <?php echo "<br>"; echo "<br>"; ?>
            <input type="submit" name= "submit" value="Complaint"
            onclick="return confirm('Are you sure ?')" />
        </form>
        <?php
            $org_id = $_GET['varJS'];
            $query = "SELECT name, location, date, user_id
                       FROM Events
                       WHERE event_id = '$org_id'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_assoc($result);
            $ev_name = $row['name'];
            $loc = $row['location'];
            $date = $row['date'];
            $cordi_id = $row['user_id'];
            echo "<fieldset >";
            echo "<legend>". $ev_name. " Event</legend>";
            echo "<b>Location: </b>". $loc."<br>";
            echo "<b>Date: </b>". $date."<br>";
            echo "</fieldset >";
            echo "<br>";echo "<br>";
        ?>
        <?php
            $visitor_id = $_SESSION['visitor_id'];
            $org_id = $_GET['varJS'];
            echo "<fieldset >";
            echo "<legend>Comments</legend>";
            echo "<br>";echo "<br>";
            $query = "SELECT text, date, user_id FROM Comments WHERE event_id = '$org_id'";
            $result = mysqli_query($conn,$query);
            if ($result->num_rows  > 0){
                while ($row = $result->fetch_assoc()){
                    $com_text = $row['text'];
                    $com_date = $row['date'];
                    $user_id = $row['user_id'];
                    $query1 = "SELECT name FROM Users WHERE user_id = '$user_id'";
                    $result1 = mysqli_query($conn,$query1);
                    $row1 = mysqli_fetch_assoc($result1);
                    $vis_name = $row1['name'];
                    echo "<fieldset >";
                    echo "<legend>". $vis_name."'s Comment</legend>";
                    echo "<b>Comment: </b>". $com_text."<br>";
                    echo "<b>Date: </b>". $com_date."<br>";
                    echo "</fieldset >";
                    echo "<br>";

                }
            }
            else{
                  echo "-------------------------NO Comment-----------------------------";
                  echo "<br>";echo "<br>";
            }
            echo "</fieldset >";
        ?>
        <?php
            $visitor_id = $_SESSION['visitor_id'];
            $org_id = $_GET['varJS'];
            if($_POST['submit']){
                $complaint = mysqli_real_escape_string($conn, $_POST['textarea']);
                $com_size = strlen($complaint);
                $date = date("Y-m-d");
                if (($com_size > 0) && ($com_size < 200)){
                    $com_id = mt_rand();
                    $date = date("Y-m-d");
                    $query = "INSERT INTO Comments
                              VALUES ('$com_id', '$complaint', '$date', '$org_id', '$visitor_id')";
                    $result = mysqli_query($conn,$query);
                    echo "<script>";
                    echo "window.location.href = 'GroupTour.php'";

                    echo "</script>";
                }
                else {
                    echo "alert('Too much words for Comment');";
                }
            }

        ?>

    </body>
    <style>
        .box{
            border: 1px solid #aaa; /*getting border*/
            border-radius: 4px; /*rounded border*/
            color: #000; /*text color*/
        }
    </style>
    <script>
    function comment(a) {
        var page='Comment.php?varJS='+a;
        document.location.href= page;
    }
    </script>
</html>