<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'name'     => 'testUser',
            'email'    => 'admin@test.com',
            'phone'    => '77785508327',
            'password' => bcrypt('admin'),
        ]);
        User::factory(10)->create();
        Category::factory(4)->create();
    }
}
