<?php

namespace App\Console\Commands;

use App\Jobs\QueueEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail as Mailer;
use DB;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发送邮件给用户';

    protected $drip='xxx';
    protected $type=null;

    /**
     * Create a new command instance.
     *
     * @return void DripEmailer
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $type = $this->ask('type[baby|.....]?');
        switch ($type){
            case 'baby':
                $this->handle_baby();
                break;
            case 'test':
                $this->handle_test();
                break;
            default:
                break;
        }

        return ;
    }

    public function handle_baby()
    {
        $count = DB::table('email')->count();
        $bar = $this->output->createProgressBar($count);
        $level = 0;
        $limit = 10;
        do{
            $emails = DB::table('email')->where('created_at','>',0)->orderBy('id','desc')->take($limit)->skip($level*$limit)->get();
            foreach ($emails as $emailInfo){
                $msg = "结果::::{$emailInfo->email}";
//            \Queue::push( new QueueEmail($emailInfo->email),'','emails');
                $name = '育儿百科';
                $to = $emailInfo->email;
                try{
                    $flag = Mailer::send('emails.baby',['name'=>$name],function($message) use($to) {
                        $message ->to($to)->subject('育儿百科');
                    });
                }catch (\App\Exceptions\Handler $e){
                    $this->info($e);
                }
                $this->info($msg);

                $bar->advance();
                sleep(20);
            }

            if($level == 1){
//                die;
            }
            ++ $level;
        }while ($limit = count($emails));

        $bar->finish();
        return ;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle_test()
    {

//        $user = $this->user;
//        $mailer->send('emails.reminder',['user'=>$user],function($message) use ($user){
//            $message->to($user->email)->subject('新功能发布');
//        });

        $bar = $this->output->createProgressBar(3);

        $name = 'yongze';
//        $to = '1835962399@qq.com';
        $to = 'sapphire.php@gmail.com';
        $flag = Mailer::send('emails.reminder',['name'=>$name],function($message) use($to) {
            $message ->to($to)->subject('邮件测试');
        });
        $bar->advance();

        //发送纯文本邮件
        $output_nginx =$this->execShellWithPrettyPrint('ps aux|grep nginx');
        $output_php =$this->execShellWithPrettyPrint('ps aux|grep php');
        $output_mysql =$this->execShellWithPrettyPrint('ps aux|grep nginx');
        $msg = <<<EOF
监控 服务器:
===============
nginx:
{$output_nginx}
===============
php:
{$output_php}
===============
mysql:
{$output_mysql}
EOF;

        Mailer::raw($msg, function ($message) use($to) {
            $message ->to($to)->subject('纯文本信息邮件测试');
        });
        $bar->advance();

//        邮件中发送附件
        $image = 'http://p1.bpimg.com/567571/19b95d3639c6f6a2.png';
        $flag = Mailer::send('emails.attachment',['name'=>$name,'imgPath'=>$image],function($message) use($to){
            $message ->to($to)->subject('网络图片测试');
        });

        $bar->finish();
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

    /**
     * Exec sheel with pretty print.
     *
     * @param  string $command
     * @return mixed
     */
    public function execShellWithPrettyPrint($command)
    {
        $this->info('---');
        $this->info($command);
        $output = shell_exec($command);
        $this->info($output);
        $this->info('---');

        return $output;
    }
}
