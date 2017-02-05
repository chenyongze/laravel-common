<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;

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
    protected $description = '发送邮件给用户';

    protected $drip='xxx';
    protected $user=null;

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
    public function handle( Mailer $mailer)
    {
//        $user = $this->user;
//        $mailer->send('emails.reminder',['user'=>$user],function($message) use ($user){
//            $message->to($user->email)->subject('新功能发布');
//        });

        $name = 'yongze';
        $to = '1835962399@qq.com';
        $flag = $mailer->send('emails.reminder',['name'=>$name],function($message) use($to) {
            $message ->to($to)->subject('邮件测试');
        });

        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }

        return ;

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
