<?php
include('dbconnection.php');

if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];
} else {
    echo "Task ID not provided.";
    exit;
}

$sql = "SELECT * FROM tasks WHERE id = '$taskId'";
$taskResult = $connection->query($sql);

if ($taskResult->num_rows > 0) {
    $task = $taskResult->fetch_assoc();
} else {
    echo "Task not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTaskName = $_POST['task_name'];
    $newStatus = $_POST['status'];
    $newAssignedUser = $_POST['assigned_user'];
    $newAssignedStage = $_POST['assigned_stage'];
    $newStartDate = $_POST['start_date'];
    $newEndDate = $_POST['end_date'];
    $newEstimation = $_POST['estimation'];

    $newDuration = null;
    if (!empty($newStartDate) && !empty($newEndDate)) {
        $startDate = new DateTime($newStartDate);
        $endDate = new DateTime($newEndDate);
        $interval = $startDate->diff($endDate);
        $newDuration = $interval->days;
    }

    $sql = "UPDATE tasks SET task_name = '$newTaskName', duration = '$newDuration', estimation = '$newEstimation', status = '$newStatus', assigned = '$newAssignedUser', start_date = '$newStartDate', end_date = '$newEndDate' WHERE id = '$taskId'";

    $connection->query($sql);

    $sql = "UPDATE tasks SET stage_id = '$newAssignedStage' WHERE id = '$taskId'";

    $connection->query($sql);

    header("Location: project.php?id=" . $task['project_id']);
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(128, 163, 255, 0.3);
        }
        header{
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 18px 50px -10px;
            background-color:#f4f5fa;
        }
        .logo{
            display: flex;
        }
        header a, header h3{
            color: #2d3e50;
        }
        .header-content {
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
            padding: 10px;
            margin: 0 auto;
            width: 100%;
            max-width: 800px;
            justify-content:  space-between;
        }
        img{
            width: 50px;
            height: 40px;
            margin: 10px;
        }

        main {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f4f5fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        h1 {
            margin-top: 0;
        }

        form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[name="estimation"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #80a3ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover, .back-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            background-color: #80a3ff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            
        }

       .back-button a{
            text-decoration: none;
            color: white; 
            width: 110px;
       }
        
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="estimate-icon.png"> 
                <h3>Estimation App</h3>    
            </div>
            <div class="back-button">
                <a href="project.php?id=<?php echo $task['project_id'] ?>">Back to Project</a>
            </div>
        </div>
    </header>

    <main>
        <h1>Edit Task</h1>

        <form method="post" action="editTask.php?task_id=<?php echo $taskId; ?>">
            <label for="task_name">Task Name:</label>
            <input type="text" name="task_name" value="<?php echo $task['task_name']; ?>"><br>

            <label for="task_description">Task Description:</label>
            <textarea name="task_description"><?php echo $task['task_description']; ?></textarea><br>

            <label for="status">Status:</label>
            <select name="status">
                <option value="Open" <?php if ($task['status'] == 'Open') echo 'selected'; ?>>Open</option>
                <option value="In Progress" <?php if ($task['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                <option value="Done" <?php if ($task['status'] == 'Done') echo 'selected'; ?>>Done</option>
            </select><br>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?php echo $task['start_date']; ?>"><br>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?php echo $task['end_date']; ?>"><br>


            <label for="assigned_user">Assign to User:</label>
            <select name="assigned_user">
                <option value="">Select User</option>
                <?php

                $sql = "SELECT id, username 
                            FROM users 
                            WHERE id IN (
                            SELECT user_id FROM user_projects WHERE project_id = '{$task['project_id']}'
                            )";
                $usersResult = $connection->query($sql);

                while ($userRow = $usersResult->fetch_assoc()) {
                    $selected = ($task['assigned'] == $userRow['id']) ? 'selected' : '';
                    echo "<option value='{$userRow['id']}' $selected>{$userRow['username']}</option>";
                }
                ?>
            </select><br>

            <label for="assigned_stage">Assign to Stage:</label>
            <select name="assigned_stage">
                <option value="">Select Stage</option>
                <?php
                $sql = "SELECT id, stage_name 
                        FROM stages 
                        WHERE project_id = '{$task['project_id']}'";
                $stagesResult = $connection->query($sql);

                while ($stageRow = $stagesResult->fetch_assoc()) {
                    $selected = ($task['stage_id'] == $stageRow['id']) ? 'selected' : '';
                    echo "<option value='{$stageRow['id']}' $selected>{$stageRow['stage_name']}</option>";
                }
                ?>
            </select><br>

            <label for="estimation">Estimation(in hours):</label>
            <input type="number" name="estimation" value="<?php echo $task['estimation']; ?>">

            <button type="submit" class="button save-button">Save</button>
        </form>
    </main>
</body>
</html>

<?php
$connection->close();
?>
