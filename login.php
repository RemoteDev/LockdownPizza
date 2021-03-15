<?php 
include 'db_conn.php';
  session_start();

  if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<link href="loginstyle.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
	<h3></h3>
    <div class="boxes">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
	<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
	  	<form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-2 display-4">LOGIN</h1>
	  		<?php if (isset($_GET['error'])) { ?>
	  		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
		    <?php } ?>
			<?php if (isset($_GET['success'])) { ?>
	  		<div class="alert alert-success" role="alert">
			  <?=$_GET['success']?>
			</div>
		    <?php } ?>
		  <div class="mb-3">
		    <label for="exampleInputEmail1" 
		           class="form-label">Email address
		    </label>
		    <input type="email" 
		           name="email" 
		           class="form-control transparent" 
		           id="exampleInputEmail1" aria-describedby="emailHelp">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" 
		           class="form-label">Password
		    </label>
		    <input type="password" 
		           class="form-control transparent" 
		           name="password" 
		           id="exampleInputPassword1">
		  </div>
		  <div class = "col text-center">
		  <button type="submit" 
		          class="btn btn-outline-dark btn-lg btn-block w-100">LOGIN
		  </button>
		  </div>
		  <div class = "col text-center">
		  <button type="submit" 
		          class="btn btn-outline-dark btn-lg float-left"><a href="signup.php" class="text-decoration-none text-reset">SIGN UP</a>
		  </button>
		  <button type="submit" 
		          class="btn btn-outline-dark btn-lg float-right"><a href="staff.php" class="text-decoration-none text-reset">STAFF</a>
		  </button>
		  </div>
		  </div>
		</form>
		
	  </div>
</div>
	  
</body>
</html>

<?php 
}else {
   header("Location: index.php");
}
 ?>
 