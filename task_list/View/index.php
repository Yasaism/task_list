<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'Task.php';

$task = new Task();
$tasks = $task->getAllTasks($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task_id'])) {
        // Delete task
        $task->deleteTask($_POST['task_id']);
        header("Location: index.php");
        exit();
    } elseif (isset($_POST['title'])) {
        // Update task
        $task->updateTask($_POST['task_id'], $_POST['title'], $_POST['description'], $_POST['completed']);
        header("Location: index.php");
        exit();
    } else {
        // Create task
        $task->createTask($_POST['title'], $_POST['description'], $_SESSION['user_id']);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>What to do</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 8px;
            width: 300px;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 8px;
        }

        .task-container {
            background-color: #f2f2f2;
            padding: 16px;
            border-radius: 4px;
        }

        .task-container input[type="text"],
        .task-container textarea {
            width: 200px;
        }

        .task-container select {
            width: 100px;
            margin-right: 8px;
        }

        .task-container button {
            margin-left: 8px;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        .logout-link {
            float: right;
        }
    </style>
</head>
<body>
    <h1>What to do</h1>

    <form method="post" action="index.php">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <button type="submit">Add Task</button>
    </form>

    <h2>Your Tasks</h2>

    <?php if (count($tasks) > 0): ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <div class="task-container">
                        <form method="post" action="index.php">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <input type="text" name="title" value="<?php echo $task['title']; ?>" required><br>
                            <textarea name="description"><?php echo $task['description']; ?></textarea><br>
                            <select name="completed">
                                <option value="0" <?php echo $task['completed'] ? '' : 'selected'; ?>>Incomplete</option>
                                <option value="1" <?php echo $task['completed'] ? 'selected' : ''; ?>>Complete</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                        <form method="post" action="index.php" style="display: inline;">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>

    <a class="logout-link" href="logout.php">Logout</a>
</body>
</html>
