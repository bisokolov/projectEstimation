<!DOCTYPE html>
<html lang="en">

<head>
<script src="https://kit.fontawesome.com/a841266175.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: while;
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
        .header-content a{
            width: 110px
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


        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr {
            height: 40px;
            background-color: rgba(128, 163, 255, 0.3);
        }

        th,
        td {
            height: 100%;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
            border: 1px solid #ddd;
        }

        th {
            background-color: rgba(128, 163, 255, 0.9);
        }

        .toggle-cell {
            background-color: rgba(128, 163, 255, 0.3);
            cursor: pointer;
        }
        .task-row{
            background-color: rgba(128, 163, 255, 0.1);
        }
        .show {
            display: block;
        }
        .plus{
            float: right;
        }
        .button {
            display: inline-block;
            padding: 8px 18px;
            background-color: #80a3ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 12px;
            margin-bottom: 10px
        }
        .button:hover {
            background-color: #0056b3;
        }

        .user-button {
            background-color: #80a3ff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
        }
        a{
            text-decoration: none;
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
        <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            $UserUrl = "dashboard.php?user_id=" . $_SESSION['user_id'];
            echo "<a href=\"$UserUrl\" class=\"user-button\">Current User</a>";
        }
        ?>
        </div>
    </header>

    <main>
        <?php
        include('dbconnection.php');

        $projectId = $_GET['id'];

        $sql = "SELECT * FROM projects WHERE id = '$projectId'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $project = $result->fetch_assoc();
            echo "<h2>{$project['project_name']}</h2>";
            echo "<p>Description: {$project['project_description']}</p>";
        } else {
            echo "Project not found.";
        }

        $connection->close();
        ?>

        <a href="addStage.php?project_id=<?php echo $projectId; ?>" class="button">Add Stage</a>
        <a href="addTask.php?project_id=<?php echo $projectId; ?>" class="button">Add Task</a>
        <a href="addUser.php?project_id=<?php echo $projectId; ?>" class="button">Add User</a>
        <a href="calendar.php?project_id=<?php echo $projectId; ?>" class="button">Calendar</a>
        <a href="burndownChart.php?project_id=<?php echo $projectId; ?>" class="button">Burndow Chart</a>
        <a href="mindMap.php?project_id=<?php echo $projectId; ?>" class="button">Mind Map</a>

        <table>
            <tr>
                <th>Name</th>
                <th>Duration in days</th>
                <th>Estimation in hours</th>
                <th>Status</th>
                <th>Assigned</th>
                <th>Start</th>
                <th>End</th>
                <th>Edit</th>
            </tr>

            <?php
            include('dbconnection.php');

            $sql = "SELECT * FROM stages WHERE project_id = '$projectId'";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($stage = $result->fetch_assoc()) {
                    echo "<tr class='toggle-cell'>";
                    echo "<td>{$stage['stage_name']} <span class='plus'><i class='fa-solid fa-square-plus'></i></span></td>";

                    $stageId = $stage['id'];
                    $sql = "SELECT SUM(duration) AS sum_duration FROM tasks WHERE stage_id = '$stageId'";
                    $stageResult = $connection->query($sql);
                    $stageRow = $stageResult->fetch_assoc();
                    $totalDuration = $stageRow['sum_duration'];
                    echo "<td>{$totalDuration}</td>";

                    $stageId = $stage['id'];
                    $sql = "SELECT SUM(estimation) AS sum_estimation FROM tasks WHERE stage_id = '$stageId' AND status IN ('Open', 'In Progress')";
                    $estimationResult = $connection->query($sql);
                    $estimationRow = $estimationResult->fetch_assoc();
                    $totalEstimation = $estimationRow['sum_estimation'];
                    echo "<td>{$totalEstimation}</td>";

                    //echo "<td>{$stage['duration']}</td>";
                    echo "<td>{$stage['status']}</td>";
                    echo "<td>{$stage['assigned']}</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";

                    //$stageId = $stage['id'];
                    $tasksSql = "SELECT * FROM tasks WHERE stage_id = '$stageId'";
                    $tasksResult = $connection->query($tasksSql);

                    while ($task = $tasksResult->fetch_assoc()) {
                        echo "<tr class='task-row'>";
                        echo "<td>{$task['task_name']}</td>";
                        echo "<td>{$task['duration']}</td>";
                        echo "<td>{$task['estimation']}</td>";
                        echo "<td>{$task['status']}</td>";

                        $assignedUserId = $task['assigned'];
                        $usernameSql = "SELECT username FROM users WHERE id = '$assignedUserId'";
                        $usernameResult = $connection->query($usernameSql);

                        if ($usernameResult->num_rows > 0) {
                            $usernameRow = $usernameResult->fetch_assoc();
                            $assignedUsername = $usernameRow['username'];
                            echo "<td>$assignedUsername</td>";
                        } else {
                            echo "<td>Unassigned</td>";
                        }


                        //echo "<td>{$task['assigned']}</td>";
                        echo "<td>{$task['start_date']}</td>";
                        echo "<td>{$task['end_date']}</td>";
                        echo "<td><a href='editTask.php?task_id={$task['id']}'>Edit</a></td>";
                        echo "</tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='7'>No stages found.</td></tr>";
            }

            //$connection->close();
            ?>
            <tr class="stage-row">
                <td>
                    <span class="stage-toggle unassigned-toggle">Unassigned <span class="plus"><i class="fa-solid fa-square-plus"></i></span>
                </td>
                <td colspan="7"></td>
            </tr>
            <?php
            $unassignedSql = "SELECT * FROM tasks WHERE stage_id = '0' AND project_id = '$projectId'";
            $unassignedResult = $connection->query($unassignedSql);

            if ($unassignedResult->num_rows > 0) {
                while ($unassignedTask = $unassignedResult->fetch_assoc()) {
                    echo "<tr class='task-row unassigned-tasks'>";
                    echo "<td>{$unassignedTask['task_name']}</td>";
                    echo "<td>{$unassignedTask['duration']}</td>";
                    echo "<td>{$unassignedTask['estimation']}</td>";
                    echo "<td>{$unassignedTask['status']}</td>";
                    //echo "<td>{$unassignedTask['assigned']}</td>";
                    $assignedUserId = $unassignedTask['assigned'];
                    $usernameSql = "SELECT username FROM users WHERE id = '$assignedUserId'";
                    $usernameResult = $connection->query($usernameSql);

                    if ($usernameResult === false) {
                        echo "Error: " . mysqli_error($connection);
                    }

                    if ($usernameResult->num_rows > 0) {
                        $usernameRow = $usernameResult->fetch_assoc();
                        $assignedUsername = $usernameRow['username'];
                        echo "<td>$assignedUsername</td>";
                    } else {
                        echo "<td>Unassigned</td>";
                    }


                    echo "<td>{$unassignedTask['start_date']}</td>";
                    echo "<td>{$unassignedTask['end_date']}</td>";
                    echo "<td><a href='editTask.php?task_id={$unassignedTask['id']}'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr class='task-row unassigned-tasks'><td colspan='8'>No unassigned tasks found.</td></tr>";
            }
            ?>
        </table>

    </main>

    <footer>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Script loaded!");
            const toggleCells = document.querySelectorAll(".toggle-cell");

            toggleCells.forEach(function(toggleCell) {
                const toggleButton = toggleCell.querySelector(".plus");

                toggleButton.addEventListener("click", function() {
                    const taskRows = [];
                    let currentRow = toggleCell.nextElementSibling;

                    while (currentRow && currentRow.classList.contains("task-row")) {
                        taskRows.push(currentRow);
                        currentRow = currentRow.nextElementSibling;
                    }

                    taskRows.forEach(function(taskRow) {
                        taskRow.style.display = taskRow.style.display === "none" ? "table-row" : "none";
                    });
                });
            });

            const unassignedToggle = document.querySelector(".unassigned-toggle");
            unassignedToggle.addEventListener("click", function() {
                const unassignedTaskRows = [];
                let currentRow = unassignedToggle.closest("tr").nextElementSibling;

                while (currentRow && currentRow.classList.contains("task-row") && currentRow.classList.contains("unassigned-tasks")) {
                    unassignedTaskRows.push(currentRow);
                    currentRow = currentRow.nextElementSibling;
                }

                unassignedTaskRows.forEach(function(taskRow) {
                    taskRow.style.display = taskRow.style.display === "none" ? "table-row" : "none";
                });
            });
        });
    </script>
</body>
</html>