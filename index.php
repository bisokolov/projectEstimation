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
        .index-content {
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
    <div class="index-content">
        <img src="estimate-icon.png">     
        <h1>Project Estimation</h1>
        <div class="action-btns">
            <a href="registration.php" class="button">Create User</a>    
            <a href="login.php" class="button">Log In</a>
        </div>
    </div>
</body>
</html>