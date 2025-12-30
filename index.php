<?php
require 'db.php';

// Get all students
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll();
?>

<h1>Student List</h1>
<a href="create.php">Add New Student</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Action</th>
    </tr>
    
    <?php foreach($students as $student): ?>
    <tr>
        <td><?= $student['id'] ?></td>
        <td><?= $student['name'] ?></td>
        <td><?= $student['email'] ?></td>
        <td><?= $student['course'] ?></td>
        <td>
            <a href="edit.php?id=<?= $student['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>