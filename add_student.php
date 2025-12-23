<?php
require 'header.php';
require 'functions.php';

$errors = [];
$name = $email = $skills = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name   = trim($_POST['name'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $skills = trim($_POST['skills'] ?? '');

    // Validation
    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }

    if ($skills === '') {
        $errors['skills'] = 'Skills are required.';
    }

    // If no errors, save data
    if (empty($errors)) {
        $skillsArray = cleanSkills($skills);
        saveStudent($name, $email, $skillsArray);

        // Reset fields after success
        $name = $email = $skills = '';
        $success = 'Student added successfully!';
    }
}
?>

<h2>Add Student Information</h2>

<?php if (!empty($success)): ?>
    <p class="success"><?= $success ?></p>
<?php endif; ?>

<form method="post">

    <label>Name:</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"><br>
    <?php if (isset($errors['name'])): ?>
        <span class="error"><?= $errors['name'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($email) ?>"><br>
    <?php if (isset($errors['email'])): ?>
        <span class="error"><?= $errors['email'] ?></span><br>
    <?php endif; ?>
    <br>

    <label>Skills (comma-separated):</label><br>
    <textarea name="skills"><?= htmlspecialchars($skills) ?></textarea><br>
    <?php if (isset($errors['skills'])): ?>
        <span class="error"><?= $errors['skills'] ?></span><br>
    <?php endif; ?>
    <br>

    <button type="submit">Add Student</button>
</form>

<?php require 'footer.php'; ?>
