<?php

namespace Database\Seeders;

use App\Models\SarcallResponse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SarcallResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            SarcallResponse::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
