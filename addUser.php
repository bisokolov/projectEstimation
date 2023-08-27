<?php
include('dbconnection.php');

$projectId = $_GET['project_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];

    $sql = "SELECT username FROM users WHERE id = '$userId'";
    $usernameResult = $connection->query($sql);

    if ($usernameResult->num_rows > 0) {
        $usernameRow = $usernameResult->fetch_assoc();
        $username = $usernameRow['username'];

        $sql = "SELECT project_name FROM projects WHERE id = '$projectId'";
        $projectNameResult = $connection->query($sql);
        $projectNameRow = $projectNameResult->fetch_assoc();
        $projectName = $projectNameRow['project_name']; 

        $sql = "INSERT INTO user_projects (user_id, project_id, project_name) VALUES ('$userId', '$projectId', '$projectName')";

        if ($connection->query($sql) === TRUE) {
            header("Location: project.php?id=" . $projectId);
            exit;
        } else {
            echo "Error: " . $connection->error;
        }
    }
}

$sql = "SELECT users.id, users.username
        FROM users
        WHERE users.id NOT IN (
        SELECT user_id FROM user_projects WHERE project_id = '$projectId')";

$availableUsersResult = $connection->query($sql);

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add User to Project</title>
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
        select {
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
        <h1>Add User to Project</h1>
        <form method="post">
            <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">

            <label for="user_id">Select User:</label>
            <select name="user_id">
                <?php

                while ($row = $availableUsersResult->fetch_assoc()) {
                    $userId = $row['id'];
                    $userName = $row['username'];

                    echo "<option value='$userId'>$userName</option>";
                }

                if ($availableUsersResult->num_rows == 0) {
                    echo "<option value='' disabled>No available users</option>";
                }
                ?>
            </select><br>

            <button type="submit">Add User</button>
        </form>
    </main>
</body>
</html>