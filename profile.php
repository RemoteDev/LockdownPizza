<?php 
  session_start();
  include 'db_conn.php';
  if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 

  $stmt = $conn->prepare('SELECT * FROM customers WHERE cust_id=?');
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch();
            
	$user_id = $user['cust_id'];
  $user_email = $user['email_addr'];
	$user_first_name = $user['cust_forename'];
	$user_last_name = $user['cust_surname'];
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
    <link href="style.css" rel="stylesheet">

  </head>
<body>
    
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
  <a class="navbar-brand" href="#"> <i class="fas fa-pizza-slice"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="./index.php">Home</a>
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
      <a class="btn active mx-1 btn-outline-light btn-lg float-left" href="./profile.php">Profile <i class="fas fa-user" aria-hidden="true"></i></a>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>

<main class="container">
<div class="container">
    
    <div class="row row-flex text-center">
      <div class="col-md-6 mt-5 col-sm-6 col-xs-12">
        <div class="content shadow-lg bg-dark border border-light rounded">
            <h1>Welcome back, <?php echo $user_first_name . " " . $user_last_name?> </h1><br>
            <img src="https://loremflickr.com/150/150/pizza" class="rounded-circle p-3"><br>
            <p id="date" class="p-3"></p>
          
        </div>
      </div>
      <div class="col-md-6 mt-5 col-sm-6 col-xs-12 ">
        <div class="content shadow-lg bg-dark border border-light rounded">
        <h1> Personal Details</h1> <br>
              <h4 class="text-left">First Name: <?php echo $user_first_name?></h4><br>
              <h4 class="text-left">Last Name: <?php echo $user_last_name?></h4><br>
              <h4 class="text-left">Email Address: <?php echo $user_email?></h4><br>
                <?php $stmt = $conn->prepare("SELECT postcode, house_name_num FROM addresses WHERE user_id=?");
                      $stmt->execute([$user_id]);
                      $user = $stmt->fetch();
                      $user_postcode = $user['postcode'];
                      $user_house_name_num = $user['house_name_num'];
              ?>
              <h4 class="text-left">Post Code: <?php echo $user_postcode?></h4><br>
              <h4 class="text-left">Address: <?php echo $user_house_name_num?></h4><br>
        </div>
      </div>
  </div>
  </div>
  
<!-- <div class="d-flex flex-row justify-content-between align-items-center mt-5">
    <div class="container text-white rounded shadow-lg bg-dark border border-dark m-3">
        <div class="row is-table-row">
            <div class="col text-center p-2"><h1>Welcome back, <?php echo $user_first_name . " " . $user_last_name?> </h1><br>
            <img src="https://loremflickr.com/150/150/pizza" class="rounded-circle p-3"><br>
            <p id="date" class="p-3"></p>              
            </div>
        </div>
    </div>

    <div class="container text-white rounded shadow-lg bg-dark border border-dark m-3">
        <div class="row is-table-row">
            <div class="col text-center p-2"><h1> Personal Details</h1> <br>
              <h4>First Name: <?php echo $user_first_name?></h4><br>
              <h4>Last Name: <?php echo $user_last_name?></h4><br>
              <h4>Email Address: <?php echo $user_email?></h4><br>
                <?php $stmt = $conn->prepare("SELECT postcode, house_name_num FROM addresses WHERE user_id=?");
                      $stmt->execute([$user_id]);
                      $user = $stmt->fetch();
                      $user_postcode = $user['postcode'];
                      $user_house_name_num = $user['house_name_num'];
              ?>
              <h4>Post Code: <?php echo $user_postcode?></h4><br>
              <h4>Address: <?php echo $user_house_name_num?></h4>
                
            </div>
        </div>
    </div>
</div> -->


<div class = "container mt-5">
    <h3>Orders</h3>
    <div class="table-respsonsive">
      <table class="table table-bordered table-hover table-stripped">
        <thead>
          <tr class="bg-dark text-white">
            <th>Order ID</th>
            <th>Order Items</th>
            <th>Order Price</th>
          </tr>
          <?php 
          $stmt = $conn->prepare("SELECT * FROM orders WHERE usr_id=?");
          $stmt->execute([$user_id]);
          ?>
          <?php foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) : ?>
            <tr>
              <td><?php echo $row['order_id']; ?></td>
              <td><?php echo $row['order_items']; ?></td>
              <td><?php echo "£"; ?><?php echo $row['order_price']; ?></td>
            </tr>
          <?php endforeach;?>
        </thead>
      </table>
      </div>
    </div>
  </div>

</main><!-- /.container -->
<script src="https://remotedev.github.io/LockdownPizza/js/bootstrap.bundle.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script>
  document.getElementById("date").innerHTML = Date();
</script>
  </body>
</html>
<?php 
}else {
   header("Location: login.php");
}
 ?>