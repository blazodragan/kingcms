<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(1)->create();
        $users->take(1)->each(function (\App\Models\User $user) {

            $fullName = $user->name;

            $user->addMediaFromUrl("https://i.pravatar.cc/400")
                ->withCustomProperties([
                    "name" => $fullName,
                    "extension" => "jpg",
                    "size" => rand(10, 100) * 1024,
                    "alt" => $fullName,
                ])
                ->toMediaCollection('avatar', config('app.default_media_disk_name'));
        });

        $users->shuffle()->take(1)->each(function ($user) {
            $user->assignRole('Administrator');
        });
        // \App\Models\Team::factory(1)->create();
        // // get the user 
        // $user_id = \App\Models\User::latest()->first();
        // $token = $user_id->createToken('apiToken')->plainTextToken;
        // \App\Models\Ticket::factory(1000)->create([
        //     'user_id' => $user_id,
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
