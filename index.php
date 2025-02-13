<?php
session_start();

// ✅ Redirect users to login if they are not logged in
if (!isset($_SESSION['user']) && !isset($_COOKIE['user'])) {
    header("Location: views/login.php");
    exit();
}

// ✅ Automatically login user from cookies if session is not set
if (!isset($_SESSION['user']) && isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
}

// Include database connection
include 'database/database.php';

// ✅ Get filter values from URL parameters
$user_id = $_SESSION['user'];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

// ✅ Base query
$sql = "SELECT * FROM orders WHERE user_id = ?";
$types = "i";
$params = [$user_id];

if (!empty($search)) {
    $sql .= " AND customer_name LIKE ?";
    $types .= "s";
    $params[] = "%$search%";
}

if (!empty($status) && $status !== "All") {
    $sql .= " AND status = ?";
    $types .= "s";
    $params[] = $status;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordering System</title>
    <link href="statics/css/bootstrap.min.css" rel="stylesheet">
    <script src="statics/js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        padding: 20px;
    }
    .container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 100%;
        max-width: 900px;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .header h1 {
        font-weight: bold;
        font-size: 2.5rem;
        background: linear-gradient(45deg, #ff758c, #ff7eb3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .btn-custom {
        background: linear-gradient(45deg, #845ec2, #d65db1);
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 15px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        background: linear-gradient(45deg, #d65db1, #845ec2);
        transform: scale(1.05);
    }
    .search-box, .filter-box {
        border-radius: 8px;
        padding: 10px;
        font-size: 1rem;
        border: 2px solid #ff7eb3;
        transition: all 0.3s ease;
    }
    .search-box:focus, .filter-box:focus {
        border-color: #ff758c;
        box-shadow: 0 0 5px rgba(255, 117, 140, 0.5);
    }
    .order-card {
        border-left: 6px solid #ff758c;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        background: #f8f9fa;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .order-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .btn-warning, .btn-danger {
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        padding: 8px 12px;
        text-decoration: none;
    }
    .btn-warning {
        background: #ffcc00;
        border: none;
        transition: background 0.3s ease;
    }
    .btn-warning:hover {
        background: #ffb700;
    }
    .btn-danger {
        background: #ff6b6b;
        border: none;
        transition: background 0.3s ease;
    }
    .btn-danger:hover {
        background: #ff4b4b;
    }
</style>

</head>

<body>
    <div class="container">
        <div class="text-center">
            <p class="display-5 fw-bold">📦 Ordering System</p>
        </div>
        
        <!-- ✅ Navigation Buttons -->
        <div class="row mb-4 text-center">
            <div class="col">
                <a href="views/add_order.php" class="btn btn-custom btn-sm">➕ Add New Order</a>
                <a href="handlers/logout.php" class="btn btn-outline-danger btn-sm">🚪 Logout</a>
            </div>
        </div>

        <!-- ✅ Search & Filter Section -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="🔍 Search by Customer Name..." value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-4">
                <select id="filterStatus" class="form-control">
                    <option value="All" <?= ($status == 'All' || empty($status)) ? 'selected' : '' ?>>📌 All Status</option>
                    <option value="Pending" <?= ($status == 'Pending') ? 'selected' : '' ?>>🟡 Pending</option>
                    <option value="Processing" <?= ($status == 'Processing') ? 'selected' : '' ?>>🟠 Processing</option>
                    <option value="Completed" <?= ($status == 'Completed') ? 'selected' : '' ?>>🟢 Completed</option>
                </select>
            </div>
        </div>

        <div id="orderList">
            <?php if ($res->num_rows > 0) : ?>
                <?php while ($row = $res->fetch_assoc()) : ?>
                    <div class="row order-card">
                        <div>
                            <h5 class="fw-bold">📦 Order #<?= htmlspecialchars($row['user_order_number']); ?></h5>
                            <p class="text-secondary"><strong>👤 Customer:</strong> <?= htmlspecialchars($row['customer_name']); ?></p>
                            <p class="text-secondary"><strong>📦 Product:</strong> <?= htmlspecialchars($row['product_name']); ?></p>
                            <p class="text-secondary"><strong>🔢 Quantity:</strong> <?= htmlspecialchars($row['quantity']); ?></p>
                            <p class="fw-bold">
                                <small>📌 <strong>Status:</strong> <?= htmlspecialchars($row['status']); ?></small>
                            </p>
                            <div class="row my-1 d-flex">
                                <div class="col-auto">
                                    <a href="views/update_order.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                    <a href="handlers/delete_order_handler.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-danger">🗑️ Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="row text-center">
                    <div class="col mt-3">
                        <p class="text-muted">🎉 No orders found! Try a different search.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        function updateOrders() {
            var search = $("#search").val();
            var status = $("#filterStatus").val();
            window.location.href = "index.php?search=" + encodeURIComponent(search) + "&status=" + encodeURIComponent(status);
        }

        // ✅ Trigger search only when pressing Enter
        $("#search").keypress(function (e) {
            if (e.which === 13) { // 13 = Enter key
                e.preventDefault(); // Stop form submission
                updateOrders();
            }
        });

        // ✅ Status filter updates instantly
        $("#filterStatus").on("change", updateOrders);
    });
</script>


</body>
</html>
