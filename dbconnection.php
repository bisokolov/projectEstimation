<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "project_estimation";

try
{
    $connection = mysqli_connect($server, $username, $password, $database);
    
}catch (Exception $errormsg)
{
    echo $errormsg->getMessage();
}

?>