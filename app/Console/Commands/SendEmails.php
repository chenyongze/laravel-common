<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    protected $drip='xxx';

    /**
     * Create a new command instance.
     *
     * @return void DripEmailer
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
        $name = $this->ask('What is your name?');

        if ($this->confirm('Do you wish to continue? [y|N]')) {
            $bar = $this->output->createProgressBar(30);
            for ($i=30;$i>=0;$i--){
                $bar->advance();
                sleep(1);
            }

            $bar->finish();
            //
            $this->info($name);
        }else{
            $this->error($name);
        }
    }
}
