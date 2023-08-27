<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Login</title>
    <style>
         body{
            display: flex;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: rgba(128, 163, 255, 0.3);
        }
        .login-content{
            width: 230px;
            display: flex;
            flex-direction: column;
            background-color: #edf3fa;
            padding: 40px;
            border-radius: 20px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 25px 50px -12px;
        }
        h2{
            text-align: center;
        }
        form{
            display: flex;
            flex-direction: column;
            padding:10px 20px;
        }

        input {
            margin: 10px 0;
        }
        button{
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
    </style>
</head>
<body>
    <div class="login-content"> 
        <h2>Login to Your Account</h2>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>


<?php
session_start();

include('dbconnection.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $connection->query($sql);
    

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid username or password";
        }
    } else {
        $message = "Invalid username or password";
    }

    echo $message;

    $connection->close();
}
?>

