<?php
include '../database/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $res = $conn->query("SELECT * FROM orders WHERE id = $id");
    $row = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Order</title>
  <link href="../statics/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container d-flex justify-content-center mt-5">
    <div class="col-6">
      <div class="row">
        <p class="display-5 fw-bold">Edit Order</p>
      </div>
      <form action="../handlers/update_order_handler.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <div class="mb-3">
          <label for="customer_name" class="form-label">Customer Name</label>
          <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= $row['customer_name']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name</label>
          <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $row['product_name']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity</label>
          <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $row['quantity']; ?>" required>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Processing" <?= $row['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
            <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
      </form>
    </div>
  </div>
</body>
</html>