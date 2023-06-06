<?php
session_start();

require_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->registerUser($username, $password)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Registration failed.";
    }
}
