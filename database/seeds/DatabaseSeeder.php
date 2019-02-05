<?php

use Illuminate\Database\Seeder;
USE App\Models\Users;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::unguard();
        // Register the user seeder
        $this->call(UsersTableSeeder::class);
        Users::reguard();
    }
}
