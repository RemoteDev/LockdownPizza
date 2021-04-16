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
		$stmt = $conn->prepare("SELECT * FROM customers WHERE email_addr=?");
		$stmt->execute([$email]);
		if($stmt->rowCount() > 0) {
			header("Location: signup.php?error=Email Already Exists");
		} else {
			$password_hashed = password_hash($password, PASSWORD_DEFAULT);

			$stmt = $conn->prepare("INSERT INTO passwords (pw_id, password) VALUES (DEFAULT, ?)");
			$stmt->execute([$password_hashed]);

			$stmt = $conn->prepare("SELECT * FROM passwords where password=?");
			$stmt->execute([$password_hashed]);

			$pw = $stmt->fetch();
			$pw_id = $pw['pw_id'];

		    $stmt3 = $conn->prepare("INSERT INTO customers (cust_id, cust_forename, cust_surname, email_addr, pw_id) VALUES (DEFAULT,?,?,?,?)");
			$stmt3->execute([$first_name, $last_name, $email, $pw_id]);

			$stmt6 = $conn->prepare("SELECT cust_id FROM customers WHERE email_addr=?");
			$stmt6->execute([$email]);

			$customerid = $stmt6->fetch();
			$cust_id = $customerid['cust_id'];

			$stmt4 = $conn->prepare("SELECT addr_id FROM addresses WHERE house_name_num=? AND postcode=?");
			$stmt4->execute([$address,$post_code]);
			if ($stmt4->rowCount() > 0) { //if the address of the new customer already exists in the db, assign them the existing address.
				$addressid = $stmt4->fetch();
				$addr_id = $addressid['addr_id']; 
				$stmt5 = $conn->prepare("UPDATE customers SET addr_id=? WHERE cust_id=?");
				$stmt5->execute([$addr_id, $cust_id]);
			}
			else { //else add the new address and assign it to the new customer.
			$stmt2 = $conn->prepare("INSERT INTO addresses (addr_id, house_name_num, postcode) VALUES (DEFAULT,?,?)");
			$stmt2->execute([$address, $post_code]);
			$stmt4 = $conn->prepare("SELECT addr_id FROM addresses WHERE house_name_num=? AND postcode=?");
			$stmt4->execute([$address,$post_code]);
			$addressid = $stmt4->fetch();
			$addr_id = $addressid['addr_id']; 
			$stmt5 = $conn->prepare("UPDATE customers SET addr_id=? WHERE cust_id=?");
			$stmt5->execute([$addr_id, $cust_id]);
			}

			header("Location: login.php?success=Successfully Registered! Please Login");
		}

	}
}
