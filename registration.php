<?php
session_start();

if (empty($_SESSION['Email'])) {
	header('location:index.php');
} else {
	$Email = $_SESSION['Email'];
	$Senha = $_SESSION['Senha'];

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
	
	$sql = "INSERT INTO users (Email, Senha)
	VALUES ('$Email', '$userSenha')";

	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully" . "<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	//Close the connection
	mysqli_close($conn);
	
	setcookie("Email", $_SESSION['Email'], time() + (86400 * 30), "/");
	setcookie("Senha", $_SESSION['Senha'], time() + (86400 * 30), "/");
	
	//session_destroy();
	
	//session_start();
	//$_SESSION['loggedinEmail'] = $Email;
	//echo $_SESSION['loggedinEmail'];
	header('location:home.php');
}
?>
