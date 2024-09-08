<?php
    include 'connect.php';

    // Sign-up functionality
    if(isset($_POST['signup'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
       
        // Check if email already exists
        $checkEmail = "SELECT * FROM registration WHERE email = '$email'";
        $result = $conn->query($checkEmail);

        if($result->num_rows > 0){
            echo "Email address already exists!";
        } else {
            // Insert the new user with default type as 'user'
            $insertQuery = "INSERT INTO registration(name, email, password, type)
                            VALUES('$name', '$email', '$password', 'user')";

            if($conn->query($insertQuery) === TRUE){
                header("location: index.php");
            } else {
                echo "Error: ".$conn->error;
            }
        }
    }

    // Sign-in functionality
    if(isset($_POST['sign-in'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Check if the user exists and get their type
        $sql = "SELECT * FROM registration WHERE LOWER(email) = LOWER('$email') AND password = '$password'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            session_start();
            $row = $result->fetch_assoc();

            // Check if the user is an admin
            if($row['type'] === 'admin'){
                $_SESSION['email'] = $row['email'];
                header("Location: ../dashboard/tab-1/tab-1.php"); // Admin dashboard
            } else {
                // Redirect to a different page for regular users
                $_SESSION['email'] = $row['email'];
                header("Location: ../dashboard/home/home.php"); 
            }
            exit();
        } else {
            echo "Not Found, incorrect email or password.";
        }
    }
?>
