<?php
session_start();
$uid = $_SESSION['username'];
?>

<?php
$conn = new mysqli("dijkstra.cs.bilkent.edu.tr:3306", "mert.duran", "mkyRf3AL", "mert_duran");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$cd = $_GET['cid'];
$query = "DELETE FROM Assigns_Cage WHERE cage_id=$cd";
$result2 = mysqli_query($conn, $query);
//header("Location: studentmain.php");
echo "<script>alert('Removed Assignment Succesfully'); window.location.href='cages.php';</script>";
?>