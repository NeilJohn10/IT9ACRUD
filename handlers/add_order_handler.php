<?php
session_start();
include '../database/database.php';

// ✅ Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user'];
    $customer_name = $_POST['customer_name'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // ✅ Get the latest order number for the user
    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($order_count);
    $stmt->fetch();
    $stmt->close();

    // ✅ New order number for this user
    $user_order_number = $order_count + 1;

    // ✅ Insert new order with user-specific order number
    $stmt = $conn->prepare("INSERT INTO orders (user_id, user_order_number, customer_name, product_name, quantity, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissis", $user_id, $user_order_number, $customer_name, $product_name, $quantity, $status);

    if ($stmt->execute()) {
        header("Location: ../index.php?success=order_added");
        exit();
    } else {
        header("Location: ../index.php?error=order_failed");
        exit();
    }
}
?>
