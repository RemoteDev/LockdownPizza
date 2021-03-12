<?php 
session_start();
include 'db_conn.php';

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address']) && isset($_POST['post_code'])) {
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$address = $_POST['address'];
	$post_code = $_POST['post_code'];
	

	if (empty($email)) {
		header("Location: signup.php?error=Email is required");
	}
	else if (empty($password)){
		header("Location: signup.php?error=Password is required");
	}
	else if(empty($first_name)) {
		header("Location: signup.php?error=First Name is required");
	}
	else if(empty($last_name)) {
		header("Location: signup.php?error=Last Name is required");
	}
	else if(empty($address)) {
		header("Location: signup.php?error=Address is required");
	}
	else if(empty($post_code)) {
		header("Location: signup.php?error=Post Code is required");
	}
	else {
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
		$stmt->execute([$email]);
		if($stmt->rowCount() > 0) {
			header("Location: signup.php?error=Email Already Exists");
		} else {
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $conn->prepare("INSERT INTO users (first_name, email, password, address, last_name, post_code) VALUES (?,?,?,?,?,?)");
			$stmt->execute([$first_name, $email, $password_hashed, $address, $last_name, $post_code]);
			header("Location: login.php?success=Successfully Registered! Please Login");
		}

	}
}