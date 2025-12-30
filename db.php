<?php
$pdo = new PDO('mysql:host=localhost;dbname=school_db;', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>