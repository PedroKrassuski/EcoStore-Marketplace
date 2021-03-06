<?php
session_start(); 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>DB-EcoStore - Vendedor Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<style>
		  .bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		  }

		  @media (min-width: 768px) {
			.bd-placeholder-img-lg {
			  font-size: 3.5rem;
			}
		  }
		  
		  .modal {
			  display: none; /* Hidden by default */
			  position: fixed; /* Stay in place */
			  z-index: 1; /* Sit on top */
			  left: 0;
			  top: 0;
			  width: 100%; /* Full width */
			  height: 100%; /* Full height */
			  overflow: auto; /* Enable scroll if needed */
			  background-color: rgb(0,0,0); /* Fallback color */
			  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
			}

			/* Modal Content/Box */
			.modal-content {
			  background-color: #fefefe;
			  margin: 15% auto; /* 15% from the top and centered */
			  padding: 20px;
			  border: 1px solid #888;
			  width: 80%; /* Could be more or less, depending on screen size */
			}

			/* The Close Button */
			.close {
			  color: #aaa;
			  float: right;
			  font-size: 28px;
			  font-weight: bold;
			}

			.close:hover,
			.close:focus {
			  color: black;
			  text-decoration: none;
			  cursor: pointer;
			}
		</style>
	</head>
	<body>
	
	<?php
		if (!isset($_COOKIE['Vendedor-Email'])) {
			header('location:Vendedor-home.php');
		}
	?>
	
	<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$EmailErr = $SenhaErr = $paypalErr = $websiteErr = "";
			$Email = $Senha = $paypalusername = "";
			
			$website = $_POST['website'];
			$website = filter_var($website, FILTER_SANITIZE_URL);
			
			if (filter_var($website, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
				echo("$website is a valid URL");
			} else {
				$websiteErr = "Invalid URL";
			}
			
			if (empty($_POST["Email"])) {
				$EmailErr = "Email is required";
			  } else {
				$Email = test_input($_POST["Email"]);
				// check if e-mail address is well-formed
				if (!filter_var($Email, FILTER_VALIDATE_Email)) {
				  $EmailErr = "Invalid Email format";
				}
			  }
			
			if (empty($_POST["Senha"])) {
				$SenhaErr = "Senha is required";
			} else {
				$Senha = test_input($_POST["Senha"]);
			}
			
			$paypalusername = test_input($_POST["paypalusername"]);
			
			if ($EmailErr == "" && $SenhaErr == "" && $websiteErr == "") {
			
				$currentEmail = $_COOKIE['Vendedor-Email'];
				//$Email = $_POST['Email'];
				//$Senha = $_POST['Senha'];
				//$paypalusername = $_POST['paypalusername'];
				
				// Create connection
				$conn = mysqli_connect("localhost", "root", "Senha", "DB-EcoStore");
				// Check connection
				if (!$conn) {
				  die("Connection failed: " . mysqli_connect_error());
				}

				$sql = "UPDATE Vendedors SET Email='$Email', Senha='$Senha', website='$website', paypalusername='$paypalusername' WHERE Email='$currentEmail'";

				if (mysqli_query($conn, $sql)) {
				  echo "Account details updated successfully";
				} else {
				  echo "Error updating record: " . mysqli_error($conn);
				}

				mysqli_close($conn);
			}
		}
		
		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
	?>
	
	<?php
		if (isset($_COOKIE['Vendedor-Email'])) {
			$Email = $_COOKIE['Vendedor-Email'];
			
			$db = new PDO("mysql:host=localhost;dbname=DB-EcoStore","root","Senha");

			$articlesor = $db->prepare("SELECT * FROM Vendedors WHERE Email=:Email");
			$articlesor->execute(array(
				'Email' => $Email
			));
				  
			while($articlecek=$articlesor->fetch(PDO::FETCH_ASSOC)) {
		
	?>
	
	<!-- The Modal -->
	<div id="myModal" class="modal">

	  <!-- Modal content -->
	  <div class="modal-content">
		<span class="close">&times;</span>
		
		  <div class="card-body">
			<h1>Edit Your Account Details</h1>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="p-4 p-md-5 border rounded-3 bg-light">
			  <div class="form-floating mb-3">
				<input type="Email" name="Email" value="<?php echo $articlecek['Email'];?>" class="form-control" id="floatingInput" placeholder="name@example.com">
				<label for="floatingInput">Email address</label>
				<span style="color:red;"><?php echo $EmailErr;?></span>
			  </div>
			  <div class="form-floating mb-3">
				<input type="Senha" name="Senha" value="<?php echo $articlecek['Senha'];?>" class="form-control" id="floatingSenha" placeholder="Senha">
				<label for="floatingSenha">Senha</label>
				<span style="color:red;"><?php echo $SenhaErr;?></span>
			  </div>
			  <div class="form-floating mb-3">
				<input type="text" name="website" value="<?php echo $articlecek['website'];?>" class="form-control" id="floatingInput" placeholder="Website">
				<label for="floatingInput">Website</label>
				<span style="color:red;"><?php echo $websiteErr;?></span>
			  </div>
			  <div class="form-floating mb-3">
				<input type="text" name="paypalusername" value="<?php echo $articlecek['paypalusername'];?>" class="form-control" id="floatingInput" placeholder="PayPal Username">
				<label for="floatingSenha">PayPal Username</label>
				<span style="color:red;"><?php echo $paypalErr;?></span>
			  </div>
			  <div class="form-floating mb-3 input-group">
				<input type="text" disabled name="Emailverified" value="<?php echo $articlecek['Emailverified'];?>" class="form-control" id="floatingInput" placeholder="Email Verified">
				<label for="floatingSenha">Email Verified</label>
				<?php
					if ($articlecek['Emailverified'] == "false") {
				?>
				<button class="btn btn-outline-secondary">Verify Email</button><br>
				<?php } ?>
			  </div>
			  <span style="color:red;"><?php echo $EmailVerifiedErr;?></span>
			  <button class="w-100 btn btn-lg btn-primary" type="submit">Save Changes</button>
			</form>
			
		  </div>
		
	  </div>
	</div>
	
	<?php
			}
		}
	?>
	
	<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="Vendedor-dashboard.php" class="nav-link px-2 link-secondary">Vendedor Dashboard</a></li>
        </ul>
		
		<?php
			if (isset($_COOKIE['Vendedor-Email'])) {
		?>

        <div class="dropdown">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			<?php echo $_COOKIE['Vendedor-Email']; ?>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" onclick="deleteCookie();">Log Out</a></li>
			<li><a class="dropdown-item" id="showModal">Edit Account Details</a></li>
			<li><a class="dropdown-item" href="Vendedor-applications.php">Product Applications</a></li>
			<li><a class="dropdown-item" href="#">Payments</a></li>
		  </ul>
		</div>

		<?php } ?>

      </div>
    </div>
  </header>
	
