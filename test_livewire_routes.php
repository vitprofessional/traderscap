<?php
// Test if the route actually exists and what it returns
$ch = curl_init();

// Try the route WITH /traderscap
curl_setopt($ch, CURLOPT_URL, 'http://localhost/traderscap/livewire/update');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['test' => 'data']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Requested-With: XMLHttpRequest'
]);

$response1 = curl_exec($ch);
$code1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "POST to http://localhost/traderscap/livewire/update\n";
echo "Status: $code1\n";
echo "Response: " . substr($response1, 0, 200) . "\n\n";

// Try the route WITHOUT /traderscap
curl_setopt($ch, CURLOPT_URL, 'http://localhost/livewire/update');
$response2 = curl_exec($ch);
$code2 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "POST to http://localhost/livewire/update\n";
echo "Status: $code2\n";
echo "Response: " . substr($response2, 0, 200) . "\n";

curl_close($ch);
