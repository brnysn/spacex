<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mission;
use App\Models\Capsule;
use App\Events\FetchSpacexApiStartedEvent;
use App\Events\FetchSpacexApiFinishedEvent;

class FetchData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:spacex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from Spacex api.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // Fire FetchSpacexApiStartedEvent
        event(new FetchSpacexApiStartedEvent());

        // Get url from .env file
        $url = env('SPACEX_API_URL', 'https://api.spacexdata.com/v3/capsules');

        $this->info('Fetching data from SpaceX api...');

        // Fetch data from $url with cUrl
        $response = $this->fetch($url);
        
        // Set the data for sync / if not array then convert
        $data = (is_array($response) || is_object($response)) ? $response : json_decode($response);

        // Sync data with db
        $this->sync($data);

        // Fire FetchSpacexApiFinishedEvent
        event(new FetchSpacexApiFinishedEvent($response));

        $this->info('Process is done without error.');

        return true;
    }

    /**
     * 
     * Fetch Data
     * 
     * @var string $url = url
     * @return array $data
     */
    public function fetch($url)
    {
        $this->info('Connecting '.$url);
        // Setup Curl
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        
        // throw error exception
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $this->info('Fetched data from SpaceX');
            return $response;
        }
    }

    /**
     * 
     * Sync Fetched Data With DB
     * 
     * @var string $data = data
     */
    public function sync($data)
    {
        $this->info('Syncing with DB');

        //sync $data with DB
        foreach ( $data as $capsule) {
            $newCapsule = Capsule::firstOrCreate(
                ['capsule_serial' => $capsule->capsule_serial],
                [
                    'capsule_id' => $capsule->capsule_id, 
                    'status' => $capsule->status,
                    'original_launch' => $capsule->original_launch,
                    'original_launch_unix' => $capsule->original_launch_unix,
                    'landings' => $capsule->landings,
                    'type' => $capsule->type,
                    'details' => $capsule->details,
                    'reuse_count' => $capsule->reuse_count,
                ]
            );

            // Create Mission if not exist
            foreach ($capsule->missions as $mission) {
                
                $newMission = Mission::firstOrCreate(
                    ['name' => $mission->name],
                    ['flight' => $mission->flight]
                );
                
                // Add relation between capsule & mission
                $newCapsule->missions()->syncWithoutDetaching($newMission); // TODO sync yaparken kaldırılan varsa silinecek.
            }

        }

        $this->info('All data is synced.');
    }

}
