<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "textiledb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = "";

// Handle Create and Update Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $customer_id = $_POST['customer_id'];
        $order_date = $_POST['order_date'];
        $status = $_POST['status'];
        $total_price = $_POST['total_price'];
        $shipping_address = $_POST['shipping_address'];

        $sql = "INSERT INTO orders (customer_id, order_date, status, total_price, shipping_address) 
                VALUES ('$customer_id', '$order_date', '$status', '$total_price', '$shipping_address')";
        if ($conn->query($sql) === TRUE) {
            $message = "New order placed successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $sql = "UPDATE orders SET status='$status' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Order updated successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// Handle Delete Request via GET Request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM orders WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $message = "Order deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}

// Fetch Orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-4.css">
    <title>Order Management</title>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="../tab-1/images/clothes.png" alt="logo">
                    <h2>Textile<span class="danger">Company</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="../tab-1/tab-1.php" id="tab1"><span class="material-icons-sharp">dashboard</span><h3>Dashboard</h3></a>
                <a href="../tab-2/tab-2.php" id="tab2"><span class="material-icons-sharp">person_outline</span><h3>Staff</h3></a>
                <a href="../tab-3/tab-3.php" id="tab3"><span class="material-icons-sharp">inventory</span><h3>Inventory</h3></a>
                <a href="../tab-4/tab-4.php" id="tab4"><span class="material-icons-sharp">email</span><h3>Orders</h3><span class="message-count">27</span></a>
                <a href="../tab-5/tab-5.php" id="tab5"><span class="material-icons-sharp">inventory_2</span><h3>Products</h3></a>
                <a href="../tab-6/tab-6.php" id="tab6"><span class="material-icons-sharp">local_shipping</span><h3>Suppliers</h3></a>
                <a href="../tab-7/tab-7.php" id="tab7"><span class="material-icons-sharp">person_3</span><h3>Customers</h3></a>
                <a href="../tab-8/tab-8.php" id="tab8"><span class="material-icons-sharp">payments</span><h3>Payment</h3></a>
                <a href="../tab-1/logout.php"><span class="material-icons-sharp">logout</span><h3>Logout</h3></a>
            </div>
        </aside>
        <!-- End of Sidebar -->

        <!-- Main Content -->
        <main>
            <div class="form_container">
                <h1>Order Management</h1>
                
                <!-- Display message -->
                <?php if ($message): ?>
                    <div class="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>

                <!-- New Order Form -->
                <form method="POST" class="form">
                    <h2>Place New Order</h2>
                    <input type="number" name="customer_id" placeholder="Customer ID" required>
                    <input type="date" name="order_date" required>
                    <input type="text" name="status" placeholder="Status (e.g., pending, shipped)" required>
                    <input type="number" step="0.01" name="total_price" placeholder="Total Price" required>
                    <input type="text" name="shipping_address" placeholder="Shipping Address" required>
                    <button type="submit" name="create" class="btn">Place Order</button>
                </form>

                <!-- Search Bar -->
                <input type="text" id="search-bar" placeholder="Search by Customer ID" onkeyup="searchOrders()">

                <!-- Orders Table -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer ID</th>
                            <th>Quantity</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Total Price</th>
                            <th>Shipping Address</th>
                            <th>Product ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['customer_id'] ?></td>
                                <td><?= $row['quantity'] ?></td>
                                <td><?= $row['order_date'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= $row['total_price'] ?></td>
                                <td><?= $row['shipping_address'] ?></td>
                                <td><?= $row['product_id'] ?></td>
                                <td>
                                    <!-- Update Form -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <input type="text" name="status" placeholder="Update Status" required>
                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                    </form>

                                    <!-- Delete Button -->
                                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this order?');">
                                        <button class="btn btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Shehan</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../tab-1/images/profile-1.jpg" alt="Profile Photo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="tab-4.js"></script>
</body>
</html>
