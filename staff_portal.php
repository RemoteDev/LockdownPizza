<?php 
  session_start();
  include 'db_conn.php';
  $stmt = $conn->prepare("SELECT * FROM customers WHERE cust_id=?");
  $stmt->execute([$_SESSION['user_id']]);
  $user = $stmt->fetch();
  $privileges = $user['cust_privileges'];

  //customers privileges need to be set to staff in the db for the user to be able to access this page.
  if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && $privileges=='staff'){ 

  if (isset($_POST["deliverItem"])) {
    $id_to_update = $_POST["deliverItem"];
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'Delivered' WHERE order_id=?");
    $stmt->execute([$id_to_update]);
  }

  if (isset($_POST["cancelItem"])) {
    $id_to_update = $_POST["cancelItem"];
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'Cancelled' WHERE order_id=?");
    $stmt->execute([$id_to_update]);
  }


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The official Web App for Lockdown Pizza">
    <meta name="author" content="Daniel Bickerdike, Ashley Priest, Joseph Dawson, John Arjonilla-Pailing, Kyle Baxter, Jason Fanning">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Staff Portal</title>
    <!-- Bootstrap core CSS -->
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    </head>
<body>

<!--script to stop orders being removed when page is refreshed-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

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
      
      <a class="btn mx-1 btn-outline-light btn-lg float-left" href="./profile.php">Profile <i class="fas fa-user" aria-hidden="true"></i></a>
      <a class="btn active mx-1 btn-outline-light btn-lg float-right" href="./staff_portal.php">Staff Portal <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>

<?php
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_status = 'Active'");
$stmt->execute();
if($stmt->rowCount() == 0) {
    ?>
    <div class = "container mt-5">
    <h3 style="color:white">There are no Orders to Process</h3>

<?php
    }else{
    ?>
            
    <div class = "container mt-5">
    <h3 style="color:white">Orders to Process</h3>
    <div class="table-respsonsive">
      <table class="table table-bordered table-hover table-stripped">
        <thead>
          <tr class="bg-dark text-white">
            <th>Order ID</th>
            <th>Order Items</th>
            <th>Order Price</th>
            <th>Order Status</th>
          </tr>
          <?php 
          $query  = "SELECT a.house_name_num as address, a.postcode as postcode, o.order_id as id, o.order_items as items, o.order_price as price, o.order_status as status FROM addresses a, orders o, customers c WHERE a.addr_id = c.addr_id AND o.usr_id = c.cust_id AND o.order_status='Active'";
          $orders = $conn ->query($query) ->fetchAll(PDO::FETCH_ASSOC);
        

          ?>
          <?php foreach ($orders as $order) : ?>
            <tr>
              <td style="color:white"><?php echo $order['id']; ?></td>
              <td style="color:white"><?php echo $order['items']; ?></td>
              <td style="color:white"><?php echo "£"; ?><?php echo $order['price']; ?></td>
              <td style="color:white"><?php echo $order['status']; ?></td>
            </tr>
            <tr>
                <td style="color:yellow;"><strong>Address:</strong></td>
                <td style="color:yellow"><?php echo $order['address'] . ", " . $order['postcode']; ?></td>
                <td>
                    <form method="post">
                        <input type = "hidden" name = "deliverItem" value = "<?php echo $order["id"]; ?>">
                        <input type="submit" name="deliver" id="deliver" value="Deliver"/><br/>
                    </form>
                </td>
                <td>
                    <form method="post">
                        <input type = "hidden" name = "cancelItem" value = "<?php echo $order["id"]; ?>">
                        <input type="submit" name="cancel" id="cancel" value="Cancel"/><br/>
                    </form>
                </td>
            </tr>
          <?php endforeach;?>
        </thead>
      </table>
      </div>
    </div>
  </div>
  <?php
  }
  ?>

</body>
</html>
<?php 
}else {
   header("Location: login.php");
}
 ?>
