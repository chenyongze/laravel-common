<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QueueToJpush implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $useInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($useInfo)
    {
        //
        $this->useInfo = $useInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
//        Log::info('at '. date('Y-m-d H:i:s').' log by queue and the msg is:'.$this->msg);
         \Log::info('at '. date('Y-m-d H:i:s').' log by queue and the msg is:'.var_export($this->useInfo,true));
        return true;
    }
}
