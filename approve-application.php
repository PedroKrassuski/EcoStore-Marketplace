<?php
session_start();

$productid = $_POST['productid'];

if (empty($_POST['productid']) || empty($_COOKIE['Vendedor-Email'])) {
	header('location:Vendedor-applications.php');
} else {
	$Email = $_COOKIE['Vendedor-Email'];
	$buyerEmail = $_SESSION['buyer-Email'];

	$servername = "localhost";
	$username = "root";
	$Senha = "Senha";
	$dbname = "DB-Ecostore";

	// Create connection
	$conn = mysqli_connect($servername, $username, $Senha, $dbname);

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully" . "<br>";
	
	$s = "SELECT * FROM Produto WHERE CodProduto = '$CodProduto' && Email = '$Email';
	$result = mysqli_query($conn, $s);
			
	//Close the connection
	mysqli_close($conn);
	header('location:Vendedor-applications.php');
}
?>
