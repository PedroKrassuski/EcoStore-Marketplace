<!--
Vendedor Dashboard with a form to register and a How It Works section for Vendedors. A Vendedor login page is on a different page.
-->
<?php
session_start(); 
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>DB-EcoStore - Get More Customers on Amazon!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	</head>
	<body>
	
	<?php
		// define variables and set to empty values
		$EmailErr = $SenhaErr = "";
		$Email = $Senha = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
			
			$s = "SELECT * FROM Vendedor WHERE Email = '$Email'";
			$result = mysqli_query($conn, $s);
			
			if (mysqli_num_rows($result) > 0) {
				$EmailErr = "A Vendedor account with that Email address is already created. Please use a different Email address.";
			} else {
				$_SESSION['Email'] = $Email;
				$_SESSION['Senha'] = $Senha;
				header('location:Vendedor-registration.php');
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
		<li><a href="Vendedor-home.php" class="nav-link px-2 text-secondary">Vendedor Dashboard</a></li>
          <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
          <li><a href="#how-it-works" class="nav-link px-2 text-white">How It Works</a></li>
          <li><a href="home.php" class="nav-link px-2 text-white">Products</a></li>
        </ul>

        <div class="text-end">
          <a href="Vendedor-login.php"><button type="button" class="btn btn-primary">Vendedor Login</button></a>
        </div>
      </div>
    </div>
  </header>
  
  <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Reach More Customers on Amazon!</h1>
        <p class="col-lg-10 fs-4">Offer discounts in exchange for good reviews on Amazon. <b>Sign up now</b> to receive many reviews and reach more customers!</p>
      </div>
      <div id="sign-up" class="col-md-10 mx-auto col-lg-5">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="p-4 p-md-5 border rounded-3 bg-light">
          <div class="form-floating mb-3">
            <input type="Email" name="Email" value="<?php echo $Email;?>" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
			<span style="color:red;"><?php echo $EmailErr;?></span>
          </div>
          <div class="form-floating mb-3">
            <input type="Senha" name="Senha" value="<?php echo $Senha;?>" class="form-control" id="floatingSenha" placeholder="Senha">
            <label for="floatingSenha">Senha</label>
			<span style="color:red;"><?php echo $SenhaErr;?></span>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
          <hr class="my-4">
          <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
        </form>
      </div>
    </div>
  </div>
	
		<!--
		PayPal Username: <input type="text" name="paypalusername" value="<?php echo $paypalusername;?>">
		<span style="color:red;">* <?php echo $paypalErr;?></span> -->

<div class="container px-4 py-5" id="featured-3">
    <h2 id="how-it-works" class="pb-2 border-bottom">How It Works</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <div class="feature col">
        <div class="feature-icon bg-primary bg-gradient">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#collection"></use></svg>
        </div>
        <h2>Explore our Products</h2>
        <p>Explore the range of products that we offer cashback on. We offer many products from many categories including electronics, toys, makeup & beauty and many more.</p>
      </div>
      <div class="feature col">
        <div class="feature-icon bg-primary bg-gradient">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#people-circle"></use></svg>
        </div>
        <h2>Apply, Buy & Review</h2>
        <p>Apply to buy the product you want. Only a limited number of people can apply to buy a product so be quick. After you buy the product, leave a review on Amazon.</p>
      </div>
      <div class="feature col">
        <div class="feature-icon bg-primary bg-gradient">
          <svg class="bi" width="1em" height="1em"><use xlink:href="#toggles2"></use></svg>
        </div>
        <h2>Get Cashback</h2>
        <p>After your review is verified, you will get up to 100% cashback to your PayPal account!</p>
        <a href="#sign-up" class="icon-link">
          Sign Up Now >
        </a>
      </div>
    </div>
  </div>
	
	</body>
</html>
