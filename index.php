<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1>Good Morning!</h1>
    <form method="POST" action="main.php">
        <input name="">
        <button type="submit">Send</button>
    </form>
</body>
</html>

<?php
    if($_POST){
        $body = file_get_contents('php://input');


        $conn = new mysqli('localhost', 'kalle', 'qwerty');
        if($conn->connect_error){
            die('Connection failed');
        } else {
            echo "Connection successful";
        }
    };
?>