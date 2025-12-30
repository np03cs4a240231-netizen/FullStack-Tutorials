<?php
require 'db.php';

$id = $_GET['id'];

// Get current student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $stmt = $pdo->prepare("UPDATE students SET name=?, email=?, course=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['course'], $id]);
    header('Location: index.php');
    exit;
}
?>

<h1>Edit Student</h1>
<form method="POST">
    Name: <input type="text" name="name" value="<?= $student['name'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $student['email'] ?>" required><br><br>
    Course: <input type="text" name="course" value="<?= $student['course'] ?>" required><br><br>
    <button type="submit">Update</button>
</form>
<br>
<a href="index.php">Back to List</a>