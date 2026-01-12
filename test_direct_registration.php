<?php

// Simple test to check registration flow
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

// Get the database instance
$app->booted(function ($app) {
    // Check current user count
    $userCount = \App\Models\User::count();
    echo "Current user count: " . $userCount . "\n";
    
    // Try to create a user directly
    try {
        $user = \App\Models\User::create([
            'name' => 'Direct Test User',
            'email' => 'directtest' . time() . '@example.com',
            'password' => bcrypt('testpassword123'),
        ]);
        
        echo "Successfully created user: ID=" . $user->id . ", Email=" . $user->email . "\n";
        
        // Verify it was actually saved
        $found = \App\Models\User::find($user->id);
        if ($found) {
            echo "User was verified in database\n";
        } else {
            echo "ERROR: User not found after creation!\n";
        }
    } catch (\Exception $e) {
        echo "Error creating user: " . $e->getMessage() . "\n";
        echo "Exception: " . get_class($e) . "\n";
    }
    
    // Final user count
    $finalCount = \App\Models\User::count();
    echo "Final user count: " . $finalCount . "\n";
    
    $app->make('Illuminate\Contracts\Console\Kernel')->call('tinker', [
        '--execute' => 'User::all()->each(fn($u) => echo $u->email . PHP_EOL);'
    ]);
});

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
