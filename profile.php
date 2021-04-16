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
  $user_addr = $user['addr_id'];
  $privileges = $user['cust_privileges'];
?>
<!doctype html>
<html lang="en">
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

<?php if (isset($_GET['success'])) { ?>
	  		<div class="alert alert-success" role="alert">
			  <?=$_GET['success']?>
			</div>
		    <?php } ?>

<!--script to stop unselected items being added to cart when the page is refreshed-->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<?php
//php to add an item to the cart
if (isset($_POST['submit'])) {
    $name = $_POST["fname"];
    $order_item = array($name => array('name' => $_POST["fname"], 'price' => $_POST["fprice"],'quantity' => $_POST["fquantity"]));

    if (!empty($_SESSION["cart"])){ //if the cart is not empty
        if(array_key_exists($name,($_SESSION["cart"]))) { //if the item just added already exists in the cart
        foreach ($_SESSION["cart"] as $fkey => $fvalue) {
            if ($name == $fkey) {
                $_SESSION["cart"][$fkey]["quantity"] += 1; //increase the quantity of the item by one
            }
        }
    }
    else {
        $_SESSION["cart"] = array_merge($_SESSION["cart"], $order_item); //add new item to the cart  
        }
    }
    else { //if no items yet in the cart
        $_SESSION["cart"] = $order_item; //make the item the first item of the cart
    }  
}

//function to remove a specific item from the cart
function removeItem()
{
    $item_to_remove = $_POST["rmvItem"];
    if(array_key_exists($item_to_remove,($_SESSION["cart"]))) {
        foreach ($_SESSION["cart"] as $fkey => $fvalue) {
            if ($item_to_remove == $fkey) {
                unset($_SESSION["cart"][$fkey]);
                if(empty($_SESSION["cart"]))
                unset($_SESSION["cart"]);
            }
        }
    }
}
if(array_key_exists('remove',$_POST)){
   removeItem();
}

?>
    
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
      <?php
      if ($privileges=='staff'){ 
        ?>
        <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./staff_portal.php">Staff Portal <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
       <?php } ?>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
    
    </div>
  </div>
</nav>

<main class="container">
<div class="container">

<!-- cart section --->
<div id="shopping-cart">
<div class="txt-heading" style="color:white">Your Order</div>

<form method="post">
    <input type="submit" name="empty" id="empty" value="EMPTY BASKET" /><br/>
</form>

<?php
function emptyBasket()
{
    unset($_SESSION["cart"]);
}

if(array_key_exists('empty',$_POST)){
   emptyBasket();
}
?>

<?php
if(isset($_SESSION["cart"])){
    $total_quantity = 0;
    $total_price = 0;
?>

<table class="tbl-cart" cellpadding="10" cellspacing="1">
    <tbody>
        <tr style="color:white">
            <th style="text-align:left;">Item</th>
            <th style="text-align:right;" width="5%">Quantity</th>
            <th style="text-align:right;" width="10%">Price</th>
            <th style="text-align:center;" width="5%">Remove</th>
        </tr>
    <?php		
        foreach ($_SESSION["cart"] as $item){
            $item_price = $item["quantity"]*$item["price"];
	?>
    	<tr style="color:white">
			<td><?php echo $item["name"]; ?></td>
			<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
			<td style="text-align:right;"><?php echo "£ ". number_format($item_price,2); ?></td>
            <td style="text-align:right;">
              <form method="post">
                  <input type = "hidden" name = "rmvItem" value = "<?php echo $item["name"]; ?>">
                  <input type="submit" name="remove" id="remove" value="Remove"/><br/>
              </form>
            </td>
		</tr>
	<?php
		$total_quantity += $item["quantity"];
		$total_price += ($item["price"]*$item["quantity"]);
	}
	?>	

        <tr style="color:white">
            <td colspan="1" style="text-align:right;">Total:</td>
            <td style="text-align:right;"><?php echo $total_quantity; ?></td>
            <td style="text-align:right;"><strong><?php echo "£ ".number_format($total_price, 2); ?></strong></td>
            <td style="text-align:right;">
              <form method="post" action="checkout.php">
                <input type="submit" name="checkout" id="checkout" value="Complete Order"/><br/>
                </form>
            </td>
            <td></td>
        </tr>
    </tbody>
</table>

<?php
} else {
?>
<div class="no-records" style="color:white">Your Cart is Empty</div>
<?php 
}
?>
</div>
    
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
                <?php $stmt = $conn->prepare("SELECT postcode, house_name_num FROM addresses WHERE addr_id=?");
                      $stmt->execute([$user_addr]);
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
  
