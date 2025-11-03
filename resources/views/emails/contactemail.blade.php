<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$server = $_SERVER['SERVER_NAME'];

// Determine file path based on server
if ($server === '127.0.0.1') {
    $filePath = $root . '/mailers/contactemail.html';
} elseif ($server === 'getdemo.in') {
    $filePath = $root . '/anviksha/mailers/contactemail.html';
} else {
    $filePath = $root . '/mailers/contactemail.html';
}

// Check if file exists
if (!file_exists($filePath)) {
    die('Email template not found.');
}

// Load template
$file = file_get_contents($filePath);

// Replace placeholders with actual data (optional: escape values)
$placeholders = [
    '#name' => htmlspecialchars($data['name'] ?? ''),
    '#email' => htmlspecialchars($data['email'] ?? ''),
    '#subject' => htmlspecialchars($data['subject'] ?? ''),
    '#message' => nl2br(htmlspecialchars($data['message'] ?? '')),
];

foreach ($placeholders as $key => $value) {
    $file = str_replace($key, $value, $file);
}

// Output final content
echo $file;

?>
