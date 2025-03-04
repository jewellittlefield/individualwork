<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

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

    $data = [];
    $filename = 'userInfo.txt';

    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $parts = explode(':', $line);
            if (count($parts) === 4) {
                list($lName, $fName, $ph, $em) = $parts;
                $data[$lName] = "$fName:$ph:$em";
            }
        }
    }

    $data[$lastName] = "$firstName:$phone:$email";

    ksort($data);

    $file = fopen($filename, 'w');
    foreach ($data as $lName => $info) {
        fwrite($file, "$lName:$info\n");
    }
    fclose($file);

    echo "<h2>Data Successfully Saved</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Last Name</th><th>First Name</th><th>Phone</th><th>Email</th></tr>";

    foreach ($data as $lName => $info) {
        $parts = explode(':', $info);
        if (count($parts) === 3) {
            list($fName, $ph, $em) = $parts;
            echo "<tr>";
            echo "<td>" . htmlspecialchars($lName) . "</td>";
            echo "<td>" . htmlspecialchars($fName) . "</td>";
            echo "<td>" . htmlspecialchars($ph) . "</td>";
            echo "<td>" . htmlspecialchars($em) . "</td>";
            echo "</tr>";
        }
    }
    
    echo "</table>";
    echo "<br><a href='userInfo.html'>Go back to the form</a>";
}
?>
