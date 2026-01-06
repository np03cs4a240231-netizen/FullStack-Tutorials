<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Handle theme change
if($_SERVER['REQUEST_METHOD'] === "POST") {
    $theme = $_POST['theme'];
    // Set cookie for 30 days
    setcookie('theme', $theme, time() + (86400 * 30), "/");
    // Redirect to refresh and apply theme
    header("Location: preference.php");
    exit;
}

// Get current theme from cookie
$currentTheme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Apply theme CSS
if($currentTheme === 'dark') {
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
    <title>Theme Preferences</title>
    <style>
        body {
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
            font-family: Arial, sans-serif;
            transition: all 0.3s ease;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .nav {
            margin-bottom: 30px;
        }
        a {
            color: <?php echo $linkColor; ?>;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .form-group {
            margin: 20px 0;
        }
        select {
            padding: 8px;
            border-radius: 4px;
            margin-left: 10px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .theme-example {
            margin-top: 30px;
            padding: 20px;
            border: 2px solid <?php echo $linkColor; ?>;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
        
        <h2>Theme Preferences</h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Select Theme:</label>
                <select name="theme">
                    <option value="light" <?php echo $currentTheme === 'light' ? 'selected' : ''; ?>>Light Mode</option>
                    <option value="dark" <?php echo $currentTheme === 'dark' ? 'selected' : ''; ?>>Dark Mode</option>
                </select>
            </div>
            
            <button type="submit">Save Theme</button>
        </form>
        
        <div class="theme-example">
            <h3>Theme Preview:</h3>
            <p>This is how text will appear in <?php echo $currentTheme; ?> mode.</p>
            <p>Background color: <?php echo $bgColor; ?></p>
            <p>Text color: <?php echo $textColor; ?></p>
        </div>
        
        <p><small>Theme preference will be saved for 30 days using cookies.</small></p>
    </div>
</body>
</html>