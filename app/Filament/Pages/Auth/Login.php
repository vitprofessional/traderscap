<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            Log::info('Login attempt started', [
                'email' => $this->data['email'] ?? 'not provided',
                'has_password' => isset($this->data['password']),
            ]);
            
            $response = parent::authenticate();
            
            if ($response) {
                Log::info('Login successful', [
                    'user' => auth()->user()?->email,
                ]);
            }
            
            return $response;
            
        } catch (TooManyRequestsException $exception) {
            Log::warning('Login rate limited', [
                'seconds' => $exception->secondsUntilAvailable,
            ]);
            throw $exception;
            
        } catch (ValidationException $exception) {
            Log::info('Login validation failed', [
                'errors' => $exception->errors(),
            ]);
            throw $exception;
            
        } catch (\Exception $exception) {
            Log::error('Login failed with exception', [
                'error' => $exception->getMessage(),
                'class' => get_class($exception),
            ]);
            throw $exception;
        }
    }
}
