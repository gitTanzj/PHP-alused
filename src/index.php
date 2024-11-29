<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP projekt</title>
    <link href="./css/output.css" rel="stylesheet">
</head>

<body class="flex justify-center w-full">
    <div class="flex justify-center w-full h-full">
        <h1 class="text-3xl font-bold">Hello</h1>
        <form>
            <label>username</label>
            <input name="username" type="text">
        </form>
    </div>
</body>

</html>

<?php

if ($_POST) {
    $body = file_get_contents('//');

    $db_server = 'localhost';
    $db_user = 'root';
    $db_pass = "";
    $db_name = "users";
    $conn = "";

    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
;
?>