<?php

namespace App\Console\Commands;

use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestQueueToEchoMsg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public $msg = '';

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
     * @return mixed
     */
    public function handle()
    {
        //
        Log::info('at '. date('Y-m-d H:i:s').' log by queue and the msg is:'.$this->msg);
    }
}
