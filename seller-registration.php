<?php
session_start();

if (empty($_SESSION['Email'])) {
	header('location:Vendedor-home.php');
} else {
	$Email = $_SESSION['Email'];
	$userSenha = $_SESSION['Senha'];

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
	
	$sql = "INSERT INTO Vendedors (Email, Senha)
	VALUES ('$Email', '$Senha')";

	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully" . "<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	//Close the connection
	mysqli_close($conn);
	
	setcookie("Email", $_SESSION['Email'], time() + (86400 * 30), "/");
	setcookie("Senha", $_SESSION['Senha'], time() + (86400 * 30), "/");
	
	header('location:Vendedor-dashboard.php');
}
?>
