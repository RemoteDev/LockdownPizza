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
    <link href="css/stylesheet.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Below link needed for carousel -->
    <link href="carousel.css" rel="stylesheet">
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
      <a class="btn mx-1 btn-outline-light btn-lg float-left" href="./profile.php">Profile <i class="fas fa-user" aria-hidden="true"></i></a>
      <a class="btn mx-1 btn-outline-light btn-lg float-right" href="./logout.php">Logout <i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
    </div>
  </div>
</nav>

<main class="container">
<!-- Start of carousel section -->
<!-- Slideshow container -->
<div class="slideshow-container">
  <!-- Full-width images with number and caption text -->
  <div class="mySlides">
    <div class="numbertext">1 / 4</div>
    <a href="./pizzas.php"><img src="images\pepperoni.jpg" alt="Pepperoni Pizza" class="img-thumbnail" style="width:100%; height:400px"></a>
    <div class="text"><h3>Pizza Party!</h3>Have yourself a feast with pizzas cooked fresh from the oven!</div>
  </div>
  <div class="mySlides">
    <div class="numbertext">2 / 4</div>
    <a href="./sides.php"><img src="images\nachos.jpg" alt="Nachos" class="img-thumbnail" style="width:100%; height:400px"></a>
    <div class="text"><h3>Sides To Make You Salivate!</h3>Nothing goes with pizza like a tasty side order!</div>
  </div>
  <div class="mySlides">
    <div class="numbertext">3 / 4</div>
    <a href="./drinks.php"><img src="images\drinks.jpg" alt="Drinks" class="img-thumbnail" style="width:100%; height:400px"></a>
    <div class="text"><h3>Refresh Yourself!</h3>Quench your thirst with our range of soft drinks!</div>
  </div>
  <div class="mySlides">
    <div class="numbertext">4 / 4</div>
    <a href="./drinks.php"><img src="images\chocolate cookies.jpg" alt="Chocolate Cookies" class="img-thumbnail" style="width:100%; height:400px"></a>
    <div class="text"><h3>Yum-Yum!</h3>Add the finishing touch to your meal with one of our delicious desserts!</div>
  </div>
  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
  <span class="dot" onclick="currentSlide(3)"></span>
  <span class="dot" onclick="currentSlide(4)"></span>
</div>
<!-- javascript needed for carousel -->
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
<!-- End of carousel section -->

  <div class="starter-template text-center py-5 px-3">
    <h2 style="color:white;">Welcome to Lockdown Pizza!</h2>
    <p style="font-size:100%; color:Gainsboro;"> We have currently moved our services online, but that does not mean you have to miss out on our tasty pizzas!
With our fast crew of delivery vans, we bring the authentic taste of Lockdown Pizza straight to your door.
All our pizzas are cooked with fresh ingredients, from our grass-fed ground beef to our spicy Pepperoni.
</p>
    <h3 style="color:white;">Some of our faves:</h3>

    <!-- Image gallery section -->
    <div class="container">
    <div class="row">
    <div class="col-md-4">
      <div class="thumbnail">
        <a href="images\cheese and tomato.jpg" target="_blank">
          <img src="images\cheese and tomato.jpg" alt="Cheese and Tomato Pizza" class="img-thumbnail" style="width:100%; height:250px">
          <div class="caption">
            <button style="width:100%">Classic Cheese and Tomato Pizza</button>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="thumbnail">
        <a href="images\mozzarella sticks.jpg" target="_blank">
          <img src="images\mozzarella sticks.jpg" alt="Mozzarella Sticks" class="img-thumbnail" style="width:100%; height:250px">
          <div class="caption">
          <button style="width:100%">Cheesy Mozzarella Sticks</button>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="thumbnail">
        <a href="images\chocolate fudge ice cream.jpg" target="_blank">
          <img src="images\chocolate fudge ice cream.jpg" alt="Chocolate Fudge Ice Cream" class="img-thumbnail" style="width:100%; height:250px">
          <div class="caption">
          <button style="width:100%">Sweet Chocolate Fudge Ice Cream</button>
          </div>
        </a>
      </div>
    </div>
  </div>
  <!-- End of image gallery section -->

</div>

    <p class="lead">Form for entering address and delivery/collection can go here.</p>
    <a class="btn btn-warning" href="./logout.php">Logout</a>
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
<script src="https://remotedev.github.io/LockdownPizza/js/bootstrap.bundle.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    
  </body>
</html>
<?php 
}else {
   header("Location: login.php");
}
 ?>
