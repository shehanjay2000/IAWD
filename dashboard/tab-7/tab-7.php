<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-7.css">
    <title>Customer List</title>
</head>
<body>
<div class="container">
    <!-- Side Bar -->
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
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>
            </a>
            <a href="../tab-1/tab-1.php" id="tab1">
                <span class="material-icons-sharp">dashboard</span>
                <h3>Dashboard</h3>
            </a>
            <a href="../tab-2/tab-2.php" id="tab2">
                <span class="material-icons-sharp">person_outline</span>
                <h3>Employee</h3>
            </a>
            <a href="../tab-3/tab-3.php" id="tab3">
                <span class="material-icons-sharp">inventory</span>
                <h3>Inventory</h3>
            </a>
            <a href="../tab-4/tab-4.php" id="tab4">
                <span class="material-icons-sharp">email</span>
                <h3>Orders</h3>
                <span class="message-count">27</span>
            </a>
            <a href="../tab-5/tab-5.php" id="tab5">
                <span class="material-icons-sharp">inventory_2</span>
                <h3>Products</h3>
            </a>
            <a href="../tab-6/tab-6.php" id="tab6">
                <span class="material-icons-sharp">local_shipping</span>
                <h3>Suppliers</h3>
            </a>
            <a href="../tab-7/tab-7.php" id="tab7">
                <span class="material-icons-sharp">person_3</span>
                <h3>Customers</h3>
            </a>
            <a href="../tab-8/tab-8.php" id="tab8">
                <span class="material-icons-sharp">payments</span>
                <h3>Payment</h3>
            </a>
            <a href="../tab-1/logout.php">
                <span class="material-icons-sharp">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>
    <!-- End of Sidebar -->

    <!-- Start of Main Content -->
    <main>
        <div class="my-5">
            <h2>List of Customers</h2>
            <a class="btn btn-primary mb-3" href="/IAWD/dashboard/tab-7/create.php" role="button">New Customer</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>                
                        <th>Address</th>
                        <th>Country</th>
                        <th>Gender</th>
                        <th>Action</th>
                    </tr> 
                </thead>
                <tbody> 
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "textiledb";
                    $connection = new mysqli($servername, $username, $password, $database);

                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error); 
                    }

                    $sql = "SELECT * FROM customers"; 
                    $result = $connection->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }

                    while ($row = $result->fetch_assoc()) { 
                        // Escape output for safety
                        $customer_name = htmlspecialchars($row['customer_name']);
                        $email = htmlspecialchars($row['email']);
                        $phone = htmlspecialchars($row['phone']);
                        $address = htmlspecialchars($row['address']);
                        $country = htmlspecialchars($row['country']);
                        $gender = htmlspecialchars($row['gender']);
                        
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$customer_name}</td>
                            <td>{$email}</td>
                            <td>{$phone}</td>
                            <td>{$address}</td>
                            <td>{$country}</td>
                            <td>{$gender}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/IAWD/dashboard/tab-7/edit.php?id={$row['id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='/IAWD/dashboard/tab-7/delete.php?id={$row['id']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }

                    // Close connection
                    $connection->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<script src="tab-7.js"></script>
</body>
</html>
