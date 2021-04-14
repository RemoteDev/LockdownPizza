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
    <h1 style="color:white">Pizzas</h1>
  </div>
  
  <div class="album py-5 bg-light p-3">
    <div class="container">

<!-- cart section --->
<div id="shopping-cart">
<div class="txt-heading">Your Order</div>

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
        <tr>
            <th style="text-align:left;">Item</th>
            <th style="text-align:right;" width="5%">Quantity</th>
            <th style="text-align:right;" width="10%">Price</th>
            <th style="text-align:center;" width="5%">Remove</th>
        </tr>
    <?php		
        foreach ($_SESSION["cart"] as $item){
            $item_price = $item["quantity"]*$item["price"];
	?>
    	<tr>
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

        <tr>
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
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

<!--section displaying products from database -->
<div id="product-grid">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 bg-light">
	<?php
  $query = ("SELECT * FROM menu WHERE food_type='pizza'");
	$pizzas = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
	if (!empty($pizzas)) { 
		foreach($pizzas as $pizza){
	?>
		<div class="product-item">
      <div class="col">
        <div class="card shadow-sm">
          <div class="product-image"><img alt="<?php echo $pizza ['food_name'] ?>" width="100%" height="225" src="<?php echo $pizza ['food_image']; ?>"></div>
          <div class="product-tile-footer">
          <div class="card-body bg-dark">
			      <p class="card-text" style="color:white"><b><?php echo $pizza ['food_name'] ?></b></p>
            <p class="text-muted"><?php echo $pizza ['food_desc'] ?></p>
          <div class="d-flex justify-content-between align-items-center">
			    <div class="btn-group">
            <form class = "form-submit" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
              <input type = "hidden" name = "fname" value = "<?php echo $pizza ['food_name'] ?>">
              <input type = "hidden" name = "fprice" value = "<?php echo $pizza ['food_price'] ?>">
              <input type="hidden" class="product-quantity" name="fquantity" value="1" size="2" />
              <button type = "submit" name = "submit" class="btn btn-outline-light btn-lg addToCart">Add To Cart</button>
            </form>
          </div>
          <p class="text-light"><?php echo "£" . number_format($pizza ['food_price'], 2) ?></p>
        </div>
			  </div>
      </div>
		</div>
    </div>
  </div>
	<?php
		}
	}
	?>
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
