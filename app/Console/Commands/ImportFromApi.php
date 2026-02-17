<?php

namespace App\Console\Commands;

use App\Jobs\ImportAuthorsJob;
use App\Jobs\ImportCommentsJob;
use App\Jobs\ImportPostsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ImportFromApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:from-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from the json placeholder';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Bus::chain([
            new ImportAuthorsJob(10),
            new ImportPostsJob(100),
            new ImportCommentsJob(500),
        ])->dispatch();
    }
}
