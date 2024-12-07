<?php

if ($_POST) {
    $body = $_POST;
    if (empty($body)) {
        echo "nothing was sent";
    } else {

        $username = htmlspecialchars($body["username"], ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars($body["password"], ENT_QUOTES, 'UTF-8');

        try {
            $db = mysqli_init();
            mysqli_real_connect($db, 'localhost', 'root', 'qwerty', 'users', 3306);

            if (mysqli_connect_errno()) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $result = mysqli_query($db, 'SELECT ID FROM users ORDER BY ID DESC LIMIT 1');
            if ($row = mysqli_fetch_assoc($result)) {
                $id = (int)$row['ID'] + 1;
            } else {
                $id = 1;
            }
            echo $id;

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (ID, USERNAME, PASSWORD) VALUES (?, ?, ?)';
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, 'iss', $id, $username, $hashedPassword);
            mysqli_stmt_execute($stmt);

            http_response_code(200);
            echo "User created successfully";

            mysqli_stmt_close($stmt);
            mysqli_close($db);
        } catch (Exception $e) {
            echo "". $e->getMessage();
        }
    }
}
?>