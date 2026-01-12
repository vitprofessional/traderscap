<?php
$html = file_get_contents('http://localhost/traderscap/admin/login');

// Look for base tag
if (preg_match('/<base[^>]+>/i', $html, $matches)) {
    echo "Base tag found:\n";
    echo $matches[0] . "\n\n";
} else {
    echo "No base tag found\n\n";
}

// Look for data-update-uri
if (preg_match('/data-update-uri=["\']([^"\']+)["\']/i', $html, $matches)) {
    echo "data-update-uri: " . $matches[1] . "\n";
}

// Check head section
if (preg_match('/<head>(.*?)<\/head>/is', $html, $matches)) {
    echo "\nFirst 500 chars of <head>:\n";
    echo substr($matches[1], 0, 500) . "\n";
}
