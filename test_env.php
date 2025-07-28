<?php

// Simple environment test
echo "Environment Test:\n";
echo "APP_DEBUG: " . (env('APP_DEBUG') ? 'true' : 'false') . "\n";
echo "RAZORPAY_KEY: " . env('RAZORPAY_KEY') . "\n";
echo "RAZORPAY_SECRET: " . env('RAZORPAY_SECRET') . "\n";

// Check if .env file exists
echo ".env file exists: " . (file_exists('.env') ? 'yes' : 'no') . "\n";

// Try reading .env file directly
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    echo "RAZORPAY keys in .env file:\n";
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'RAZORPAY') !== false) {
            echo "  " . $line . "\n";
        }
        if (strpos($line, 'APP_DEBUG') !== false) {
            echo "  " . $line . "\n";
        }
    }
}
?>