<?php include 'database/database.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ordering System</title>
  <link href="statics/css/bootstrap.min.css" rel="stylesheet">
  <script src="statics/js/bootstrap.js"></script>
</head>

<body>
    <div class="container d-flex justify-content-center mt-5">
      <div class="col-8">
        <div class="row">
          <p class="display-5 fw-bold">Ordering System</p>
        </div>
        <div class="row">
          <a href="views/add_order.php" class="btn btn-outline-dark btn-sm">Add New Order</a>
        </div>
        <?php
          $res = $conn->query("SELECT * FROM orders");
        ?>
        <?php if($res->num_rows > 0): ?>
            <?php while($row = $res->fetch_assoc()): ?>
            <div class="row border rounded p-3 my-3">
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
                    <a href="views/update_order.php?id=<?=$row['id'];?>" class="btn btn-sm btn-warning">Edit</a>
                </div>
                <div class="row my-1">
                    <a href="handlers/delete_order_handler.php?id=<?=$row['id'];?>" class="btn btn-sm btn-danger">Delete</a>
                </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="row border rounded p-3 my-3 text-center">
                <div class="col mt-3">
                    <p class="text-muted">🎉 No orders found! Add a new order to get started.</p>
                </div>
            </div>
      <?php endif; ?>
      </div>
    </div>
</body>

</html>