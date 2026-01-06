<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Handle logout
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Get theme from cookie or set default
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Apply CSS based on theme
if($theme === 'dark') {
    $bgColor = '#222';
    $textColor = '#fff';
    $linkColor = '#4dabf7';
} else {
    $bgColor = '#fff';
    $textColor = '#333';
    $linkColor = '#007bff';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <style>
        body {
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
            padding: 20px;
        }
        a {
            color: <?php echo $linkColor; ?>;
            text-decoration: none;
            margin: 0 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .nav {
            background: <?php echo $theme === 'dark' ? '#333' : '#f8f9fa'; ?>;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 30px;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="preference.php">Theme Settings</a>
            <a href="?logout=true" class="logout-btn">Logout</a>
        </div>
        
        <div class="welcome">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        
        <div>
            <h3>Student Grade Portal Features:</h3>
            <ul>
                <li>Session-based authentication</li>
                <li>Password hashing for security</li>
                <li>Theme customization using cookies</li>
                <li>Secure database operations</li>
            </ul>
        </div>
        
        <div>
            <p>Current Theme: <strong><?php echo ucfirst($theme); ?> Mode</strong></p>
        </div>
    </div>
</body>
</html>