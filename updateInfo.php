<?php
// updateInfo.php - Server-side validation and data processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    // Validate input
    $errors = [];
    if (empty($firstName) || !preg_match("/^[A-Za-z]+$/", $firstName)) {
        $errors[] = "Invalid or empty first name.";
    }
    if (empty($lastName) || !preg_match("/^[A-Za-z]+$/", $lastName)) {
        $errors[] = "Invalid or empty last name.";
    }
    if (empty($phone) || !preg_match("/^\d{3}-\d{3}-\d{4}$/", $phone)) {
        $errors[] = "Invalid or empty phone number. Format: xxx-xxx-xxxx.";
    }
    if (empty($email) || !preg_match("/^[A-Za-z0-9]+@[A-Za-z]+\.(com|edu)$/", $email)) {
        $errors[] = "Invalid or empty email address.";
    }

    if (!empty($errors)) {
        echo "<h2>Errors found:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='userInfo.html'>Go back to the form</a>";
        exit;
    }
}
