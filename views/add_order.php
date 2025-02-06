<?php include '../database/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Order</title>
  <link href="../statics/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f6d365, #fda085);
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
      border: 2px solid #fda085;
      border-radius: 8px;
      padding: 10px;
      font-size: 1rem;
    }

    .form-control:focus {
      border-color: #f6d365;
      box-shadow: 0 0 5px rgba(253, 160, 133, 0.5);
    }

    .btn-primary {
      background: linear-gradient(45deg, #f6d365, #fda085);
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
      width: 100%;
    }

    .btn-primary:hover {
      background: linear-gradient(45deg, #fda085, #f6d365);
    }
  </style>
</head>
<body>
  <div class="form-container">
    <p class="display-5">Add New Order</p>
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
        <select class="form-select form-control" id="status" name="status">
          <option value="Pending">Pending</option>
          <option value="Processing">Processing</option>
          <option value="Completed">Completed</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Add Order</button>
    </form>
  </div>
</body>
</html>
