<?php
include('dbconnection.php');
include('calendarClass.php');

if (isset($_GET['active_month'])) {
    $activeMonth = $_GET['active_month'];
} else {
    $activeMonth = date('Y-m');
}

$calendar = new Calendar($activeMonth);

$prevMonth = date('Y-m', strtotime($activeMonth . ' -1 month'));
$nextMonth = date('Y-m', strtotime($activeMonth . ' +1 month'));

$tasks = [];
$firstDayOfMonth = date('Y-m-01', strtotime($activeMonth));
$lastDayOfMonth = date('Y-m-t', strtotime($activeMonth));

$projectId = $_GET['project_id'];

$tasksSql = "SELECT * FROM tasks 
             WHERE project_id = '$projectId' 
             AND ((start_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
             OR (end_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
             OR (start_date <= '$firstDayOfMonth' AND end_date >= '$lastDayOfMonth'))";
//echo "Debug: SQL Query: $tasksSql<br>"; 
$tasksResult = $connection->query($tasksSql);
if (!$tasksResult) {
    echo "Error executing SQL query: " . $connection->error;
}

if ($tasksResult->num_rows > 0) {
    while ($task = $tasksResult->fetch_assoc()) {
        $tasks[] = $task;
    }
}

foreach ($tasks as $task) {
    $calendar->add_event($task['task_name'], $task['start_date'], $task['duration']);
    //echo "Added task: {$task['task_name']}";
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Calendar</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="calendar.css" rel="stylesheet" type="text/css">
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
        .content{
            width: 760px
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

       .navtop{
            background-color: rgba(59, 70, 86, 0.3);
       }
       .navtop div a{
            color: rgba(59, 70, 86, 1);
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
        <h1>Event Calendar</h1>
        <nav class="navtop">
            <div>
                <a href="calendar.php?project_id=<?= $projectId ?>&active_month=<?= $prevMonth ?>">Previous</a>
                <a href="calendar.php?project_id=<?= $projectId ?>&active_month=<?= $nextMonth ?>">Next</a>
                
            </div>
        </nav>
        <div class="content home">
            <?=$calendar?>
        </div>
    </main>
</body>
</html>