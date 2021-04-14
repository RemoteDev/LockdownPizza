<?php 
session_start();
include 'db_conn.php';

$order_user = $_POST['orderUser'];
$order_items = $_POST['orderDesc'];
$order_price = $_POST['orderCost'];

$stmt = $conn->prepare("INSERT INTO orders (order_id, usr_id, order_items, order_price, order_status) VALUES (DEFAULT, ?, ?, ?, 'Active')");
		$stmt->execute([$order_user, $order_items, $order_price]);

unset($_SESSION["cart"]);

header("Location: profile.php?success=Order successfully placed! Check your orders below to see their status!");