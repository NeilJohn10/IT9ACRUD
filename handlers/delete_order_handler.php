<?php
session_start();

// ✅ Ensure user is logged in
if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {
    header("Location: ../views/login.php");
    exit();
}

// ✅ Correct path to database connection
include '../database/database.php';

// ✅ Check if order ID is provided
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // ✅ Secure deletion query
    $sql = "DELETE FROM orders WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $order_id, $_SESSION['user']); // Only delete user's own orders
        if ($stmt->execute()) {
            header("Location: ../index.php?success=order_deleted");
            exit();
        } else {
            header("Location: ../index.php?error=delete_failed");
            exit();
        }
    } else {
        header("Location: ../index.php?error=stmt_failed");
        exit();
    }
} else {
    header("Location: ../index.php?error=no_order_id");
    exit();
}
?>
