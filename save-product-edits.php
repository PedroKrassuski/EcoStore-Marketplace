<?php
			if (empty($_POST['Nome-Produto'] || $_POST['Descricao'] || $_POST['product-details'] || $_POST['product-url'] || $_POST['Valor-Uni'] || $_POST['product-discounted-price'])) {
				header('location:edit-product.php');
			} else {
			
			$nameErr = $descriptionErr = $FotoErr = $productURLErr = "";
			$NomeProduto = $Descricao = $productdetails = $ValorUni = $productdiscountedprice = "";
			
			$Foto = $_POST['Foto'];
			$productURL = $_POST['product-url'];
			$productcategory = $_POST['product-category'];
			$productid = $_POST['product-id'];
			
			if (!filter_var($Foto, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
				$FotoErr = "Invalid URL";
			}
			
			if (!filter_var($productURL, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
				$productURLErr = "Invalid URL";
			}
			
			$NomeProduto = test_input($_POST["Nome-Produto"]);
			$Descricao = test_input($_POST["Descricao"]);
			$productdetails = test_input($_POST["product-details"]);
			$ValorUni = test_input($_POST["Valor-Uni"]);
			$productdiscountedprice = test_input($_POST["product-discounted-price"]);
			
			if ($FotoErr == "" && $productURLErr == "") {
			
				$currentemail = $_COOKIE['seller-email'];
				
				// Create connection
				$conn = mysqli_connect("localhost", "root", "PASSWORD", "fullcashback");
				// Check connection
				if (!$conn) {
				  die("Connection failed: " . mysqli_connect_error());
				}

				$sql = "UPDATE products SET name='$NomeProduto', Foto='$Foto', description='$Descricao', details='$productdetails', link='$productURL', price='$ValorUni', discountedprice='$productdiscountedprice', category='$productcategory' WHERE id='$productid'";

				if (mysqli_query($conn, $sql)) {
				  echo "Product details updated successfully";
				} else {
				  echo "Error updating record: " . mysqli_error($conn);
				}

				mysqli_close($conn);
				header('location:seller-dashboard.php');
			}
		}
		
		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
?>
