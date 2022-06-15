<?php
session_start();

if (empty($_POST['Nome-Produto'] || $_POST['product-description'] || $_POST['product-details'] || $_POST['product-url'] || $_POST['product-price'] || $_POST['product-discounted-price'])) {
	header('location:seller-dashboard.php');
} else {
	$email = $_COOKIE['seller-email'];
	
	$NomeProduto = $_POST['Nome-Produto'];
	$imageurl = $_POST['image-url'];
	$productdescription = $_POST['product-description'];
	$productdetails = $_POST['product-details'];
	$producturl = $_POST['product-url'];
	$productprice = $_POST['product-price'];
	$productdiscountedprice = $_POST['product-discounted-price'];
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
	
	$sql = "INSERT INTO products (name, imageurl, description, details, link, price, discountedprice, category, selleremail)
	VALUES ('$NomeProduto', '$imageurl', '$productdescription', '$productdetails', '$producturl', '$productprice', '$productdiscountedprice', '$productcategory', '$email')";

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
