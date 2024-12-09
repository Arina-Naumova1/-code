<?php
session_start();

require_once("includes/connection.php");
include("includes/header.php");

if (isset($_SESSION["session_username"])) {
    header("Location: intropage.php");
    exit();
}

if ($conn->connect_error) {
    die("Соединение не удалось: " . $conn->connect_error);
}

if (isset($_POST["login"])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        $stmt = $conn->prepare("SELECT password FROM usertbl WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dbpassword);
            $stmt->fetch();
            
            if (password_verify($password, $dbpassword)) {
                $_SESSION['session_username'] = $username;     
                header("Location: intropage.php");
                exit();
            } else {
                echo "Invalid username or password!";
            }
        } else {
            echo "Invalid username or password!";
        }
        
        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}
$conn->close();
?>