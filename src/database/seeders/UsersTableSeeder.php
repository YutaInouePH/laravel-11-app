<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private array $names = [
        'Alice',
        'Bob',
        'Charlie',
        'David',
        'Eve',
        'Frank',
        'Grace',
        'Hank',
        'Ivy',
        'Jack',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach ($this->names as $name) {
            User::factory()->create([
                'name' => $name,
                'email' => strtolower($name) . '@example.com',
            ]);
        }
    }
}
