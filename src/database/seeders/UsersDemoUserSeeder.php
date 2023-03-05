<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersDemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'PenrithMRT Demo',
            'email' => 'demo@demopenrithmrt.org.uk',
            'password' => Hash::make(env('DEMO_USER_PASSWORD')),
        ]);
    }
}
