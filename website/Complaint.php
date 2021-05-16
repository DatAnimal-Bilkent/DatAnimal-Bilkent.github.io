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
    <?php ob_end_clean(); ?>
    <a href = "Logout.php">Logout </a>
    <br><br>
    <?php echo "<a href = 'VisitorHomePage.php'>Home Page </a>"?>
    <?php echo "<br>";echo "<br>";?>
    <head>
        <title>Complaint</title>
    </head>
    <body>
        <form action ="" method="post">
            <input type="text" name="Topic" placeholder="Topic"><br />
            <textarea name="textarea" rows="10" cols="50" class="box" placeholder="We will be happy to hear from you."></textarea>
            <?php echo "<br>"; echo "<br>"; ?>
            <input type="submit" name= "submit" value="Complaint"
            onclick="return confirm('Are you sure ?')" />
        </form>
        <?php
            $visitor_id = $_SESSION['visitor_id'];
            echo "<fieldset >";
            echo "<legend>Complaints and Answers</legend>";
            echo "<br>";echo "<br>";
            $query = "SELECT* FROM Complaint_Form";
            $result = mysqli_query($conn,$query);
            if ($result->num_rows  > 0){
                while ($row = $result->fetch_assoc()){
                    $com_id = $row['complaint_id'];
                    $com_topic = $row['topic'];
                    $com_text = $row['text'];
                    $com_date = $row['complaint_date'];
                    $user_id = $row['user_id'];
                    $query1 = "SELECT name FROM Users WHERE user_id = '$user_id'";
                    $result1 = mysqli_query($conn,$query1);
                    $row1 = mysqli_fetch_assoc($result1);
                    $vis_name = $row1['name'];
                    $query1 = "SELECT user_id, respond_note, respond_date
                                FROM Respond_complaint
                                WHERE complaint_id = '$com_id'";
                    $result1 = mysqli_query($conn,$query1);
                    $row1 = mysqli_fetch_assoc($result1);
                    if($row1 > 0){
                            echo "<fieldset >";
                            echo "<legend>". $vis_name."'s Complaint</legend>";
                            echo "<b>Topic: </b>". $com_topic."<br>";
                            echo "<b>Complaint: </b>". $com_text."<br>";
                            echo "<b>Date: </b>". $com_date."<br>";
                            echo "<br>";
                            $user_id = $row1['user_id'];
                            $res_text = $row1['respond_note'];
                            $res_date = $row1['respond_date'];
                            $query1 = "SELECT name FROM Users WHERE user_id = '$user_id'";
                            $result1 = mysqli_query($conn,$query1);
                            $row1 = mysqli_fetch_assoc($result1);
                            echo "<fieldset >";
                            echo "<legend> Coordinator ". $row1['name'] ."'s Respond</legend>";
                            echo "<b>Respond: </b>". $res_text."<br>";
                            echo "<b>Date: </b>". $res_date."<br>";
                            echo "</fieldset >";
                            echo "</fieldset >";
                            echo "<br>";
                    }
                    else{
                        echo "<fieldset >";
                        echo "<legend>". $vis_name."'s Complaint</legend>";
                        echo "<b>User Name: </b>". $vis_name."<br>";
                        echo "<b>Topic: </b>". $com_topic."<br>";
                        echo "<b>Complaint: </b>". $com_text."<br>";
                        echo "<b>Date: </b>". $com_date."<br>";
                        echo "<br>";
                        echo "<fieldset >";
                        echo "<legend>No Answer</legend>";
                        echo "</fieldset >";
                        echo "</fieldset >";
                        echo "<br>";
                    }
                }

            }
            else{
                  echo "-------------------------NO Complaint-----------------------------";
                  echo "<br>";echo "<br>";
            }
            echo "</fieldset >";
        ?>
        <?php
            //if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST['submit']){
                $complaint = mysqli_real_escape_string($conn, $_POST['textarea']);
                $topic = mysqli_real_escape_string($conn, $_POST['Topic']);
                $com_size = strlen($complaint);
                $topic_size = strlen($topic);
                $date = date("Y-m-d");
                if (($com_size > 0 && $topic_size > 0) && ($com_size < 200 && $topic_size < 20)){
                    $com_id = mt_rand();
                    $date = date("Y-m-d");
                    $query = "INSERT INTO Complaint_Form
                              VALUES ('$com_id', '$topic', '$complaint', '$date', '$visitor_id')";
                    $result = mysqli_query($conn,$query);
                    echo "<script>";
                    echo "window.location.href = 'Complaint.php'";
                    echo "</script>";
                }
                else {
                    echo "alert('Too much words for Complaint or topic');";
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
</html>