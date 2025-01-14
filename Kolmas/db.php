<?php 
    try {
        $pdo = new PDO('sqlite:db.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        die("An error occurred: " . $e->getMessage());
    }
?>