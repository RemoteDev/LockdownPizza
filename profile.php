<?php 
  session_start();

  if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
?>
<!doctype html>
<html lang="en">
<body>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Web App for Lockdown Pizza">
    <meta name="author" content="Daniel Bickerdike, Ashley Priest, Joseph Dawson, John Arjonilla-Pailing, Kyle Baxter, Jason Fanning">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Profile Page</title>
    <!-- Bootstrap core CSS -->
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

  </head>
<body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Lockdown Pizza</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./deals.php">Deals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./pizzas.php">Pizzas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./sides.php">Sides</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./drinks.php">Drinks</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./desserts.php">Desserts</a>
        </li>
      </ul>
      <a class="btn mx-1 btn-outline-light btn-lg float-left" href="./profile.php">Profile <i class="fa fa-user" aria-hidden="true"></i></a>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>

<main class="container">
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
<div class="wrapper"> 
	  	
		
</div>

</main><!-- /.container -->
<script src="https://remotedev.github.io/LockdownPizza/js/bootstrap.bundle.min.js"></script>
    
  </body>
</html>
<?php 
}else {
   header("Location: login.php");
}
 ?>
 