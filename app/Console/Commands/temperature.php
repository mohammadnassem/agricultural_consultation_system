<?php

namespace App\Console\Commands;

use App\Jobs\tempertureJop;
use App\Models\Plant;
use Illuminate\Console\Command;

class temperature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humidity:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'chick humidity change every day';

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
     * @return int
     */
    public function handle()
    {
        $plants = Plant::all();

        $plants->chunk(10)->each(function ($chunkedData) {
            dispatch(new tempertureJop($chunkedData));
        });

    }
}
