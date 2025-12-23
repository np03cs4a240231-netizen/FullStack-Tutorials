<?php 
require 'header.php'; 
?>

<h2>Registered Students</h2>

<?php
if (file_exists('students.txt') && filesize('students.txt') > 0) {
    echo '<ul>';
    foreach (file('students.txt') as $line) {
        if (trim($line) === '') continue;
        [$name, $email, $skillsStr] = explode('|', trim($line), 3);
        $skills = explode(',', $skillsStr);
        echo '<li><strong>Name:</strong> ' . htmlspecialchars($name) . '<br>';
        echo '<strong>Email:</strong> ' . htmlspecialchars($email) . '<br>';
        echo '<strong>Skills:</strong> ' . htmlspecialchars(implode(', ', $skills)) . '</li><br>';
    }
    echo '</ul>';
} else {
    echo '<p>No students registered yet.</p>';
}
?>

<?php require 'footer.php'; ?>