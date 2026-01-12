<?php

// Test script to fetch login page and check for script tags
$url = 'http://localhost/traderscap/admin/login';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status: $httpCode\n\n";

// Find all script tags
preg_match_all('/<script[^>]*src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);

if (!empty($matches[1])) {
    echo "Script sources found:\n";
    foreach ($matches[1] as $src) {
        echo "  - $src\n";
    }
} else {
    echo "No external scripts found\n";
}

// Check for inline scripts
preg_match_all('/<script[^>]*>(?!<\/script>)(.*?)<\/script>/is', $html, $inlineMatches);
if (!empty($inlineMatches[1])) {
    echo "\nInline script count: " . count($inlineMatches[1]) . "\n";
    echo "First inline script (first 200 chars):\n" . substr($inlineMatches[1][0], 0, 200) . "\n";
}
