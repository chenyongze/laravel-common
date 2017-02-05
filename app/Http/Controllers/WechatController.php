<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Log;

use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    //
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function service()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $message = 'hello';

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }

    public function demo()
    {
        $wechatServer = \Wechat::server(); // 服务端
        $wechatUser = \Wechat::user(); // 用户服务

        var_dump($wechatServer);
        var_dump($wechatUser);
    }


    public function serviceTwo()
    {
        $options = [
            'debug'     => true,
            'app_id'    => 'wxeb6cc8cf6022fe20',
            'secret'    => 'ee78c0c2a28e3e8d1fe6c8fcfcba38b1',
            'token'     => 'fashion',
            'log' => [
                'level' => 'debug',
                'file'  => storage_path('logs/').'easywechat.log',
            ],
            // ...
        ];

        $app = new Application($options);

        $server = $app->server;
//        $user = $app->user;

        $server->setMessageHandler(function($message)  {
//            $fromUser = $user->get($message->FromUserName);
//            return "{$fromUser->nickname} 您好！欢迎关注 yongze!";
            return " 您好！欢迎关注 yongze!";
        });

        $server->serve()->send();
    }
}
