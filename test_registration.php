<?php

// Test script for registration
$url = 'http://127.0.0.1:8000/admin/register';

// First, get the CSRF token from the registration page
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=test');

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "Registration page status: " . $http_code . "\n";

// Extract CSRF token from the HTML
if (preg_match('/name="csrf_token"\s+value="([^"]+)"/', $response, $matches)) {
    $csrf_token = $matches[1];
    echo "CSRF Token found: " . substr($csrf_token, 0, 20) . "...\n";
    
    // Now attempt to register
    $post_data = array(
        'name' => 'Test User ' . time(),
        'email' => 'testuser' . time() . '@example.com',
        'password' => 'password123!',
        'password_confirmation' => 'password123!',
        'csrf_token' => $csrf_token
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=test');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    echo "\nRegistration attempt status: " . $http_code . "\n";
    if ($http_code == 302 || $http_code == 301) {
        echo "Redirect detected - likely successful registration\n";
    }
    
    // Check if user was created
    echo "\nChecking database...\n";
} else {
    echo "CSRF token not found in response\n";
    echo "Response sample: " . substr($response, 0, 500) . "\n";
}

curl_close($ch);
?>
