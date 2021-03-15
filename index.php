<?php 
  session_start();

  if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Web App for Lockdown Pizza">
    <meta name="author" content="Daniel Bickerdike, Ashley Priest, Joseph Dawson, John Arjonilla-Pailing, Kyle Baxter, Jason Fanning">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Lockdown Pizza</title>
    <!-- Bootstrap core CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Lockdown Pizza</a>
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
    </div>
  </div>
</nav>

<main class="container">
<svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>PROMOTIONAL BANNER</title><rect width="100%" height="100%" fill="#d6860d"/><text x="38%" y="50%" fill="#eceeef" dy=".3em">PROMOTIONAL BANNER</text></svg>
  <div class="starter-template text-center py-5 px-3">
    <h1>Lockdown Pizza</h1>
    <p class="lead">Form for entering address and delivery/collection can go here.</p>
    <a class="btn btn-warning" href="./logout.php">Logout</a>
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
 