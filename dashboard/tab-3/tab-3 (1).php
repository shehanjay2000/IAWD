<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-3.css">
    <title>Inventory Management</title>
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
            <a href="../home/home.php" id="home">
                <span class="material-icons-sharp">home</span><h3>Home</h3>
            </a>
            <a href="../tab-1/tab-1.php" id="tab1">
                <span class="material-icons-sharp">dashboard</span><h3>Dashboard</h3>
            </a>
            <a href="../tab-2/tab-2.php" id="tab2">
                <span class="material-icons-sharp">person_outline</span><h3>Staff</h3>
            </a>
            <a href="../tab-3/tab-3.php" id="tab3">
                <span class="material-icons-sharp">inventory</span><h3>Inventory</h3>
            </a>
            <a href="../tab-4/tab-4.php" id="tab4">
                <span class="material-icons-sharp">email</span>
                <h3>Orders</h3><span class="message-count">27</span>
            </a>
            <a href="../tab-5/tab-5.php" id="tab5">
                <span class="material-icons-sharp">inventory_2</span><h3>Products</h3>
            </a>
            <a href="../tab-6/tab-6.php" id="tab6">
                <span class="material-icons-sharp">local_shipping</span><h3>Suppliers</h3>
            </a>
            <a href="../tab-7/tab-7.php" id="tab7">
                <span class="material-icons-sharp">person_3</span><h3>Customers</h3>
            </a>
            <a href="../tab-8/tab-8.php" id="tab8">
                <span class="material-icons-sharp">payments</span><h3>Payment</h3>
            </a>
            <a href="../tab-1/logout.php">
                <span class="material-icons-sharp">logout</span><h3>Logout</h3>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="containerForm">
            <h2>List of Inventory</h2>
            <a class="btn btn-primary" href="create.php" role="button">New Inventory</a>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $host = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "textiledb";

                    // Create connection
                    $conn = new mysqli($host, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Read all rows from the inventory table
                    $sql = "SELECT * FROM inventory";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    // Fetch and display data
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['product_id']}</td>
                            <td>{$row['item']}</td> <!-- Ensure the field is lowercase -->
                            <td>{$row['quantity_in_stock']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['date_added']}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='edit.php?id={$row['id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='delete.php?id={$row['id']}'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
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
                    <p>Hey, <b>Shehan</b></p><small class="text-muted">Admin</small>
                </div>
                <div class="profile-photo">
                    <img src="images/profile-1.jpg" alt="Profile Photo">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="tab-3.js"></script>
</body>
</html>
