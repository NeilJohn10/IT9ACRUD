<?php include '../database/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Order</title>
  <link href="../statics/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container d-flex justify-content-center mt-5">
    <div class="col-6">
      <div class="row">
        <p class="display-5 fw-bold">Add New Order</p>
      </div>
      <form action="../handlers/add_order_handler.php" method="POST">
        <div class="mb-3">
          <label for="customer_name" class="form-label">Customer Name</label>
          <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>
        <div class="mb-3">
          <label for="product_name" class="form-label">Product Name</label>
          <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity</label>
          <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Completed">Completed</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Order</button>
      </form>
    </div>
  </div>
</body>
</html>