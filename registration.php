<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Registration</title>
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
        .registration-content{
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
    <div class="registration-content">
        <h2>Create a new user account</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>




<?php
include('dbconnection.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

    if ($connection->query($sql) === TRUE) {
        $message = "Registration successful";

        header("Location: login.php");
        exit();
    } else {
        $message = "Error: " . $sql . "<br>" . $connection->error;
    }

    echo $message;
}
?>

