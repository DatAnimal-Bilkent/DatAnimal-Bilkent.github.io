<?php
session_start();
#$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
$userid = $_POST['userid'];
session_start();

$pass     = $_POST['password'];
session_start();

$email = $_POST['email'];
session_start();

$phoneno     = $_POST['phoneno'];
session_start();

$birthyear = $_POST['birthyear'];
session_start();

$name     = $_POST['name'];
session_start();

$address     = $_POST['address'];
session_start();

$gender     = $_POST['gender'];
session_start();

$section     = $_POST['section'];
session_start();

$facilityid     = $_POST['facilityid'];

$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
$query = "SELECT * FROM Users WHERE user_id='$userid'";
$result = mysqli_query($con, $query);
$numCoordinators = mysqli_num_rows($result);
mysqli_close($con);
if ($numCoordinators > 0)
	{
        header("Location: registerError.php");
        exit();
	}else{
    $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
    $query = "insert into Users( user_id, password, email, phone_no, birth_year, name, address, gender) values('$userid', '$pass', '$email', '$phoneno', '$birthyear', '$name', '$address', '$gender');";
    $result = mysqli_query($con, $query);
    mysqli_close($con);
    $con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
    $query = "SET FOREIGN_KEY_CHECKS=0;";
    $result = mysqli_query($con, $query);
    $query = "insert into Facility_Worker( user_id, speciality, facility_id) values('$userid', '$section','$facilityid');";
    $result = mysqli_query($con, $query);
    mysqli_close($con);
    header("Location: registerSuccesfull.php");
    exit();
    }
?>
