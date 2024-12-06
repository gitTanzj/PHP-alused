<?php

if ($_POST) {
    $body = $_POST;
    if (empty($body)) {
        echo "nothing was sent";
    } else {

        try {
            $db = new mysqli('localhost', 'root', 'qwerty', 'users', 3306);

            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            $username = $body["username"];
            $password = $body["password"];
            $id = $db->query('SELECT ID FROM USERS ORDER BY ID DESC LIMIT 1')->num_rows + 1;
            echo $id;

            $sql = 'INSERT INTO USERS (ID, USERNAME, PASSWORD) VALUES (?, ?, ?)';
            $stmt = $db->prepare($sql);
            $stmt->bind_param('sss', $id, $username, $password);
            $stmt->execute();
            $stmt->close();

            header('HTTP/1.1 200 OK');

        } catch (Exception $e) {
            header('HTTP/1.1 500 Server Error');
        }
    }
}
?>