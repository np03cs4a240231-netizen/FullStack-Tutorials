<?php
// Initialize variables
$name = $email = $password = $confirm_password = "";
$errors = [];
$success_message = "";

// Process form when submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Trim inputs
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");

    // Validation
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "At least 6 characters required.";
    } elseif (!preg_match('/[@#$%^&*!]/', $password)) {
        $errors['password'] = "Password must include a special character.";
    }

    if ($confirm_password !== $password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Continue if no errors
    if (empty($errors)) {

        $json_file = "users.json";

        if (!file_exists($json_file)) {
            $errors['file'] = "users.json file not found.";
        } else {
            $json_data = file_get_contents($json_file);

            if ($json_data === false) {
                $errors['file'] = "Error reading users.json.";
            } else {

                $users = json_decode($json_data, true);

                if (!is_array($users)) {
                    $users = [];
                }

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Create user data array
                $new_user = [
                    "name" => $name,
                    "email" => $email,
                    "password" => $hashed_password
                ];

                // Add to list
                $users[] = $new_user;

                // Write back to JSON
                $save = file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));

                if ($save === false) {
                    $errors['file'] = "Error writing to users.json.";
                } else {
                    $success_message = "Registration successful!";
                    $name = $email = $password = $confirm_password = "";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            background: #f3f5f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 380px;
            background: #ffffff;
            padding: 25px 30px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #d3d3d3;
            border-radius: 6px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 3px rgba(0,123,255,0.3);
        }

        button {
            width: 100%;
            background: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #0056d6;
        }

        .error {
            color: #d90000;
            font-size: 13px;
            margin-top: 4px;
        }

        .success {
            background: #d4f8d4;
            color: #0b6b0b;
            padding: 12px;
            text-align: center;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid #0b6b0b;
        }
    </style>

</head>
<body>

<div class="container">

    <h2>User Registration</h2>

    <?php if (!empty($success_message)) : ?>
        <div class="success"><?= $success_message ?></div>
    <?php endif; ?>

    <form method="POST" action="">

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
            <div class="error"><?= $errors['name'] ?? "" ?></div>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
            <div class="error"><?= $errors['email'] ?? "" ?></div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
            <div class="error"><?= $errors['password'] ?? "" ?></div>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password">
            <div class="error"><?= $errors['confirm_password'] ?? "" ?></div>
        </div>

        <button type="submit">Register</button>

        <div class="error"><?= $errors['file'] ?? "" ?></div>

    </form>
</div>

</body>
</html>
