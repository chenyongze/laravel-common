<?php

namespace App\Console\Commands;

use App\Jobs\QueueToJpush;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use DB  ;

class AuctionPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:push2user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拍场开始提前5分钟推送';

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
        //@todo all 用户入队列
        $auction_id = 4321;

        $rst = Redis::get('xxxx');
//        $rst = $this->redis->get('xxxx');
//        var_dump($rst);die;
        $users = DB::table('my_user')->where('status','6')->get();
        $auction_redis_key = 'AUCTION:USERSLIST:'.$auction_id;
        foreach ($users as $user){
            $rst = Redis::lpush($auction_redis_key,$user->id);
            $msg = "结果:$rst:::$auction_redis_key:::{$user->id}";
//            dispatch( new QueueToJpush($user));
            \Queue::push( new QueueToJpush($user),'','auction');
            $this->info($msg);
        }

//        $this->execShellWithPrettyPrint('php artisan queue:work --daemon');
//        $this->execShellWithPrettyPrint('php artisan queue:work');

        return '';
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
    }
}
