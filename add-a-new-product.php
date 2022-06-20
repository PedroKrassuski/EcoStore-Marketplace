<?php
session_start();

if (empty($_POST['Nome-Produto'] || $_POST['Descricao'] || $_POST['Foto'] || $_POST['Validade'] || $_POST['Valor-Uni'])) {
	header('location:seller-dashboard.php');
} else {
	$email = $_COOKIE['seller-email'];
	
	$NomeProduto = $_POST['Nome-Produto'];
	$Foto = $_POST['Foto'];
	$Descricao = $_POST['Descricao'];
	$ValorUni = $_POST['Valor-Uni'];
	%Validade = $_POST['Validade'];

	
	$productcategory = $_POST['product-category'];

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "DB-EcoStore";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully" . "<br>";
	
	$sql = "INSERT INTO products (name, Foto, description, details, link, price, discountedprice, category, selleremail)
	VALUES ('$NomeProduto', '$Foto', '$Descricao', '$productdetails', '$producturl', '$ValorUni', '$productdiscountedprice', '$productcategory', '$email')";

	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully" . "<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	//Close the connection
	mysqli_close($conn);
	
	header('location:seller-dashboard.php');
}
?>
