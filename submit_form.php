<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "portfolio_db";

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$nameErr = $emailErr = $messageErr = "";
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    
    if (empty($name)) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($name);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white spaces allowed";
        }
    }
    
    
    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    
    if (empty($message)) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($message);
    }
    
    if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
        $sql = "INSERT INTO contact_data (Name, Email, Message) VALUES ('$name', '$email', '$message')";
        
        if ($connection->query($sql) === TRUE) {
            echo "Data inserted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}

$connection->close();
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
