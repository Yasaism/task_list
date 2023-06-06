<?php
session_start();

require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->loginUser($username, $password)) {
        $_SESSION['user_id'] = $user->getUserId($username);
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
