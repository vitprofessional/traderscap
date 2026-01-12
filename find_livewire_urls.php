<?php
$html = file_get_contents('http://localhost/traderscap/admin/login');

// Find all occurrences of "livewire" in the HTML to see what URLs are being set
preg_match_all('/["\']([^"\']*livewire[^"\']*)["\']/', $html, $matches);

echo "All Livewire-related URLs/paths in HTML:\n";
$unique = array_unique($matches[1]);
foreach ($unique as $match) {
    echo "  - $match\n";
}

// Look for JavaScript that might be setting the endpoint
if (preg_match('/Livewire\s*\.\s*start\s*\([^)]*\)/is', $html, $m)) {
    echo "\n\nLivewire.start() call:\n";
    echo $m[0] . "\n";
}

// Look for data attributes
if (preg_match_all('/data-[^=]*=["\']([^"\']*livewire[^"\']*)["\']/i', $html, $dataMatches)) {
    echo "\n\nData attributes with livewire:\n";
    foreach ($dataMatches[0] as $attr) {
        echo "  $attr\n";
    }
}
