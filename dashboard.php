<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            width: 150px
        }
        img{
            width: 50px;
            height: 40px;
            margin: 10px;
        }
        h1{
            text-align: center;
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

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        a.project-link {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        a.project-link:hover {
            text-decoration: underline;
        }

        a.create-project-link {
            display: block;
            background-color: #80a3ff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        a.create-project-link:hover {
            background-color: #0056b3;
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
            <a href="index.php">Log out</a>
        </div>
    </header>
    
    <main>
        <h1>Welcome to Your Dashboard</h1>

        <h2>Your Projects</h2>
        <?php
        include('dbconnection.php');
        session_start();

        $userId = $_SESSION['user_id'];
        $sql = "SELECT * FROM user_projects WHERE user_id = '$userId'";
        $result = $connection->query($sql);


        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li><a class='project-link' href='project.php?id={$row['project_id']}'>{$row['project_name']}</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No projects found.";
        }

        $connection->close();
        ?>
        <a class="create-project-link" href="createProject.php">Create a New Project</a>
    </main>
</body>
</html>