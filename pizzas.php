<!doctype html>
<?php
  session_start(); 
  include_once "db_conn.php";
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Web App for Lockdown Pizza">
    <meta name="author" content="Daniel Bickerdike, Ashley Priest, Joseph Dawson, John Arjonilla-Pailing, Kyle Baxter, Jason Fanning">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Lockdown Pizza</title>
    <!-- Bootstrap core CSS -->
<link href="css/stylesheet.css" rel="stylesheet">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="LockdownPizza/starter-template.css" rel="stylesheet">
  </head>
  <body>
    
  <nav class="navbar navbar-expand-md navbar-dark fixed-top text-light">
  <div class="container-fluid ">
    <a class="navbar-brand" href="#"><i class="fas fa-pizza-slice"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-md-0 ">
        <li class="nav-item">
          <a class="nav-link " href="./index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./deals.php">Deals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./pizzas.php">Pizzas</a>
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
      
      <a class="btn mx-1 btn-outline-light btn-lg float-left" href="./profile.php">Profile <i class="fas fa-user" aria-hidden="true"></i></a>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>

<main class="container">

  <div class="starter-template text-center py-5 px-3">
    <h1>Pizzas</h1>
  </div>
  
  <div class="album py-5 bg-light p-3">
    <div class="container">
    
            
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 bg-light">
      <?php 
          $stmt = $conn->prepare("SELECT * FROM menu WHERE food_type='pizza'");
          $stmt->execute();
          if($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              ?>
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Cheese & Tomato Pizza</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Cheese & Tomato</text></svg>
            <div class="card-body bg-dark">
              <p class="card-text"><b><?php echo $row['food_name'] ?></b></p>
              <p class="text-muted"><?php echo $row['food_desc'] ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="submit" class="btn btn-outline-light btn-lg addToCart">Add To Cart</button>
                </div>
                <p class="text-light"><?php echo "£" . $row['food_price'] ?></p>
              </div>
            </div>
          </div>
        </div>
        <?php }
          } ?>
      </div>
    </div>
  </div>
</main><!-- /.container -->
<footer class="footer">
  <!-- Copyright -->
  <div class="container">
  <div class="text-center p-3">
    © 2020 Copyright: <a href="./index.php" class="text-decoration-underlined text-white">Lockdown Pizza LTD</a>
  </div>
  </container>
  <!-- Copyright -->
</footer>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src="https://remotedev.github.io/LockdownPizza/js/bootstrap.bundle.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script type="text/javascript">
  
  </script>
  </body>
</html>