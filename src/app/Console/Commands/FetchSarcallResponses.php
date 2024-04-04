<?php

namespace App\Console\Commands;

use App\Models\SarcallResponse;
use App\Models\User;
use App\Spiders\SarcallResponsesSpider;
use Database\Factories\SarcallResponseFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use RoachPHP\Roach;

class FetchSarcallResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'penrith:fetchsarcallresponses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Sarcall responses';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $items = Roach::collectSpider(SarcallResponsesSpider::class);

        foreach ($items as $responses) {
            foreach ($responses->all() as $response) {
                echo 'Creating response for ' . $response['Member Name'].PHP_EOL;
                try {
                    $user = User::where('name',  $response['Member Name'])->first();

                    if (empty($user)) {
                        Log::error('Couldn\'t find user record for Sarcall response', $response);
                        continue;
                    }

                    SarcallResponse::factory()->create(
                        [
                            'response' => $response['Message'],
                            'time' => $response['Time & Date Of Response'],
                            'user_id' => $user->id,
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::error('Error importing record ', ['response' => $response, 'error' => $e->getMessage()]);
                }
            }
        }

        return Command::SUCCESS;
    }
}
