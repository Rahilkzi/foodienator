


<?php
header('Content-Type: text/plain');
echo "=== SERVER DEBUG INFORMATION ===\n\n";

// Check PHP configuration
echo "PHP Version: " . phpversion() . "\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n\n";

// Check file paths
$paths_to_check = [
    'assets/css/style.css',
    'public/uploads/category/thumb/',
    'application/config/config.php'
];

echo "=== FILE SYSTEM CHECK ===\n";
foreach ($paths_to_check as $path) {
    $exists = file_exists($path);
    $readable = is_readable($path);
    echo "$path: " . ($exists ? 'EXISTS' : 'MISSING') . " | " . ($readable ? 'READABLE' : 'NOT READABLE') . "\n";
}

// Check CSS file content
echo "\n=== CSS FILE CHECK ===\n";
$css_content = file_get_contents('assets/css/style.css');
if ($css_content) {
    echo "CSS file size: " . strlen($css_content) . " bytes\n";
    echo "First 200 chars: " . substr($css_content, 0, 200) . "\n";
} else {
    echo "CSS file is empty or cannot be read\n";
}

// Check for errors
echo "\n=== ERROR CHECK ===\n";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test base URL
echo "Base URL: " . base_url() . "\n";
echo "Current URL: " . current_url() . "\n";

echo "\n=== ASSET PATH CHECK ===\n";
// Temporary file to check asset paths
echo "<h2>Asset Path Check</h2>";

$assets = [
    'bootstrap.css' => 'assets/css/bootstrap.min.css',
    'style.css' => 'assets/css/style.css',
    'jquery.js' => 'assets/js/jquery-3.6.0.min.js',
    'bootstrap.js' => 'assets/js/bootstrap.min.js'
];

foreach ($assets as $name => $path) {
    $full_path = FCPATH . $path;
    $exists = file_exists($full_path);
    $readable = is_readable($full_path);
    $url = base_url($path);
    
    echo "<p><strong>$name</strong> ($path):<br>";
    echo "Local path: $full_path<br>";
    echo "Exists: " . ($exists ? 'YES' : 'NO') . "<br>";
    echo "Readable: " . ($readable ? 'YES' : 'NO') . "<br>";
    echo "URL: <a href='$url' target='_blank'>$url</a><br>";
    
    if ($exists) {
        echo "Size: " . filesize($full_path) . " bytes<br>";
    }
    echo "</p><hr>";
}

?>