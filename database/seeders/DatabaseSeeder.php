<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);

        Listing::factory(6)->create([
            'user_id' => $user->id
        ]);
        // Listing::create([
        //     'title' => 'Laravel Senior Developer',
        //     'tags' => 'Laravel, Javascript',
        //     'company' => 'Hanan Media',
        //     'Location' => 'Beit Shemesh',
        //     'email' => 'hanan@gmail.com',
        //     'website' => 'https://www.hanan.com',
        //     'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat, velit amet suscipit odio quo atque, vero libero dicta accusantium molestias quis officia deserunt sed alias ea numquam! Voluptate sit, voluptatibus deserunt qui, libero temporibus minus assumenda animi reprehenderit numquam vel!'
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
