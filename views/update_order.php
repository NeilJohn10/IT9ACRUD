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
  <style>
    body {
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
    }

    .form-container {
      background: #ffffff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 500px;
    }

    .form-container .display-5 {
      background: linear-gradient(45deg, #ff9a9e, #fad0c4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .form-control {
      border: 2px solid #66a6ff;
      border-radius: 8px;
      padding: 10px;
      font-size: 1rem;
    }

    .form-control:focus {
      border-color: #89f7fe;
      box-shadow: 0 0 5px rgba(102, 166, 255, 0.5);
    }

    .btn-primary {
      background: linear-gradient(45deg, #66a6ff, #89f7fe);
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
      width: 100%;
    }

    .btn-primary:hover {
      background: linear-gradient(45deg, #89f7fe, #66a6ff);
    }
  </style>
</head>
<body>
  <div class="form-container">
    <p class="display-5">Edit Order</p>
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
        <select class="form-select form-control" id="status" name="status">
          <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
          <option value="Processing" <?= $row['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
          <option value="Completed" <?= $row['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
  </div>
</body>
</html>
