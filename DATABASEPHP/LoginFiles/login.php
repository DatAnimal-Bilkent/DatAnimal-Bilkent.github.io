<?php
session_start();
$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
$username = $_POST['username'];
$pass     = $_POST['password'];
$query = "SELECT * FROM Users WHERE user_id='$username' and password='$pass'";
$result = mysqli_query($con, $query);
mysqli_close($con);

$num = mysqli_num_rows($result);
$_SESSION['username'] = $username;
session_start();
$_SESSION['password'] = $pass;
if ($num > 0)
{
	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Coordinators WHERE user_id='$username'";
	$result = mysqli_query($con, $query);
	$numCoordinators = mysqli_num_rows($result);
	mysqli_close($con);

	if ($numCoordinators > 0)
	{
		header("Location: ../Coordinator/CoordinatorMain.php");
		mysqli_close($con);
		exit();
	}

	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Visitors WHERE user_id='$username'";
	$result = mysqli_query($con, $query);
	$numVisitors = mysqli_num_rows($result);
	mysqli_close($con);

	if ($numVisitors > 0)
	{
		header("Location: ../Visitors/VisitorHomePage.php");
		mysqli_close($con);
		exit();
	}

	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Keepers WHERE user_id='$username'";
	$result = mysqli_query($con, $query);
	$numKeepers = mysqli_num_rows($result);
	mysqli_close($con);

	if ($numKeepers > 0)
	{
		header("Location: ../Keeper/keeper.php");
		mysqli_close($con);
		exit();
	}

	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Veterinarians WHERE user_id='$username'";
	$result = mysqli_query($con, $query);
	$numVet = mysqli_num_rows($result);
	mysqli_close($con);

	if ($numVet > 0)
	{
		header("Location: ../Veterinarians/veterinarian.php");
		mysqli_close($con);
		exit();
	}
	$con = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	$query = "SELECT * FROM Facility_Worker WHERE user_id='$username'";
	$result = mysqli_query($con, $query);
	$numFac = mysqli_num_rows($result);
	mysqli_close($con);

	if ($numFac > 0)
	{
		header("Location: ../FacilityWorker/facilityworker.php");
		mysqli_close($con);
		exit();
	}
}
else
{
	echo "<a href='../index.php'>PRESS HERE TO TRY AGAIN!</a>";
	echo "<br><br/>";
	echo "Username and password didnt match.!";
}

?>
