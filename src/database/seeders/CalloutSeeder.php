<?php

namespace Database\Seeders;

use App\Models\Callout;
use Illuminate\Database\Seeder;

class CalloutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Callout::factory(40)->create();
    }
}
