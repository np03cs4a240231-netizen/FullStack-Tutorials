<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

require 'db.php';
$error = "";

if($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $student_id = $_POST['student_id'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM students WHERE student_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$student_id]);
        $student = $stmt->fetch();

        if(!$student) {
            $error = "Student ID not found!";
        } else {
            $hashedPassword = $student['password_hash'];
            if(password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['logged_in'] = true; // Fixed typo: trre -> true
                $_SESSION['student_id'] = $student['student_id'];
                $_SESSION['username'] = $student['full_name'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid password!";
            }
        }
    } catch(PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Student Login</h2>
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>