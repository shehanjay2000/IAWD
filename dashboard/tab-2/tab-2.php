<?php
$conn = new mysqli("localhost", "root", "", "textiledb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $employee_name = $_POST['employee_name'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sql = "INSERT INTO employees (employee_name, role, email, phone) VALUES ('$employee_name', '$role', '$email', '$phone')";
        if ($conn->query($sql) === TRUE) {
            $message = "New employee added successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $employee_name = $_POST['employee_name'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $sql = "UPDATE employees SET employee_name='$employee_name', role='$role', email='$email', phone='$phone' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Employee updated successfully.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM employees WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        $message = "Employee deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
}
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-2.css">
    <title>HR Management</title>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }
        .modal-content {
            background-color: #fff;
            margin: 20% auto;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-button:hover {
            color: #000;
        }
        .modal form {
            display: flex;
            flex-direction: column;
        }
        .modal input {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border 0.3s;
        }
        .modal input:focus {
            border: 1px solid #007BFF;
        }
        .modal button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .modal button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 600px) {
            .modal-content {
                margin: 10% auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
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

        <main>
            <div class="form_container">
                <h1>HR Management</h1>
                <?php if ($message): ?>
                    <div class="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
                <form method="POST" class="form">
                    <h2>Add New Employee</h2>
                    <input type="text" name="employee_name" placeholder="Employee Name" required>
                    <input type="text" name="role" placeholder="Role" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Phone" required>
                    <button type="submit" name="create" class="btn">Add Employee</button>
                </form>
                <input type="text" id="search-bar" placeholder="Search by Employee Name" onkeyup="searchEmployees()">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['employee_name'] ?></td>
                                <td><?= $row['role'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['phone'] ?></td>
                                <td>
                                    <button class="btn btn-success" onclick="openModal(<?= $row['id'] ?>, '<?= $row['employee_name'] ?>', '<?= $row['role'] ?>', '<?= $row['email'] ?>', '<?= $row['phone'] ?>')">Update</button>
                                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this employee?');">
                                        <button class="btn btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="dark-mode-toggle">
                    <span class="material-icons-sharp">dark_mode</span>
                    <input type="checkbox" id="dark-mode-checkbox">
                </div>
            </div>
        </div>

        <div class="modal" id="modal">
            <div class="modal-content">
                <span class="close-button" id="close-modal">&times;</span>
                <form method="POST">
                    <input type="hidden" name="id" id="modal-id">
                    <h2>Update Employee</h2>
                    <input type="text" name="employee_name" id="modal-employee-name" required>
                    <input type="text" name="role" id="modal-role" required>
                    <input type="email" name="email" id="modal-email" required>
                    <input type="text" name="phone" id="modal-phone" required>
                    <button type="submit" name="update" class="btn">Update Employee</button>
                </form>
            </div>
        </div>

        <script>
            const modal = document.getElementById("modal");
            const closeModal = document.getElementById("close-modal");
            const searchBar = document.getElementById("search-bar");

            function openModal(id, name, role, email, phone) {
                modal.style.display = "block";
                document.getElementById("modal-id").value = id;
                document.getElementById("modal-employee-name").value = name;
                document.getElementById("modal-role").value = role;
                document.getElementById("modal-email").value = email;
                document.getElementById("modal-phone").value = phone;
            }

            closeModal.onclick = function() {
                modal.style.display = "none";
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            function searchEmployees() {
                const filter = searchBar.value.toLowerCase();
                const rows = document.querySelectorAll("tbody tr");
                rows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    if (name.includes(filter)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
        </script>
    </body>
</html>

<?php
$conn->close();
?>
