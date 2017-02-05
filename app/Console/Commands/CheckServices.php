<?php

namespace App\Console\Commands;

use Illuminate\Mail\Mailer;

class CheckServices extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Service:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '服务器检查';

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
    public function handle(Mailer $mailer)
    {
        //send web service to  email
        $outputService = $this->execShellWithPrettyPrint(' w ');
        $to = '1835962399@qq.com';
        $msg = <<<EOF
监控 服务器:
===============
service:
{$outputService}
===============
EOF;
        $mailer->raw($msg, function ($message) use($to) {
            $message ->to($to)->subject('服务器监控邮件');
        });
    }
}
