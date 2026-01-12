<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Register extends BaseRegister
{
    protected function handleRegistration(array $data): Model
    {
        // Enable query logging
        DB::enableQueryLog();
        
        // Log the data being submitted
        Log::info('Registration attempt', [
            'data' => $data,
            'has_name' => isset($data['name']),
            'has_email' => isset($data['email']),
            'has_password' => isset($data['password']),
        ]);
        
        try {
            // Attempt to create the user
            $user = $this->getUserModel()::create($data);
            
            // Log successful creation
            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'queries' => DB::getQueryLog()
            ]);
            
            return $user;
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'queries' => DB::getQueryLog()
            ]);
            
            throw $e;
        }
    }
    
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        Log::info('Form data before mutation', ['data' => $data]);
        
        $mutated = parent::mutateFormDataBeforeRegister($data);
        
        Log::info('Form data after mutation', ['data' => $mutated]);
        
        return $mutated;
    }
}
