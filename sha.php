<?php
function loadHashes($files) {
    $hashMap = [];
    foreach ($files as $file) {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            list($string, $hash) = explode(":", $line);
            $hashMap[trim($hash)] = trim($string);
        }
    }
    return $hashMap;
}

$hashFiles = ['sha1_list.txt', 'sha224_list.txt', 'sha256_list.txt'];
$hashMap = loadHashes($hashFiles);

$searchedHash = $_POST['hash'] ?? '';
$result = $hashMap[$searchedHash] ?? null;

echo "<h2>Result for hash: <code>" . htmlspecialchars($searchedHash) . "</code></h2>";

if ($result) {
    echo "<p><strong>Original string:</strong> " . htmlspecialchars($result) . "</p>";
} else {
    echo "<p style='color:red;'>Hash not found in database.</p>";
}

echo '<form method="POST" action="sha.php">
        <input type="text" name="hash" required>
        <input type="submit" value="Lookup another">
      </form>';
?>
