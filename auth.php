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
		$stmt = $conn->prepare('SELECT * FROM customers WHERE email_addr=?');
		$stmt->execute([$email]);

		if ($stmt->rowCount() === 1) {
			$user = $stmt->fetch();
            
			$user_id = $user['cust_id'];
			$user_email = $user['email_addr'];
			$user_password_id = $user['pw_id'];
			$user_first_name = $user['cust_forename'];
			$user_last_name = $user['cust_surname'];
			
			$stmt = $conn->prepare("SELECT password FROM passwords WHERE pw_id=?");
			$stmt->execute([$user_password_id]);

			$user_pwidtopw = $stmt->fetch();
			$user_password = $user_pwidtopw['password'];

			if ($email === $user_email) {
                header("Location: index.php");
				if (password_verify($password, $user_password)) {
					$_SESSION['user_id'] = $user_id;
					$_SESSION['user_email'] = $user_email;
					$_SESSION['user_first_name'] = $user_first_name;
					$_SESSION['user_last_name'] = $user_last_name;
					header("Location: profile.php");

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
