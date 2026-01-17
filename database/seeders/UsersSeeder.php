<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@imprimeindo.com'],
            ['name' => 'Super Administrador', 'password' => Hash::make('admin123')]
        );

        User::updateOrCreate(
            ['email' => 'operador@imprimeindo.com'],
            ['name' => 'Operador', 'password' => Hash::make('operador123')]
        );

        User::updateOrCreate(
            ['email' => 'tecnico@imprimeindo.com'],
            ['name' => 'Técnico', 'password' => Hash::make('tecnico123')]
        );
    }
}

