<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function execute(array $credentials): string
    {
        // Find with email in database
        $user = User::where('email', $credentials['email'])->first();

        // Does not match the hash in the database.
        if (!$user || !Hash::check($credentials['password'], $user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password.'],
            ]);
        }

        // Generating a token
        $tokenResult = $user->createToken('mobile_app');

        // For return to the client
        return $tokenResult->plainTextToken;
    }
}