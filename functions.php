<?php

function formatName($name) {
    return ucwords(strtolower(trim($name)));
}

function validateEmail($email) {
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email address.");
    }
    return $email;
}

function cleanSkills($string) {
    $string = trim($string);
    if (empty($string)) {
        throw new Exception("Skills cannot be empty.");
    }
    // Remove extra commas/spaces, convert to array, trim each
    $skills = array_map('trim', explode(',', $string));
    $skills = array_filter($skills); // remove empty
    if (empty($skills)) {
        throw new Exception("At least one skill is required.");
    }
    return $skills;
}

function saveStudent($name, $email, $skillsArray) {
    $line = $name . "|" . $email . "|" . implode(",", $skillsArray) . PHP_EOL;
    $result = file_put_contents('students.txt', $line, FILE_APPEND | LOCK_EX);
    if ($result === false) {
        throw new Exception("Failed to save student data.");
    }
}

function uploadPortfolioFile($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Upload error: " . $file['error']);
    }

    if ($file['size'] > 2 * 1024 * 1024) { // 2MB
        throw new Exception("File exceeds 2MB limit.");
    }

    $allowed = ['pdf' => 'application/pdf', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!array_key_exists($ext, $allowed)) {
        throw new Exception("Invalid file type. Only PDF, JPG, PNG allowed.");
    }

    // Optional: stricter MIME check
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if ($mime !== $allowed[$ext]) {
        throw new Exception("File MIME type mismatch.");
    }

    // Rename using string functions: timestamp + random + original ext
    $newName = time() . '_' . rand(1000, 9999) . '.' . $ext;

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception("Failed to create uploads directory.");
        }
    }

    $dest = $uploadDir . $newName;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        throw new Exception("Failed to move uploaded file.");
    }

    return $newName; // return new filename if needed
}

?>