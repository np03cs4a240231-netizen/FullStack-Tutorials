<?php
require "db.php";
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $password = $_POST['password'];

        // Check if student already exists
        $check_sql = "SELECT * FROM students WHERE student_id = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$student_id]);
        
        if($check_stmt->rowCount() > 0) {
            $error = "Student ID already exists!";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  
            $sql = "INSERT INTO students (student_id, full_name, password_hash) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$student_id, $name, $hashedPassword]);
            $success = "Registration successful! Redirecting to login...";
            header("Refresh:2, url=login.php");
        }
    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <style>
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Student Registration</h2>
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" required><br><br>
        
        <label>Full Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>