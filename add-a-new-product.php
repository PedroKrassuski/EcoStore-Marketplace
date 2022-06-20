<?php
session_start();

if (empty($_POST['Nome-Produto'] || $_POST['Descricao'] || $_POST['Foto']|| $_POST['Valor-Uni'] | $_POST['Validade'] |)) {
	header('location:Vendedor-dashboard.php');
} else {
	$Email = $_COOKIE['Email'];
	
	$NomeProduto = $_POST['Nome-Produto'];
	$Foto = $_POST['Foto'];
	$Descricao = $_POST['Descricao'];
	$ValorUni = $_POST['Valor-Uni'];
	%Validade = $_POST['Validade'];

	
	$productcategory = $_POST['product-category'];

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
	
	$sql = "INSERT INTO Produto (name, Foto, description, details, link, price, discountedprice, category, VendedorEmail)
	VALUES ('$NomeProduto', '$Foto', '$Descricao', '$productdetails', '$producturl', '$ValorUni', '$productdiscountedprice', '$productcategory', '$Email'.'$')";

	if (mysqli_query($conn, $sql)) {
	  echo "New record created successfully" . "<br>";
	} else {
	  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	//Close the connection
	mysqli_close($conn);
	
	header('location:Vendedor-dashboard.php');
}
?>
