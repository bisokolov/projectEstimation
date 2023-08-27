<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Project</title>

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
        button {
            display: block;
            padding: 10px 20px;
            margin: 20px 0;
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

        form {
            margin-top: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }
    </style>

<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="estimate-icon.png"> 
                <h3>Estimation App</h3>
            </div>
            <div class="back-button">
                <a href="dashboard.php">Back to Dashboard</a>
            </div>
        </div>
    </header>

    <main>
        <h1>Create a New Project</h1>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="projectName">Project Name:</label>
            <input type="text" id="projectName" name="projectName" required>

            <label for="projectDescription">Project Description:</label>
            <textarea id="projectDescription" name="projectDescription" rows="4" required></textarea>

            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>

            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" required>

            <button type="submit" name="createProject">Create Project</button>
        </form>
    </main>

    <?php
    session_start();
    include('dbconnection.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["createProject"])) {
        $projectName = $_POST["projectName"];
        $projectDescription = $_POST["projectDescription"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
    

        if (empty($projectName) || empty($projectDescription)) {
            echo "Please fill out all fields.";
        } else {
            $sql = "INSERT INTO projects (project_name, project_description, start_date, end_date) VALUES ('$projectName', '$projectDescription', '$startDate', '$endDate')";

            if ($connection->query($sql) === TRUE) {
                echo "Project created successfully!";

                $projectId = $connection->insert_id;

                $userId = $_SESSION['user_id'];
                $sql = "INSERT INTO user_projects (user_id, project_id, project_name) VALUES ('$userId', '$projectId', '$projectName')";
                $connection->query($sql);

                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

            $connection->close();
        }
    }
    ?>
</body>
</html>