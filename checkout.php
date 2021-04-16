<?php 
  session_start();
  include 'db_conn.php';
  //only allow access to this page if user is logged in and they have a cart containing at least one item
  if (isset($_SESSION['user_id']) && isset($_SESSION['user_email']) && isset($_SESSION["cart"])) { 

    $stmt = $conn->prepare('SELECT * FROM customers WHERE cust_id=?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    $user_id = $user['cust_id'];
    $user_addr = $user['addr_id'];
    $privileges = $user['cust_privileges'];

    $stmt = $conn->prepare('SELECT * FROM payments WHERE usr_id=?');
    $stmt->execute([$_SESSION['user_id']]);
    if($stmt->rowCount() > 0) {
    $card_details = $stmt->fetch();
            
    $user_payment_id = $card_details['usr_id'];
    $card_details_name = $card_details['card_name'];
    $card_details_number = $card_details['card_number'];
    $card_details_expiry = $card_details['expiry_date'];
    }

    else{
      $user_payment_id = NULL;
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
    <title>Lockdown Pizza</title>
    <!-- Bootstrap core CSS -->
    <link href="css/stylesheet.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>

<?php
  //php to turn items of order array into a string
$order_string = "";
if (!empty($_SESSION["cart"])){ //if the cart is not empty
  foreach ($_SESSION["cart"] as $fkey => $fvalue) {
    $order_string .= $_SESSION["cart"][$fkey]["name"] . " ";
    $order_string .= "x" . $_SESSION["cart"][$fkey]["quantity"] . " ";
  }
}
?>


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

  <div class="starter-template text-center py-5 px-3">
    <h1 style="color:white">Complete Your Order</h1>
  </div>

  <div class="album py-5 bg-light p-3">
    <div class="container">


    <!-- cart section --->
<div id="shopping-cart">
<div class="txt-heading">Your Order Details</div>

<?php
if(isset($_SESSION["cart"])){
    $total_quantity = 0;
    $total_price = 0;
?>

<table class="tbl-cart" cellpadding="10" cellspacing="1">
    <tbody>
        <tr>
            <th style="text-align:left;">Item</th>
            <th style="text-align:right;" width="5%">Quantity</th>
            <th style="text-align:right;" width="10%">Price</th>
        </tr>
    <?php		
        foreach ($_SESSION["cart"] as $item){
            $item_price = $item["quantity"]*$item["price"];
	?>
    	<tr>
			<td><?php echo $item["name"]; ?></td>
			<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
			<td style="text-align:right;"><?php echo "£ ". number_format($item_price,2); ?></td>
		  </tr>
	<?php
		$total_quantity += $item["quantity"];
		$total_price += ($item["price"]*$item["quantity"]);
	}
	?>	

        <tr>
            <td colspan="1" style="text-align:right;">Total:</td>
            <td style="text-align:right;"><?php echo $total_quantity; ?></td>
            <td style="text-align:right;"><strong><?php echo "£ ".number_format($total_price, 2); ?></strong></td>
            <td></td>
        </tr>
    </tbody>
</table>

<?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

<div class="container">
    
    <div class="row row-flex text-center">
      <div class="col-md-6 mt-5 col-sm-6 col-xs-12">
        <div class="content shadow-lg bg-dark border border-light rounded">
        <h1> Delivery Details</h1> <br>
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

    <?php
    if ($user_payment_id != NULL) {
      ?>

    <div class="col-md-6 mt-5 col-sm-6 col-xs-12 ">
        <div class="content shadow-lg bg-dark border border-light rounded">
            <h1> Payment Details</h1> <br>
            
            <h4 class="text-left">Card Name: <?php echo $card_details_name?></h4><br>
            <h4 class="text-left">Card Number: <?php echo $card_details_number?></h4><br>
            <h4 class="text-left">Card Expiry Date: <?php echo $card_details_expiry?></h4><br>
        </div>
    </div>

    <form method="post" action="confirm_order.php">
                <input type = "hidden" name = "orderDesc" value = "<?php echo $order_string ?>">
                <input type = "hidden" name = "orderCost" value = "<?php echo $total_price ?>">
                <input type = "hidden" name = "orderUser" value = "<?php echo $user_id ?>">
                <input type="submit" name="confirm" id="confirm" value="Comfirm Purchase"/><br/>
    </form>
    
    
    <?php
    }else {
      ?>

    <div class="col-md-6 mt-5 col-sm-6 col-xs-12 ">
        <div class="content shadow-lg bg-dark border border-light rounded" style="min-height: 100vh;">
        <form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="payment_auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-2 display-4">Add Payment Card</h1>
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
		    <input type="text" 
		           name="cvv" 
		           class="form-control transparent" 
		           id="cvvInput" aria-describedby="cvvHelp"
				   pattern="[0-9]{3}"
				   title="Enter a 3 digit number.">
		  </div>
		  		  <button type="submit" style="color:white"
		          class="btn btn-lg btn-outline-dark btn-lg btn-block w-100">Add Card
		  </button>
		  </div>
		</form>
	  </div>

    </div>
    <?php
    }
    ?>
        
</div>

  </body>
  </html>

  <?php 
}else {
   header("Location: login.php");
}
 ?>
