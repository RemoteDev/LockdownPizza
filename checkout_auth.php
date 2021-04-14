<?php 
session_start();
include 'db_conn.php';

if (isset($_POST['card_name']) && isset($_POST['card_number']) && isset($_POST['expiry_month']) && isset($_POST['expiry_year']) && isset($_POST['cvv'])) {
	
	$card_name = $_POST['card_name'];
	$card_number = $_POST['card_number'];
	$expiry_date = $_POST['expiry_month'] . "/" . $_POST['expiry_year'];
	$cvv = $_POST['cvv'];

    if (empty($card_name)) {
		header("Location: checkout.php?error=Card name is required");
	}
	else if (empty($card_number)){
		header("Location: checkout.php?error=Card number is required");
	}
	else if(empty($expiry_date)) {
		header("Location: checkout.php?error=Expiry date is required");
	}
	else if(empty($cvv)) {
		header("Location: checkout.php?error=CVV is required");
	}

	else {
		$stmt = $conn->prepare("SELECT * FROM payments WHERE card_number=?");
		$stmt->execute([$card_number]);
		if($stmt->rowCount() > 0) {
			header("Location: checkout.php?error=Card Already Exists");
		}
		else {
        $cvv_hashed = password_hash($cvv, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO cvvs (cvv_id, cvv) VALUES (DEFAULT, ?)");
		$stmt->execute([$cvv_hashed]);

        $stmt = $conn->prepare("SELECT * FROM cvvs where cvv=?");
		$stmt->execute([$cvv_hashed]);

        $cv = $stmt->fetch();
        $cvv_id = $cv['cvv_id'];
		

        $stmt3 = $conn->prepare("INSERT INTO payments (payment_id, card_name, card_number, expiry_date, cvv_id) VALUES (DEFAULT,?,?,?,?)");
		$stmt3->execute([$card_name, $card_number, $expiry_date, $cvv_id]);

        $stmt6 = $conn->prepare("SELECT payment_id FROM payments WHERE card_number=?");
		$stmt6->execute([$card_number]);

        $paymentid = $stmt6->fetch();
		$pay_id = $paymentid['payment_id'];

        $stmt5 = $conn->prepare("UPDATE customers SET cust_payment=? WHERE cust_id=?");
		$stmt5->execute([$pay_id, $_SESSION['user_id']]);

        header("Location: checkout.php?success=Payment Card added!");
		}
	}

}



	

