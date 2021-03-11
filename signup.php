<?php 
include 'db_conn.php';

  if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_email'])) { 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Secure Login System PHP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
	  <div class="d-flex justify-content-center align-items-center " style="min-height: 100vh;">
	  	<form class="p-5 rounded shadow-lg border border-dark" 
	  	      action="sign_up_auth.php"
	  	      method="post" 
	  	      style="width: 30rem">
	  		<h1 class="text-center pb-5 display-4">Sign Up</h1>
	  		<?php if (isset($_GET['error'])) { ?>
	  		<div class="alert alert-danger" role="alert">
			  <?=$_GET['error']?>
			</div>
		    <?php } ?>
            <div class="mb-3">
		    <label for="firstNameInput" 
		           class="form-label">First Name
		    </label>
		    <input type="text" 
		           name="firstname" 
		           class="form-control" 
		           id="firstNameInput" aria-describedby="firstnameHelp">
		   </div>
           <div class="mb-3">
		    <label for="lastNameInput" 
		           class="form-label">Last Name
		    </label>
		    <input type="text" 
		           name="lastname" 
		           class="form-control" 
		           id="lastNameInput" aria-describedby="lastnameHelp">
		  </div>
          <div class="mb-3">
		    <label for="addressInput" 
		           class="form-label">Address
		    </label>
		    <input type="address" 
		           name="address" 
		           class="form-control" 
		           id="addressInput" aria-describedby="addressHelp">
		  </div>
          <div class="mb-3">
		    <label for="addressInput" 
		           class="form-label">Post Code
		    </label>
		    <input type="address" 
		           name="addressCode" 
		           class="form-control" 
		           id="addressCodeInput" aria-describedby="addressCodeHelp">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputEmail1" 
		           class="form-label">Email address
		    </label>
		    <input type="email" 
		           name="email" 
		           class="form-control" 
		           id="exampleInputEmail1" aria-describedby="emailHelp">
		  </div>
		  <div class="mb-3">
		    <label for="exampleInputPassword1" 
		           class="form-label">Password
		    </label>
		    <input type="password" 
		           class="form-control" 
		           name="password" 
		           id="exampleInputPassword1">
		  </div>
		  <button type="submit" 
		          class="btn btn-lg btn-block btn-outline-dark">Sign Up
		  </button>
		  </div>
		</form>
	  </div>
</body>
</html>

<?php 
}else {
   header("Location: index.php");
}
 ?>