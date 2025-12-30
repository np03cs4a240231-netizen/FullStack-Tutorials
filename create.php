<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['course']]);
    header('Location: index.php');
    exit;
}
?>

<h1>Add Student</h1>
<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Course: <input type="text" name="course" required><br><br>
    <button type="submit">Save</button>
</form>
<br>
<a href="index.php">Back to List</a>