<?php
// Database connection (modify with your DB credentials)
$host = 'localhost';
$db = 'your_db_name';
$user = 'your_username';
$pass = 'your_password';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query all films, ordered by category
$sql = "SELECT category, title FROM films ORDER BY category, title";
$result = $conn->query($sql);

// Process results into an associative array
$categories = [];

while ($row = $result->fetch_assoc()) {
    $category = $row['category'];
    $title = $row['title'];
    if (!isset($categories[$category])) {
        $categories[$category] = [];
    }
    $categories[$category][] = $title;
}

// Sort categories alphabetically
ksort($categories);

// Write to text file
$file = fopen("filmData.txt", "w");

foreach ($categories as $category => $titles) {
    $line = $category . ":" . count($titles) . ":" . implode(",", $titles) . ";\n";
    fwrite($file, $line);
}

fclose($file);

// Output as HTML table
echo "<table border='1'>";
echo "<tr><th>Category</th><th>Number of Films</th><th>Films</th></tr>";
foreach ($categories as $category => $titles) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($category) . "</td>";
    echo "<td>" . count($titles) . "</td>";
    echo "<td>" . htmlspecialchars(implode(", ", $titles)) . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>
