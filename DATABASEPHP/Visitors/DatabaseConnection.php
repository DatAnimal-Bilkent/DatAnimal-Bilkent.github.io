<?php

	// Create connection
	//$conn = mysqli_connect('dijkstra.ug.bcc.bilkent.edu.tr', 'radman.lotfiazar', 'N0xKHW4y', 'radman_lotfiazar');
   $conn = mysqli_connect("dijkstra.ug.bcc.bilkent.edu.tr","mert.duran","mkyRf3AL","mert_duran");
	// Check connection
	if ($conn->connect_error) {
		//this is for error that connection does not connected
		die("Connection failed: " . $conn->connect_error);
	} 
	else{
		//this is for successful connection
		//echo "<br>";
		//echo "Database Connected";
	}
?>
