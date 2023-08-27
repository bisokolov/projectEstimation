<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
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

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin: 20px 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
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
    <?php
        include('dbconnection.php');

        $projectId = $_GET['project_id'];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $taskName = $_POST["taskName"];
            $taskDescription = $_POST["taskDescription"];

            $sql = "INSERT INTO tasks (project_id, task_name, task_description) VALUES ('$projectId', '$taskName', '$taskDescription')";

            if ($connection->query($sql) === TRUE) {
                header("Location: project.php?id=$projectId");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }

        $connection->close();
    ?>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="estimate-icon.png"> 
                <h3>Estimation App</h3>
            </div>
            <div class="back-button">
                <a href="project.php?id=<?php echo $projectId; ?>">Back to Project</a>
            </div>   
        </div>
    </header>

    <main>
        <h1>Add Task</h1>

        <form action="<?php echo $_SERVER['PHP_SELF'] . '?project_id=' . $projectId; ?>" method="post">
            <label for="taskName">Task Name:</label>
            <input type="text" id="taskName" name="taskName" required>

            <label for="taskDescription">Task Description:</label>
            <textarea id="taskDescription" name="taskDescription" rows="4" required></textarea>

            <button type="submit">Add Task</button>
        </form>
    </main>
</body>
</html>