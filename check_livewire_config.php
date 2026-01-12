<?php
$html = file_get_contents('http://localhost/traderscap/admin/login');

// Look for Livewire config
if (preg_match('/window\.livewire\s*=\s*({[^}]+})/i', $html, $matches)) {
    echo "Livewire config found:\n";
    echo $matches[1] . "\n\n";
}

// Look for data-update-uri
if (preg_match('/data-update-uri=["\']([^"\']+)["\']/i', $html, $matches)) {
    echo "data-update-uri found:\n";
    echo $matches[1] . "\n\n";
}

// Look for meta tags
preg_match_all('/<meta[^>]+>/i', $html, $metaMatches);
foreach ($metaMatches[0] as $meta) {
    if (stripos($meta, 'livewire') !== false || stripos($meta, 'csrf') !== false) {
        echo "Relevant meta: $meta\n";
    }
}
