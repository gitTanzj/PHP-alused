<?php 
    $host = 'localhost';
    $username = 'root';
    $password = 'qwerty';
    $dbname = 'phpa';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
        die("Connection failed: " . $e->getMessage());
    }
?>