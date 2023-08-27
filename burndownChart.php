<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burndown Chart</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
            <a href="project.php?id=<?php echo $_GET['project_id'] ?>">Back to Project</a>
            </div>
        </div>
    </header>

    <main>
        <div id="burndownChart" style="width: 100%; height: 400px;"></div>
    </main>
</body>

<script type="text/javascript">
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        <?php
        include('dbconnection.php');

        $projectId = $_GET['project_id'];
        $sql = "SELECT SUM(estimation) AS total_estimation 
                FROM tasks 
                WHERE stage_id IN (SELECT id FROM stages WHERE project_id = '$projectId')";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $totalEffort = $row['total_estimation'];

        $sql = "SELECT start_date, end_date FROM projects WHERE id = '$projectId'";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $startDate = $row['start_date'];
        $endDate = $row['end_date'];
        $numberOfDays = (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24) + 1;
        $dailyWork = $totalEffort / $numberOfDays;
        $idealRemainingEffort = $totalEffort;

        echo "var data = [['Date', 'Work Remaining', 'Ideal Work Remaining'],";
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $sql = "SELECT SUM(estimation) AS done_work
                              FROM tasks
                              WHERE stage_id IN (SELECT id FROM stages WHERE project_id = '$projectId')
                              AND end_date <= '$currentDate'
                              AND status = 'Done'";
            $workDoneResult = $connection->query($sql);
            $workDoneRow = $workDoneResult->fetch_assoc();
            $workDone = $workDoneRow['done_work'];
        
            $remainingEffort = $totalEffort - $workDone;
            $idealRemainingEffort = $idealRemainingEffort - $dailyWork;
            echo "['" . $currentDate . "', " . $remainingEffort . ", " . $idealRemainingEffort . "],";
            $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
            $numberOfDays--;
        }
        echo "];";
        ?>

        var chartData = google.visualization.arrayToDataTable(data);

        var options = {
            title: 'Burndown Chart',
            hAxis: { title: 'Date' },
            vAxis: { title: 'Work Remaining' },
            curveType: 'line',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('burndownChart'));
        chart.draw(chartData, options);
    }
</script>
</html>

