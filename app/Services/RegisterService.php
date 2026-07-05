<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    public function execute(array $data): string
    {
        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Create entry in users with eloquent ORM
        $user = User::create($data);

        // Generate token for auto access
        $tokenResult = $user->createToken('mobile_app');

        return $tokenResult->plainTextToken;
    }
}