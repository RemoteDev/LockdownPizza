<?php 
session_start();
//this php is needed to authorise a user adding editing their payment card via their profile page.
include 'db_conn.php';

if (isset($_POST['card_name']) && isset($_POST['card_number']) && isset($_POST['expiry_month']) && isset($_POST['expiry_year']) && isset($_POST['cvv'])) {
	
	$card_name = $_POST['card_name'];
	$card_number = $_POST['card_number'];
    $expiry_month = $_POST['expiry_month'];
	$expiry_year = $_POST['expiry_year'];
	$expiry_date = $_POST['expiry_month'] . "/" . $_POST['expiry_year'];
	$cvv = $_POST['cvv'];

    if (empty($card_name)) {
		header("Location: profile.php?error=Card name is required");
	}
	else if (empty($card_number)){
		header("Location: profile.php?error=Card number is required");
	}
	else if(empty($expiry_month)) {
		header("Location: profile.php?error=Expiry month is required");
	}
	else if(empty($expiry_year)) {
		header("Location: profile.php?error=Expiry year is required");
	}
	else if(empty($cvv)) {
		header("Location: profile.php?error=CVV is required");
	}

	else {
		$stmt = $conn->prepare("SELECT * FROM payments WHERE card_number=?");
		$stmt->execute([$card_number]);
		    if($stmt->rowCount() > 0) {
			    header("Location: profile.php?error=Card Already Exists");
		    }
		
	    else {
		    $cvv_hashed = password_hash($cvv, PASSWORD_DEFAULT);
			
		    $stmt = $conn->prepare("SELECT * FROM payments WHERE usr_id=?");
		    $stmt->execute([$_SESSION['user_id']]);

		    $stmt2 = $conn->prepare("UPDATE payments SET card_name = ?, card_number = ?, expiry_date = ? WHERE usr_id=?");
		    $stmt2->execute([$card_name, $card_number, $expiry_date, $_SESSION['user_id']]);

	        $stmt3 = $conn->prepare("SELECT cvv_id FROM payments WHERE usr_id=?");
		    $stmt3->execute([$_SESSION['user_id']]);
		    $cv = $stmt3->fetch();
		    $cvv_id = $cv['cvv_id'];

		    $stmt4 = $conn->prepare("UPDATE cvvs SET cvv = ? WHERE cvv_id=?");
		    $stmt4->execute([$cvv_hashed, $cvv_id]);
            
            header("Location: profile.php?success=Payment Card updated!");

		}

    }

}
