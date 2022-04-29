<?php

try {
    $conn = new PDO('mysql:host=localhost;dbname=food_db;charset=utf8', 'root', '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],);
} catch (Exception $exc) {
    die('Error: ' . $exc->getMessage());
}

