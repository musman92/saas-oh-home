<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Super User: superuser@example.com
        \App\Models\SuperUser::create([
            'name' => 'Super User',
            'email' => 'superuser@example.com',
            'password' => \Hash::make('password'),
        ]);

        // - Sub Admin: subadmin@example.com
        \App\Models\SubAdmin::create([
            'name' => 'Sub Admin',
            'email' => 'subadmin@example.com',
            'password' => \Hash::make('password'),
        ]);

        // - User: user@example.com
        \App\Models\User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => \Hash::make('password'),
        ]);
    }
}
