<?php
session_start();

$productid = $_GET['id'];

if (empty($_GET['id']) || empty($_COOKIE['Email'])) {
	header('location:home.php');
} else {
	$Email = $_COOKIE['Email'];
	$VendedorEmail = $_SESSION['add-application-Vendedor-Email'];

	$servername = "localhost";
	$username = "root";
	$Senha = "";
	$dbname = "DB-EcoStore";

	// Create connection
	$conn = mysqli_connect($servername, $username, $Senha, $dbname);

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully" . "<br>";
	
	$s = "SELECT * FROM Produto WHERE CodProduto = '$CodProduto' && Email = '$Email'";
	$result = mysqli_query($conn, $s);
			
	if (mysqli_num_rows($result) == 0) {
	
		$sql = "INSERT INTO Produto (CodProduto, Email)
		VALUES ('$productid', '$Email')";

		if (mysqli_query($conn, $sql)) {
		  echo "New record created successfully" . "<br>";
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	
	}

	//Close the connection
	mysqli_close($conn);
	header('location:applications.php');
}
?>
