<?php

namespace App\Jobs;

use App\Services\ImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportAuthorsJob extends ImportService implements ShouldQueue
{
    use Queueable;

    protected string $url = 'https://jsonplaceholder.typicode.com/users';

    protected string $model = 'Author';

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $amount
    ){ }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        parent::import(
            ['name' => 'name'],
            ['username' => 'username', 'email' => 'email', 'company' => 'company.name']
        );
    }
}
