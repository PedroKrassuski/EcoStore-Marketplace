<?php
session_start(); 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>DB-EcoStore Product - Get Full Cashback!</title>
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
		if ($_SERVER["Produto"] == "POST") {
			
			$EmailErr = $SenhaErr = $paypalErr = "";
			$Email = $Senha = $paypalusername = "";
			
			if (empty($_POST["Email"])) {
				$EmailErr = "Email is required";
			  } else {
				$Email = test_input($_POST["Email"]);
				// check if e-mail address is well-formed
				if (!filter_var($Email)) {
				  $EmailErr = "Invalid Email format";
				}
			  }
			
			if (empty($_POST["Senha"])) {
				$SenhaErr = "Senha is required";
			} else {
				$Senha = test_input($_POST["Senha"]);
			}
			
			
			if ($EmailErr == "" && $SenhaErr == "") {
			
				$currentEmail = $_COOKIE['Email'];
				//$Email = $_POST['Email'];
				//$Senha = $_POST['Senha'];
				//$paypalusername = $_POST['paypalusername'];
				
				// Create connection
				$conn = mysqli_connect("localhost", "root", "", "DB-EcoStore");
				// Check connection
				if (!$conn) {
				  die("Connection failed: " . mysqli_connect_error());
				}

				$sql = "UPDATE Usuario SET Email='$Email', Senha='$Senha' WHERE Email='$currentEmail'";

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
		if (isset($_COOKIE['Email'])) {
			$Email = $_COOKIE['Email'];
			
			$db = new PDO("mysql:host=localhost;dbname=db-ecostore","root","");

			$articlesor = $db->prepare("SELECT * FROM Usuario WHERE Email=:Email");
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
				<a href="send-Email.php?Email=<?php echo $articlecek['Email'] ?>"><button class="btn btn-outline-secondary">Verify Email</button></a><br>
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
          <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="home.php" class="nav-link px-2 link-dark">Products</a></li>
        </ul>

		<form method="GET" action="search.php" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input name="name" type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
		
		<?php
			if (isset($_COOKIE['Email'])) {
		?>

        <div class="dropdown">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			<?php echo $_COOKIE['Email']; ?>
		  </button>
		  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			<li><a class="dropdown-item" onclick="deleteCookie();">Log Out</a></li>
			<li><a class="dropdown-item" id="showModal">Edit Account Details</a></li>
			<li><a class="dropdown-item" href="applications.php">Product Applications</a></li>
			<li><a class="dropdown-item" href="payments.php">Payments</a></li>
		  </ul>
		</div>

		<?php } ?>

      </div>
    </div>
  </header>

	<main>
	  <div class="album py-5 bg-light">
		<div class="container">
		  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
		  
		  <?php
			$productid = $_GET['id'];
		  
			//$db = new PDO("mysql:host=localhost;dbname=DB-EcoStore","root","Senha");

			//$articlesor = $db->prepare("SELECT * FROM products WHERE name LIKE '% + name + %'");
			//$articlesor->execute(array(
				//'name' => $NomeProduto
			//));
				  
			//while($articlecek=$articlesor->fetch(PDO::FETCH_ASSOC)) {
				
			$servername = "localhost";
			$username = "root";
			$Senha = "";
			$dbname = "DB-EcoStore";

			// Create connection
			$conn = new mysqli($servername, $username, $Senha, $dbname);
			// Check connection
			if ($conn->connect_error) {
			  die("Connection failed: " . $conn->connect_error);
			}

			$sql = "SELECT * FROM Produto WHERE id='$CodProduto'";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			  // output data of each row
			  while($row = $result->fetch_assoc()) {
		  ?>
		  
			<div class="container col-xxl-8 px-4 py-5">
				<div class="row flex-lg-row align-items-center g-5 py-5">
				  <div class="col-10 col-sm-8 col-lg-6">
					<img src="<?php echo $row['Foto'] ?>" class="d-block mx-lg-auto img-fluid" alt="<?php echo $row['name'] ?>" width="700" height="500" loading="lazy">
				  </div>
				  <?php $_SESSION['add-application-Vendedor-Email'] = $row['VendedorEmail']; ?>
				  <div class="col-lg-6">
					<h1 class="display-5 fw-bold lh-1 mb-3"><?php echo $row['name'] ?></h1>
					<p class="lead"><?php echo $row['description'] ?></p>
					<p style="color:green;">£<?php echo $row['discountedprice'] ?></p>
				    <strike style="color:red;">£<?php echo $row['price'] ?></strike>
					<div class="d-grid gap-2 d-md-flex justify-content-md-start">
					  <a href="add-application.php?id=<?php echo $row['id'] ?>"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Apply Now</button></a>
					</div>
				  </div>
				</div>
				<p><?php echo $row['details'] ?></p>
			  </div>
			
			<?php //}
			}
			} else {
			  echo "No results";
			}
			$conn->close();
			?>
			
		  </div>
		</div>
	  </div>
	</main>
	
	<script>
		function deleteCookie() {
			document.cookie = "Email=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			document.cookie = "Senha=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
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