<!-- 
row py-lg-5
col-lg-6 col-md-8 mx-auto
p-4 p-md-5 border rounded-3 bg-light
 -->
	
	<main>
	  <section class="py-5 text-center container">
		<div class="">
		  <div class="">
		  
			<h1 class="fw-light">Add A New Product</h1>
			<br>
			
			<form method="post" action="add-a-new-product.php" class="">
			
			  <div class="form-floating mb-3">
				<input type="text" name="Nome-Produto" value="" class="form-control" id="floatingInput" placeholder="Product Name">
				<label for="floatingInput">Product Name</label>
			  </div>
			  
			  <div class="form-floating mb-3">
				<input type="url" name="Foto" value="" class="form-control" id="floatingInput" placeholder="Image URL">
				<label for="floatingPInput">Image URL</label>
				<span style="color:red;"><?php echo $FotoErr;?></span>
			  </div>
			  
			  <div class="form-floating mb-3">
				<input type="text" name="Descricao" value="" class="form-control" id="floatingInput" placeholder="Short Description">
				<label for="floatingInput">Short Description</label>
			  </div>
			  
			  <div class="form-floating mb-3">
				<!--<input type="text" name="product-details" value="" class="form-control" id="floatingInput" placeholder="Long Description (Include Details)">-->
				<textarea rows="5" name="product-details" class="form-control" id="floatingInput" placeholder="Long Description (Include Details)"></textarea>
				<label for="floatingInput">Long Description (Include Details)</label>
			  </div>
			  
			  <div class="form-floating mb-3">
				<input type="url" name="product-url" value="" class="form-control" id="floatingInput" placeholder="Product URL">
				<label for="floatingPInput">Product URL</label>
				<span style="color:red;"><?php echo $productURLErr;?></span>
			  </div>
			  
			  <div class="form-floating mb-3">
				<input step="0.01" type="number" name="Valor-Uni" value="" class="form-control" id="floatingInput" placeholder="Product Normal Price">
				<label for="floatingInput">Product Normal Price</label>
			  </div>
			  
			  <div class="form-floating mb-3">
				<input step="0.01" type="number" name="product-discounted-price" value="" class="form-control" id="floatingInput" placeholder="Product Discounted Price">
				<label for="floatingInput">Product Discounted Price</label>
			  </div>
			  
			  <select name="product-category" class="form-select" aria-label="Choose a category">
				  <option value="all categories" selected>All Categories</option>
				  <option value="electronics">Electronics</option>
				  <option value="toys">Toys</option>
				  <option value="clothing">Clothing</option>
				  <option value="beauty">Makeup & Beauty</option>
				</select><br>
			  
			  <button class="w-100 btn btn-lg btn-primary" type="submit">Add Product</button>
			</form>
			
		  </div>
		</div>
	  </section>

	  <div class="album py-5 bg-light">
		<div class="container">
		<h2 style="text-align:center;">My Products</h2>
		  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
		  
		  <?php
			$db = new PDO("mysql:host=localhost;dbname=DB-EcoStore","root","Senha");
			
			$VendedorEmail = $_COOKIE['Vendedor-Email'];

			$articlesor = $db->prepare("SELECT * FROM products WHERE VendedorEmail=:VendedorEmail");
			$articlesor->execute(array(
				'VendedorEmail' => $VendedorEmail
			));
				  
			while($articlecek=$articlesor->fetch(PDO::FETCH_ASSOC)) {
		  ?>
		  
			<div class="col">
			  <div class="card shadow-sm">
				<img style="max-height:300px;" src="<?php echo $articlecek['Foto'] ?>">
				<div class="card-body">
				  <h3><?php echo $articlecek['name'] ?></h3>
				  <p class="card-text"><?php echo $articlecek['description'] ?></p>
				  <p style="color:green;">??<?php echo $articlecek['discountedprice'] ?></p>
				  <strike style="color:red;">??<?php echo $articlecek['price'] ?></strike>
				  <div class="d-flex justify-content-between align-items-center">
					<div class="btn-group">
					  <form method="POST" action="edit-product.php">
						<input type="hidden" name="productid" value="<?php echo $articlecek['id'] ?>">
						<button type="submit" class="btn btn-primary">Edit Product Details</button>
					  </form>
					  <form method="POST" action="delete-product.php">
					    <input type="hidden" name="productid" value="<?php echo $articlecek['id'] ?>">
						<button type="submit" class="btn btn-danger">Delete Product</button>
					  </form>
					</div>
				  </div>
				</div>
			  </div>
			</div>
			
			<?php } ?>
			
		  </div>
		</div>
	  </div>
	</main>
	
	<script>
		function deleteCookie() {
			document.cookie = "Vendedor-Email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "Vendedor-Senha=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			location.reload();
		}
		
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("showModal");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on the button, open the modal
		btn.onclick = function() {
		  modal.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		  modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
		  if (event.target == modal) {
			modal.style.display = "none";
		  }
		}
	</script>
	
	</body>
</html>
