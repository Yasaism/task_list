<?php

require_once 'Database.php';

class Task
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllTasks($userId)
    {
        $query = "SELECT * FROM tasks WHERE user_id = :user_id";
        $params = array(':user_id' => $userId);

        return $this->db->executeQuery($query, $params);
    }

    public function createTask($title, $description, $userId)
    {
        $query = "INSERT INTO tasks (title, description, user_id) VALUES (:title, :description, :user_id)";
        $params = array(
            ':title' => $title,
            ':description' => $description,
            ':user_id' => $userId
        );

        $this->db->executeNonQuery($query, $params);
    }

    public function updateTask($taskId, $title, $description, $completed)
    {
        $query = "UPDATE tasks SET title = :title, description = :description, completed = :completed WHERE id = :id";
        $params = array(
            ':id' => $taskId,
            ':title' => $title,
            ':description' => $description,
            ':completed' => $completed
        );

        $this->db->executeNonQuery($query, $params);
    }

    public function deleteTask($taskId)
    {
        $query = "DELETE FROM tasks WHERE id = :id";
        $params = array(':id' => $taskId);

        $this->db->executeNonQuery($query, $params);
    }
}
