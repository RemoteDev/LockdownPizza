<?php 
session_start();
//this php is needed to authorise a user changing their address through their profile page.
include 'db_conn.php';

if (isset($_POST['address']) && isset($_POST['postcode'])) {
	
	$address = $_POST['address'];
	$post_code = $_POST['postcode'];

    if(empty($address)) {
		header("Location: profile.php?error=Address is required");
	}
	else if(empty($post_code)) {
		header("Location: profile.php?error=Post Code is required");
	}

    else {

        $stmt = $conn->prepare("SELECT addr_id FROM customers WHERE cust_id=?");
        $stmt->execute([$_SESSION['user_id']]);
        $address_t_f = $stmt->fetch();
        $address_to_find = $address_t_f['addr_id'];


        $stmt = $conn->prepare("SELECT * FROM customers WHERE addr_id=?");
		$stmt->execute([$address_to_find]);
		if($stmt->rowCount() > 1) { //if the user's current address appears in db more than once

            $stmt2 = $conn->prepare("SELECT * FROM addresses WHERE house_name_num=? AND postcode = ?");
            $stmt2->execute([$address,$post_code]);
            
            if ($stmt2->rowCount() > 0) { //if the new address the user is trying to change to already exists in db

                $ai= $stmt2->fetch();
                $addressid = $ai['addr_id'];

                //update their details to this address
                $stmt3 = $conn->prepare("UPDATE customers SET addr_id = ? WHERE cust_id=?");
				$stmt3->execute([$addressid, $_SESSION['user_id']]);
                
                header("Location: profile.php?success=Address updated!");
            }

            else { //else if the new address does not exist in the db
                //add it to the db
                $stmt4 = $conn->prepare("INSERT INTO addresses(addr_id, house_name_num, postcode) VALUES(DEFAULT, ?, ?)");
                $stmt4->execute([$address,$post_code]); 

                $stmt5 = $conn->prepare("SELECT * FROM addresses WHERE house_name_num=? AND postcode = ?");
                $stmt5->execute([$address,$post_code]);

                $ai= $stmt5->fetch();
                $addressid = $ai['addr_id'];
                
                //update their details to this address
                $stmt3 = $conn->prepare("UPDATE customers SET addr_id = ? WHERE cust_id=?");
				$stmt3->execute([$addressid, $_SESSION['user_id']]);

                header("Location: profile.php?success=Address updated!");

            }
        }

        else {
            
            $stmt2 = $conn->prepare("SELECT * FROM addresses WHERE house_name_num=? AND postcode = ?");
            $stmt2->execute([$address,$post_code]);
            
            if ($stmt2->rowCount() > 0) { //if the new address the user is trying to change to already exists in db

                $ai= $stmt2->fetch();
                $addressid = $ai['addr_id'];

                //update their details to this address
                $stmt3 = $conn->prepare("UPDATE customers SET addr_id = ? WHERE cust_id=?");
				$stmt3->execute([$addressid, $_SESSION['user_id']]);

                //remove the address that now has no customer
                $stmt4 = $conn->prepare("DELETE FROM addresses WHERE addr_id = ?");
                $stmt4->execute([$address_to_find]);

                header("Location: profile.php?success=Address updated!");

            }

            else {
                //update the address and postcode of the customers current address
                $stmt2 = $conn->prepare("UPDATE addresses SET house_name_num=?, postcode = ? WHERE addr_id = ?");
                $stmt2->execute([$address,$post_code,$address_to_find]);

                header("Location: profile.php?success=Address updated!");

            }

        }

    }

}
