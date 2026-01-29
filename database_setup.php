<?php

echo "\n🏨 Sona Hotel - Automatic Database Setup 🏨\n";
echo "============================================\n\n";

// default values
$host = '127.0.0.1';
$port = '3306';
$user = 'root';
$pass = ''; // Default for XAMPP
$db   = 'sona_hotel';

// Prompt for input
echo "Please enter your database details (press Enter to accept defaults):\n";

$inputHost = readline("Host [$host]: ");
if (!empty($inputHost)) $host = $inputHost;

$inputUser = readline("Username [$user]: ");
if (!empty($inputUser)) $user = $inputUser;

$inputPass = readline("Password [empty]: ");
if ($inputPass !== false && $inputPass !== "") $pass = $inputPass;

try {
    echo "\n🔄 Connecting to MySQL server...\n";
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "🔨 Creating database '$db' if it doesn't exist...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    
    echo "✅ Database '$db' created successfully!\n\n";
    echo "👉 Now you can run: php artisan migrate:seed\n";

} catch (PDOException $e) {
    echo "\n❌ Connection Failed: " . $e->getMessage() . "\n";
    echo "Check your username and password.\n";
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "Tip: XAMPP default is 'root' with NO password.\n";
        echo "Tip: MAMP default is 'root' with password 'root'.\n";
    }
}
