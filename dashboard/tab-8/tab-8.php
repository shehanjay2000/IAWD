<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-8.css">
    <title>Payment Management</title>
    <style>
        /* Additional CSS for Payment Management */
        .main-content {
            margin-left: 250px; /* Space for sidebar */
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
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
        <div class="main-content">
            <h2>Payment Management System</h2>

            <!-- Payment Form -->
            <form action="tab-8.php" method="POST" id="paymentForm">
                <input type="hidden" id="edit_id" name="edit_id" value="">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required placeholder="Enter amount">

                <label for="payment_type">Payment Type:</label>
                <select id="payment_type" name="payment_type" required>
                    <option value="income">Income</option>
                    <option value="expense">Expense</option>
                </select>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" placeholder="Enter description" required>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="category">Category:</label>
                <input type="text" id="category" name="category" placeholder="Enter category" required>

                <input type="submit" value="Add Payment">
            </form>

            <!-- Payment Records Table -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Database connection
                    $conn = new mysqli('localhost', 'root', '', 'textiledb'); // Update with your database credentials

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Handle form submission for adding/editing payments
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $amount = $_POST['amount'];
                        $payment_type = $_POST['payment_type'];
                        $description = $_POST['description'];
                        $date = $_POST['date'];
                        $category = $_POST['category'];
                        $edit_id = $_POST['edit_id'];

                        if ($edit_id) {
                            // Update existing payment
                            $stmt = $conn->prepare("UPDATE payments SET amount = ?, payment_type = ?, description = ?, date = ?, category = ? WHERE id = ?");
                            $stmt->bind_param("issssi", $amount, $payment_type, $description, $date, $category, $edit_id);
                        } else {
                            // Add new payment
                            $stmt = $conn->prepare("INSERT INTO payments (amount, payment_type, description, date, category) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("issss", $amount, $payment_type, $description, $date, $category);
                        }

                        $stmt->execute();
                        $stmt->close();
                    }

                    // Fetch payment records
                    $sql = "SELECT id, amount, payment_type, description, date, category FROM payments";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['amount']}</td>
                                    <td>{$row['payment_type']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['date']}</td>
                                    <td>{$row['category']}</td>
                                    <td>
                                        <button onclick='editPayment({$row['id']}, {$row['amount']}, \"{$row['payment_type']}\", \"{$row['description']}\", \"{$row['date']}\", \"{$row['category']}\")'>Edit</button>
                                        <button onclick='deletePayment({$row['id']})'>Delete</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<script>
    function editPayment(id, amount, payment_type, description, date, category) {
        document.getElementById('edit_id').value = id; // Store the ID of the record to be edited
        document.getElementById('amount').value = amount;
        document.getElementById('payment_type').value = payment_type;
        document.getElementById('description').value = description;
        document.getElementById('date').value = date;
        document.getElementById('category').value = category;
    }

    function deletePayment(id) {
        if (confirm("Are you sure you want to delete this payment?")) {
            window.location.href = "delete.php?id=" + id; // Redirect to delete script
        }
    }
</script>

</body>
</html>
