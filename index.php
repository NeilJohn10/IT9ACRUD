<?php include 'database/database.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ordering System</title>
  <link href="statics/css/bootstrap.min.css" rel="stylesheet">
  <script src="statics/js/bootstrap.js"></script>
  <style>
    body {
      background: linear-gradient(135deg, #f6d365, #fda085);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .container {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 800px;
    }

    .display-5 {
      background: linear-gradient(45deg, #ff9a9e, #fad0c4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-align: center;
      margin-bottom: 20px;
    }

    .btn-outline-dark {
      background: linear-gradient(45deg, #89f7fe, #66a6ff);
      color: white;
      font-weight: bold;
      border: none;
      transition: transform 0.3s ease;
    }

    .btn-outline-dark:hover {
      background: linear-gradient(45deg, #66a6ff, #89f7fe);
      transform: scale(1.05);
    }

    .order-card {
      border: 2px solid #66a6ff;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 20px;
      background: #f7f9fc;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-warning {
      background: #ffcc00;
      border: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .btn-warning:hover {
      background: #ffb700;
    }

    .btn-danger {
      background: #ff6b6b;
      border: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .btn-danger:hover {
      background: #ff4b4b;
    }

    .text-muted {
      font-size: 1.1rem;
      color: #6c757d !important;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row">
      <p class="display-5 fw-bold">Ordering System</p>
    </div>
    <div class="row mb-4">
      <a href="views/add_order.php" class="btn btn-outline-dark btn-sm">Add New Order</a>
    </div>
    <?php
    $res = $conn->query("SELECT * FROM orders");
    ?>
    <?php if ($res->num_rows > 0) : ?>
      <?php while ($row = $res->fetch_assoc()) : ?>
        <div class="row order-card">
          <div>
            <h5 class="fw-bold">Order #<?= $row['id']; ?></h5>
            <p class="text-secondary">Customer: <?= $row['customer_name']; ?></p>
            <p class="text-secondary">Product: <?= $row['product_name']; ?></p>
            <p class="text-secondary">Quantity: <?= $row['quantity']; ?></p>
            <p class="fw-bold">
              <small>
                Status: <?= $row['status']; ?>
              </small>
            </p>
            <div class="row my-1">
              <a href="views/update_order.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            </div>
            <div class="row my-1">
              <a href="handlers/delete_order_handler.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="row text-center">
        <div class="col mt-3">
          <p class="text-muted">🎉 No orders found! Add a new order to get started.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>
