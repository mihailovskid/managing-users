<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username'  => 'admin',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('admin1234'),
            'is_active' => 1,
            'role_id'  => Role::where('name', 'admin')->first()->id
        ]);

        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'username'  => fake()->name(),
                'email'     => fake()->email(),
                'password'  => Hash::make('user1234'),
                'is_active' => 0,
                'role_id'   => Role::where('name', 'regular')->first()->id
            ];
        }
        User::insert($data);
    }
}
