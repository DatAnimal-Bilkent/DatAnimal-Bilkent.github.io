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
    <?php echo "<a href = 'VisitorHomePage.php'>Home Page </a>"?>
    <?php echo "<br>";echo "<br>";?>
    <head>
        <title>Complaint</title>
    </head>
    <body>
        <?php

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $var = mysqli_real_escape_string($conn, $_POST['textarea']);
                echo $var;
            }
        ?>
        <form action ="" method="post">
            <textarea name="textarea" rows="10" cols="30" class="box" placeholder="We will be happy to hear from you."></textarea>
            <?php echo "<br>"; echo "<br>"; ?>
            <input type="submit" value="Comment" />
        </form>
    </body>
    <style>
        .box{
            border: 1px solid #aaa; /*getting border*/
            border-radius: 4px; /*rounded border*/
            color: #000; /*text color*/
        }
    </style>
</html>