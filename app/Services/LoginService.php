<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function execute(array $credentials): string
    {
        // Находим по email в БД
        $user = User::where('email', $credentials['email'])->first();

        // Не совпадает с хэшем в БД
        if (!$user || !Hash::check($credentials['password'], $user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['Неверный email или пароль.'],
            ]);
        }

        // Генерируем токен
        $tokenResult = $user->createToken('mobile_app');

        // Для передачи клиенту
        return $tokenResult->plainTextToken;
    }
}