<?php
session_start(); 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>DB-EcoStore - Get Up To 100% Cashback on Amazon Products!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	</head>
	<body>
	
	<?php
		// define variables and set to empty values
		$nameErr = $EmailErr = $SenhaErr = $paypalErr = "";
		$name = $Email = $Senha = $paypalusername = "";

		if ($_SERVER["Usuario"] == "POST") {
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
			$servername = "localhost";
			$username = "root";
			$serverSenha = "";
			$dbname = "DB-EcoStore";

			// Create connection
			$conn = mysqli_connect($servername, $username, $serverSenha, $dbname);

			// Check connection
			if (!$conn) {
			  die("Connection failed: " . mysqli_connect_error());
			}
			
			$s = "SELECT * FROM Usuario WHERE Email = '$Email'";
			$result = mysqli_query($conn, $s);
			
			if (mysqli_num_rows($result) > 0) {
				$EmailErr = "An account with that Email address is already created. Please use a different Email address.";
			} else {
				$_SESSION['Email'] = $Email;
				$_SESSION['Senha'] = $Senha;
				header('location:registration.php');
				mysqli_close($conn);
			}
		  }
		}

		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}
	?>
	
	<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
          <li><a href="#how-it-works" class="nav-link px-2 text-white">How It Works</a></li>
          <li><a href="home.php" class="nav-link px-2 text-white">Products</a></li>
        </ul>

        <div class="text-end">
		  <a href="Vendedor-home.php"><button type="button" class="btn btn-outline-light me-2">Vendedor Dashboard</button></a>
          <a href="login.php"><button type="button" class="btn btn-primary">Login</button></a>
        </div>
      </div>
    </div>
  </header>
  
  
	</body>
</html>
