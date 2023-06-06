<?php

require_once 'Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function registerUser($username, $password)
    {
        // Check if username exists
        $query = "SELECT * FROM users WHERE username = :username";
        $params = array(':username' => $username);
        $result = $this->db->executeQuery($query, $params);

        if (count($result) > 0) {
            return false; // Username already exists
        }

        // Insert new user
        $query = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $params = array(
            ':username' => $username,
            ':password' => $hashedPassword
        );

        $this->db->executeNonQuery($query, $params);
        return true;
    }

    public function loginUser($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $params = array(':username' => $username);
        $result = $this->db->executeQuery($query, $params);

        if (count($result) === 1) {
            $hashedPassword = $result[0]['password'];

            if (password_verify($password, $hashedPassword)) {
                return true; // Login successful
            }
        }

        return false; // Invalid credentials
    }

    public function getUserId($username)
    {
        $query = "SELECT id FROM users WHERE username = :username";
        $params = array(':username' => $username);
        $result = $this->db->executeQuery($query, $params);

        return $result[0]['id'];
    }
}