<div class = "container mt-5">
    <h3 style="color:white">Orders</h3>
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
          $stmt = $conn->prepare("SELECT * FROM orders WHERE usr_id=?");
          $stmt->execute([$user_id]);
          ?>
          <?php foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) : ?>
            <tr>
              <td style="color:white"><?php echo $row['order_id']; ?></td>
              <td style="color:white"><?php echo $row['order_items']; ?></td>
              <td style="color:white"><?php echo "£"; ?><?php echo $row['order_price']; ?></td>
              <td style="color:white"><?php echo $row['order_status']; ?></td>
            </tr>
          <?php endforeach;?>
        </thead>
      </table>
      </div>
    </div>
  </div>

  <?php
  $stmt = $conn->prepare("SELECT * FROM payments WHERE usr_id=?");
  $stmt->execute([$_SESSION['user_id']]);
  if ($stmt->rowCount() > 0) {
    ?>
  <div class="col-md-6 mt-5 col-sm-6 col-xs-12 ">
        <div class="content shadow-lg bg-dark border border-light rounded" style="min-height: 100vh;">
        <form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="payment_edit_auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-2 display-4">Edit Payment Card</h1>
	  		<?php if (isset($_GET['error'])) { ?>
	  		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
		    <?php } ?>
            <div class="mb-3">
		    <label for="cardNameInput" 
		           class="form-label transparent">Name on Card
		    </label>
		    <input type="text" 
		           name="card_name" 
		           class="form-control transparent" 
		           id="cardNameInput" aria-describedby="cardnameHelp">
		   </div>
           <div class="mb-3">
		    <label for="cardNumberInput" 
		           class="form-label">Card Number
		    </label>
		    <input type="text" 
		           name="card_number" 
		           class="form-control transparent" 
		           id="cardNumberInput" aria-describedby="cardnumberHelp"
               pattern="[0-9]{16}"
  				   title="Card must contain 16 numbers. Do not enter any spaces.">
               
		  </div>
          <div class="mb-3">
		    <label for="expiryMonthInput" 
		           class="form-label">Expiry Month
		    </label>
		    <input type="text" 
		           name="expiry_month" 
		           class="form-control transparent" 
		           id="expiryMonthInput" aria-describedby="expiryMonthHelp"
               placeholder = "MM"
               pattern="0[1-9]|1[1-2]"
  				   title="Enter a valid expiry month">
		  </div>

          <div class="mb-3">
		    <label for="expiryYearInput" 
		           class="form-label">Expiry Year
		    </label>
		    <input type="text" 
		           name="expiry_year" 
		           class="form-control transparent" 
		           id="expiryYearInput" aria-describedby="expiryYearHelp"
               placeholder = "YY"
               pattern="2[1-9]|[3-9][0-9]"
  				   title="Enter a valid expiry year">
		  </div>
          <div class="mb-3">
		    <label for="cvvInput" 
		           class="form-label">CVV
		    </label>
		    <input type="password" 
		           name="cvv" 
		           class="form-control transparent" 
		           id="cvvInput" aria-describedby="cvvHelp"
				   pattern="[0-9]{3}"
				   title="Enter a 3 digit number.">
		  </div>
		  		  <button type="submit" style="color:white"
		          class="btn btn-lg btn-outline-dark btn-lg btn-block w-100">Edit Card
		  </button>
		  </div>
		</form>
	  </div>
    <?php
        }
        ?>

    <div class="col-md-6 mt-5 col-sm-6 col-xs-12 ">
        <div class="content shadow-lg bg-dark border border-light rounded" style="min-height: 100vh;">
        <form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="address_auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-2 display-4">Edit Delivery Address</h1>
	  		<?php if (isset($_GET['error'])) { ?>
	  		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
		    <?php } ?>
            <div class="mb-3">
		    <label for="addressInput" 
		           class="form-label transparent">Address
		    </label>
		    <input type="text" 
		           name="address" 
		           class="form-control transparent" 
		           id="addressInput" aria-describedby="addressHelp">
		   </div>
           <div class="mb-3">
		    <label for="postcodeNumberInput" 
		           class="form-label">Postcode
		    </label>
		    <input type="text" 
		           name="postcode" 
		           class="form-control transparent" 
		           id="postcodeInput" aria-describedby="postcodeHelp"
               pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}"
               title="Must be a valid format: AA0 0AA, where A=[A-Z] 0=[0-9]">

		  </div>
		  		  <button type="submit" style="color:white"
		          class="btn btn-lg btn-outline-dark btn-lg btn-block w-100">Edit Address
		  </button>
		  </div>
		</form>
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
