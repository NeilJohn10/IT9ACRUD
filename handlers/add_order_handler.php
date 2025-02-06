<?php
include '../database/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO orders (customer_name, product_name, quantity, status) VALUES ('$customer_name', '$product_name', $quantity, '$status')";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>