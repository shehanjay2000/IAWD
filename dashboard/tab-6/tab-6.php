<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-6.css">
    <title>Document</title>
</head>
<body>
<div class="container">
        <!--side bar -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="../tab-1/images/clothes.png" alt="logo">
                    <h2>Textile<span class="danger">Company</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                        </span>
                </div>
            </div>

            <div class="sidebar">
                <a href="../home/home.php" id="home">
                    <span class="material-icons-sharp">
                        home
                    </span>
                    <h3>Home</h3>
                </a>
                <a href="../tab-1/tab-1.php" id="tab1">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="../tab-2/tab-2.php" id="tab2">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Staff</h3>
                </a>
                <a href="../tab-3/tab-3.php" id="tab3">
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Inventory</h3>
                </a>
             
                <a href="../tab-4/tab-4.php" id="tab4">
                <span class="material-icons-sharp">
                email
                </span>
                    <h3>Orders</h3>
                    <span class="message-count">27</span>
                </a>
                <a href="../tab-5/tab-5.php" id="tab5">
                    <span class="material-icons-sharp">
                        inventory_2
                    </span>
                    <h3>Products</h3>
                </a>
               
                <a href="../tab-6/tab-6.php" id="tab6">
                    <span class="material-icons-sharp">
                        local_shipping
                    </span>
                    <h3>Suppliers</h3>
                </a>
                <a href="../tab-7/tab-7.php" id="tab7">
                    <span class="material-icons-sharp">
                        person_3
                    </span>
                    <h3>Customers</h3>
                </a>
                <a href="../tab-8/tab-8.php" id="tab8">
                    <span class="material-icons-sharp">
                        payments
                    </span>
                    <h3>Payement</h3>
                </a>
                <a href="../tab-1/logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!--End of sidebar-->

        <!--Start of Main Content --> 

         <!-- Header and New Supplier Button -->
    <h2>List of Suppliers</h2>
    <a class="btn btn-primary" href="/IAWD/dashboard/tab-6/create.php" role="button">New Supplier</a>
    <br>
    
    <!-- Table of Suppliers -->
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>supplier name</th>
                <th>contact info</th>
                <th>address</th>
                <th>product supplied</th>
                <th>email</th>
                <th>Actions</th> <!-- Actions column for Edit/Delete buttons -->
            </tr>
        </thead>
        <tbody>
            <?php
            $servername ="localhost";
            $username ="root";
            $password ="";
            $database ="textiledb";
            
            // Create connection 
            $connection = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($connection->connect_error) {
                die ("Connection failed: " . $connection->connect_error);
            }

            // Read all rows from the suppliers table
            $sql = "SELECT * FROM suppliers";
            $result = $connection->query($sql);

            if (!$result) {
                die ("Invalid query: " . $connection->error);
            }

            // Fetch and display each row from the result
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['supplier_name']}</td>
                    <td>{$row['contact_info']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['product_supplied']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/IAWD/dashboard/tab-6/edit.php?id={$row['id']}'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/IAWD/dashboard/tab-6/delete.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>

</div>

        <script src="tab-6.js"></script>
</body>
</html>