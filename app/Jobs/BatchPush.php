<?php

namespace App\Jobs;

use App\EducatonInfo;
use App\Http\Controllers\PushMessageController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BatchPush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    public int $tries = 3;
    protected $push_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $push_data)
    {
        $this->push_data = $push_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $push = new PushMessageController($this->push_data['type'] ?? '', $this->push_data['type_id'] ?? '', $this->push_data['param']??[]);
        $push->push();
    }
}
