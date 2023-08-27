<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: rgba(128, 163, 255, 0.3);
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            background-color: #80a3ff;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
        }

        .action-btns{            
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .content {
            display: flex;
            flex-direction: column;
            background-color: #edf3fa;
            padding: 40px;
            border-radius: 20px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
        }
        img{
            width: 100px;
            margin: 10px auto
        }
    </style>
</head>
<body>
<div class="content">

        <?php
        include('dbconnection.php');
        if (isset($_POST['export'])) {

            $projectId = $_GET['project_id'];

            // Create a file with the project name
            $sql = "SELECT project_name FROM projects WHERE id = '$projectId'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
            $projectName = $row['project_name'];

            if (!file_exists('mindman')) {
                mkdir('mindman');
            }


            $filePath = 'mindman/' . $projectName . '.txt';
            file_put_contents($filePath, '');
            file_put_contents($filePath, '@startmindmap' . PHP_EOL, FILE_APPEND);
            file_put_contents($filePath, "* $projectName" . PHP_EOL, FILE_APPEND);

            $sql = "SELECT id, stage_name FROM stages WHERE project_id = '$projectId'";
            $result = $connection->query($sql);
            while ($row = $result->fetch_assoc()) {
                $stageId = $row['id'];
                $stageName = $row['stage_name'];
                file_put_contents($filePath, "** $stageName" . PHP_EOL, FILE_APPEND);

                $tasksSql = "SELECT task_name FROM tasks WHERE stage_id = '$stageId'";
                $tasksResult = $connection->query($tasksSql);

                while ($taskRow = $tasksResult->fetch_assoc()) {
                    $taskName = $taskRow['task_name'];
                    file_put_contents($filePath, "*** $taskName" . PHP_EOL, FILE_APPEND);
                }
        
            }

            file_put_contents($filePath, '@endmindmap' . PHP_EOL, FILE_APPEND);

            header("Location: project.php?id=$projectId");
            exit();
        }
        ?>

        <form method="post">
            <button type="submit" name="export" class="button">Export</button>
            <input type="hidden" name="project_id" value="<?php echo $_GET['project_id']; ?>">
        </form>
    </div>
</body>
</html>