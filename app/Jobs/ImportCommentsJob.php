<?php

namespace App\Jobs;

use App\Services\ImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportCommentsJob extends ImportService implements ShouldQueue
{
    use Queueable;

    public string $url = 'https://jsonplaceholder.typicode.com/comments';

    protected string $model = 'Comment';

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
            ['email' => 'email'],
            ['name' => 'name', 'body' => 'body', 'post_id' => 'postId']
        );
    }
}
