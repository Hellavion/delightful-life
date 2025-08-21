<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder для создания администратора по умолчанию
 */
class AdminSeeder extends Seeder
{
    /**
     * Запустить посев базы данных
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Администратор',
            'email' => 'admin@delightful-life.local',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
