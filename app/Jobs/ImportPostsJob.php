<?php

namespace App\Jobs;

use App\Services\ImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportPostsJob extends ImportService implements ShouldQueue
{
    use Queueable;

    public string $url = 'https://jsonplaceholder.typicode.com/posts';

    protected string $model = 'Post';

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
            ['title' => 'title'],
            ['slug' => 'title', 'body' => 'body', 'author_id' => 'userId']
        );
    }
}
