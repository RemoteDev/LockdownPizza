<?php 
include 'db_conn.php';

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
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
	  <div class="d-flex justify-content-center align-items-center " style="min-height: 100vh;">
	  	<form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="sign_up_auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-2 display-4">Sign Up</h1>
	  		<?php if (isset($_GET['error'])) { ?>
	  		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
		    <?php } ?>
            <div class="mb-3">
		    <label for="firstNameInput" 
		           class="form-label transparent">First Name
		    </label>
		    <input type="text" 
		           name="first_name" 
		           class="form-control transparent" 
		           id="firstNameInput" aria-describedby="firstnameHelp">
		   </div>
           <div class="mb-3">
		    <label for="lastNameInput" 
		           class="form-label">Last Name
		    </label>
		    <input type="text" 
		           name="last_name" 
		           class="form-control transparent" 
		           id="lastNameInput" aria-describedby="lastnameHelp">
		  </div>
          <div class="mb-3">
		    <label for="addressInput" 
		           class="form-label">Address
		    </label>
		    <input type="text" 
		           name="address" 
		           class="form-control transparent" 
		           id="addressInput" aria-describedby="addressHelp">
		  </div>
          <div class="mb-3">
		    <label for="addressInput" 
		           class="form-label">Post Code
		    </label>
		    <input type="text" 
		           name="post_code" 
		           class="form-control transparent" 
		           id="addressCodeInput" aria-describedby="addressCodeHelp"
				   pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}"
				   title="Must be a valid format: AA0 0AA, where A=[A-Z] 0=[0-9]">
		  </div>
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
		           id="exampleInputPassword1"
				   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
  				   title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters">
		  </div>
		  <button type="submit" 
		          class="btn btn-lg btn-outline-dark btn-lg btn-block w-100">Sign Up
		  </button>
		  </div>
		</form>
	  </div>
	</div>
</body>
</html>
<?php 
}else {
   header("Location: signup.php");
}
 ?>