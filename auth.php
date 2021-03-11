<?php 
session_start();
include 'db_conn.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	if (empty($email)) {
		header("Location: login.php?error=Email is required");
	}else if (empty($password)){
		header("Location: login.php?error=Password is required");
	}else {
		$stmt = $conn->prepare("SELECT * FROM Customers WHERE email_addr=?");
		$stmt->execute([$email]);

		if ($stmt->rowCount() === 1) {
			$user = $stmt->fetch();

			$user_id = $user['cust_id'];
			$user_email = $user['email_addr'];
			$user_password = $user['pw_id'];
			$user_full_name = $user['cust_forename'];

			if ($email === $user_email) {
				if (password_verify($password, $user_password)) {
					$_SESSION['user_id'] = $user_id;
					$_SESSION['user_email'] = $user_email;
					$_SESSION['user_full_name'] = $user_full_name;
					header("Location: index.php");

				}else {
					header("Location: login.php?error=Incorect User name or password");
				}
			}else {
				header("Location: login.php?error=Incorect User name or password");
			}
		}else {
			header("Location: login.php?error=Incorect User name or password");
		}
	}
}