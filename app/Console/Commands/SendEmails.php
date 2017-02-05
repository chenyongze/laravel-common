<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;

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
    public function handle(Mailer $mailer)
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

        //发送纯文本邮件
        $mailer->raw('你好，我是PHP程序！', function ($message) use($to) {
            $message ->to($to)->subject('纯文本信息邮件测试');
        });


//        邮件中发送附件
        $image = 'http://p1.bpimg.com/567571/19b95d3639c6f6a2.png';
        $flag = $mailer->send('emails.attachment',['name'=>$name,'imgPath'=>$image],function($message) use($to){
            $message ->to($to)->subject('网络图片测试');
        });

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
