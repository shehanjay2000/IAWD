<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="tab-5.css">
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
    <main>
        <div class="container_two">
            <h2>List of products</h2>
            <a class= 'btn btn-primary' href="create.php" role="button">New Product </a>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        
                        $host = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "textiledb";
                        
                        // Create connection
                        $conn = new mysqli($host, $username, $password, $dbname);
                        
                        // Check connection
                        if ($conn->connect_error) {
                            echo "Connection failed: " . $conn->connect_error;
                        }


                        //read all rows from the database
                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);

                        if (!$result){
                            die("Invalid query: ".$conn->error);
                        }
                        
                        //read data of each row
                        while($row = $result->fetch_assoc()){
                            echo"
                                <tr>
                                    <td>$row[id]</td>
                                    <td>$row[product_name]</td>
                                    <td>$row[description]</td>
                                    <td>$row[price]</td>
                                    <td>$row[category]</td>
                                    <td>$row[date_added]</td>
                                    <td>
                                        <a class='btn btn-primary btn-sm' href='/IAWD/dashboard/tab-5/edit.php?id=$row[id]'>Edit</a>
                                        <a class= 'btn btn-danger btn-sm' href='/IAWD/dashboard/tab-5/delete.php?id=$row[id]'>Delete</a>

                                    </td>
                                </tr>
                            ";
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
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>

                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Shehan</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../tab-1/images/profile-1.jpg">
                    </div>
                </div>

            </div>
        </div>

</div>

        <script src="tab-5.js"></script>
</body>
</html>