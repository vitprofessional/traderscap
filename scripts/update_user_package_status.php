<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$id = $argv[1] ?? 3;
$status = $argv[2] ?? 'cancelled';

$updated = \App\Models\UserPackage::whereId($id)->update(['status' => $status, 'ends_at' => date('Y-m-d H:i:s')]);

echo "updated: {$updated}\n";
