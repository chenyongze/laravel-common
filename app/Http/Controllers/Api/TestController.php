<?php

namespace App\Http\Controllers\api;

use App\Console\Commands\TestQueueToEchoMsg;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redis;
use Omnipay\Omnipay;
use Overtrue\Pinyin\Pinyin;
use Skyling\Yunpian\Facade\Yunpian;
use Symfony\Component\Console\Helper\ProcessHelper;
use Torann\GeoIP\Facades\GeoIP;
use Umeng\Facades\Android;
use Umeng\Facades\IOS;

use JPush\Client as JPush;

class TestController extends Controller
{
    //
    public function abc($id){
//        App::abort(404);
        $user = User::find($id);
        return (string) $user;

        Redis::set('name', 'todo.....');
        return [12232,432432];
    }

    public function caiji()
    {
        //待采集的目标页面，PHPHub教程区
        $page = 'https://laravel-china.org/categories/6';
        //采集规则
        $rules = array(
            //文章标题
            'title' => ['.media-heading a','text'],
            //文章链接
            'link' => ['.media-heading a','href'],
            //文章作者名
            'author' => ['.img-thumbnail','alt']
        );
        //列表选择器
        $rang = '.topic-list>li';
        //采集
        $data = \QL\QueryList::Query($page,$rules,$rang)->data;
        //查看采集结果
        return $data;
    }

    public function pinyin()
    {

    // 小内存型
            $pinyin = new Pinyin(); // 默认
    // 内存型
    // $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
    // I/O型
    // $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

        $res =  $pinyin->convert('带着希望去旅行，比到达终点更美好');
    // ["dai", "zhe", "xi", "wang", "qu", "lv", "xing", "bi", "dao", "da", "zhong", "dian", "geng", "mei", "hao"]

            $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_UNICODE);
    // ["dài","zhe","xī","wàng","qù","lǚ","xíng","bǐ","dào","dá","zhōng","diǎn","gèng","měi","hǎo"]

        $pinyin->convert('带着希望去旅行，比到达终点更美好', PINYIN_ASCII);
        return $res;
    //["dai4","zhe","xi1","wang4","qu4","lv3","xing2","bi3","dao4","da2","zhong1","dian3","geng4","mei3","hao3"]
    }

    public function userName()
    {
        $user = User::find(1);
        return ($user->name);
    }


    /**
     *
     */
    public function cacheInc()
    {
        return Cache::increment('inc-key-todo');
    }

    public function collect()
    {
         $collection = collect([1, 2, 3]);
        return (int) ($collection->count());
    }

    public function db()
    {
//        $results = DB::connection('mysql-online');
        $results = DB::table('users')->select('name as n', 'email')->get();
//        $results = DB::select('select * from users where id =:id', [':id'=>1,]);
//        dump($results);die;
        return $results;
    }

    public function crypt()
    {
        $str = 'yongze';
        return [
            '1-0'=>$str,
            '1-1'=>Crypt::encrypt($str),
            '1-2'=>Crypt::decrypt(Crypt::encrypt($str)),
        ];
    }

    public function alipayApp()
    {
        /**
         * @var AopAppGateway $gateway
         */
        $gateway = Omnipay::create('Alipay_AopApp');
        $gateway->setAppId('2016120904063724');
        $gateway->setPrivateKey('-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDCCptk0HDm6GBCuuxg+6lbqwm+/5DgdVRTwU81+02yHO752iq4
g53phF9BJwdm5mIAoB65oZIGJxinEJYSKd974vvkdSUyeZvVn73BuUchk3pzDrck
JkgR0F7hRRzjaiLrTWKcmj9alq+BO8zZYqsS22XqtM/7Wr5ohIetMOuR1wIDAQAB
AoGAQyvm1URvARBKWm9Y6s3Tt98CtbLE1V7ofUH7CMXhBJqNg8KpbUxquu7PBr/b
CR0RqgPD/yDWavjXyOWt/cWvDhpw3Dve9VaVhPlkmlAcCHj1MTOrn7fkIFqGyPic
BVDVwTF/A/MgQw8HRNBY6m1q35/SBeQw7YnUp3qXWb777TkCQQDpbEm7C6XoF54E
P3a81P93EKrmLv2V42vnse8S3TpKnWfhlLi1FJbGDbhEex1iiJfYAT6yOE7yPGkI
tjvEBLl1AkEA1M80ZTsPaVjYtcGGuhHIr3hTPDDGNyk8LoiBIzInj9pYm1dkVty5
A04AzbrBztqlaSI8KSbkmvHxaOWUySEomwJBALX4gIY772u/NaXUH+nYFwwoR0LJ
cVGviMiIk3teUfonOfvHKDOqyFvACF4CqIbPO6jeV5UyhoEbjTqIbpFCqZ0CQQDP
98Zuf28qNodh6ERvpl2HDYHaOpga5BNKLmB1MthyvqEE/jyynnW4AwzKAI7SRd6M
hcZhOP8DZRnUtzfV7q+tAkEAgfceoKq9lNBo4kM46+0TtCCyGZWB1M4oaaC0Jpux
CjF4SJtYLG9Dc4OHOx3RVlLuF2hHbrPFpMRtu/na4R87RQ==
-----END RSA PRIVATE KEY-----
');
        $gateway->setAlipayPublicKey('-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAMIKm2TQcOboYEK6
7GD7qVurCb7/kOB1VFPBTzX7TbIc7vnaKriDnemEX0EnB2bmYgCgHrmhkgYnGKcQ
lhIp33vi++R1JTJ5m9WfvcG5RyGTenMOtyQmSBHQXuFFHONqIutNYpyaP1qWr4E7
zNliqxLbZeq0z/tavmiEh60w65HXAgMBAAECgYBDK+bVRG8BEEpab1jqzdO33wK1
ssTVXuh9QfsIxeEEmo2DwqltTGq67s8Gv9sJHRGqA8P/INZq+NfI5a39xa8OGnDc
O971VpWE+WSaUBwIePUxM6uft+QgWobI+JwFUNXBMX8D8yBDDwdE0FjqbWrfn9IF
5DDtidSnepdZvvvtOQJBAOlsSbsLpegXngQ/drzU/3cQquYu/ZXja+ex7xLdOkqd
Z+GUuLUUlsYNuER7HWKIl9gBPrI4TvI8aQi2O8QEuXUCQQDUzzRlOw9pWNi1wYa6
EciveFM8MMY3KTwuiIEjMieP2libV2RW3LkDTgDNusHO2qVpIjwpJuSa8fFo5ZTJ
ISibAkEAtfiAhjvva781pdQf6dgXDChHQslxUa+IyIiTe15R+ic5+8coM6rIW8AI
XgKohs87qN5XlTKGgRuNOohukUKpnQJBAM/3xm5/byo2h2HoRG+mXYcNgdo6mBrk
E0ouYHUy2HK+oQT+PLKedbgDDMoAjtJF3oyFxmE4/wNlGdS3N9Xur60CQQCB9x6g
qr2U0GjiQzjr7RO0ILIZlYHUzihpoLQmm7EKMXhIm1gsb0Nzg4c7HdFWUu4XaEdu
s8WkxG27+drhHztF
-----END PRIVATE KEY-----
');
        $gateway->setNotifyUrl('https://www.example.com/notify');
//        https://github.com/lokielse/omnipay-alipay/wiki/FAQs


        $request = $gateway->purchase();
        $request->setBizContent([
            'subject'      => 'test',
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => '0.01',
            'product_code' => 'QUICK_MSECURITY_PAY',
        ]);

        /**
         * @var AopTradeAppPayResponse $response
         */
        $response = $request->send();

        $orderString = $response->getOrderString();

        return $orderString;

    }

    public function alipayWap()
    {
        /**
         * @var AopAppGateway $gateway
         */
        $gateway = Omnipay::create('Alipay_AopWap');
        $gateway->setAppId('2016120904063724');
        $gateway->setPrivateKey('-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDCCptk0HDm6GBCuuxg+6lbqwm+/5DgdVRTwU81+02yHO752iq4
g53phF9BJwdm5mIAoB65oZIGJxinEJYSKd974vvkdSUyeZvVn73BuUchk3pzDrck
JkgR0F7hRRzjaiLrTWKcmj9alq+BO8zZYqsS22XqtM/7Wr5ohIetMOuR1wIDAQAB
AoGAQyvm1URvARBKWm9Y6s3Tt98CtbLE1V7ofUH7CMXhBJqNg8KpbUxquu7PBr/b
CR0RqgPD/yDWavjXyOWt/cWvDhpw3Dve9VaVhPlkmlAcCHj1MTOrn7fkIFqGyPic
BVDVwTF/A/MgQw8HRNBY6m1q35/SBeQw7YnUp3qXWb777TkCQQDpbEm7C6XoF54E
P3a81P93EKrmLv2V42vnse8S3TpKnWfhlLi1FJbGDbhEex1iiJfYAT6yOE7yPGkI
tjvEBLl1AkEA1M80ZTsPaVjYtcGGuhHIr3hTPDDGNyk8LoiBIzInj9pYm1dkVty5
A04AzbrBztqlaSI8KSbkmvHxaOWUySEomwJBALX4gIY772u/NaXUH+nYFwwoR0LJ
cVGviMiIk3teUfonOfvHKDOqyFvACF4CqIbPO6jeV5UyhoEbjTqIbpFCqZ0CQQDP
98Zuf28qNodh6ERvpl2HDYHaOpga5BNKLmB1MthyvqEE/jyynnW4AwzKAI7SRd6M
hcZhOP8DZRnUtzfV7q+tAkEAgfceoKq9lNBo4kM46+0TtCCyGZWB1M4oaaC0Jpux
CjF4SJtYLG9Dc4OHOx3RVlLuF2hHbrPFpMRtu/na4R87RQ==
-----END RSA PRIVATE KEY-----
');
        $gateway->setAlipayPublicKey('-----BEGIN PRIVATE KEY-----
MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAMIKm2TQcOboYEK6
7GD7qVurCb7/kOB1VFPBTzX7TbIc7vnaKriDnemEX0EnB2bmYgCgHrmhkgYnGKcQ
lhIp33vi++R1JTJ5m9WfvcG5RyGTenMOtyQmSBHQXuFFHONqIutNYpyaP1qWr4E7
zNliqxLbZeq0z/tavmiEh60w65HXAgMBAAECgYBDK+bVRG8BEEpab1jqzdO33wK1
ssTVXuh9QfsIxeEEmo2DwqltTGq67s8Gv9sJHRGqA8P/INZq+NfI5a39xa8OGnDc
O971VpWE+WSaUBwIePUxM6uft+QgWobI+JwFUNXBMX8D8yBDDwdE0FjqbWrfn9IF
5DDtidSnepdZvvvtOQJBAOlsSbsLpegXngQ/drzU/3cQquYu/ZXja+ex7xLdOkqd
Z+GUuLUUlsYNuER7HWKIl9gBPrI4TvI8aQi2O8QEuXUCQQDUzzRlOw9pWNi1wYa6
EciveFM8MMY3KTwuiIEjMieP2libV2RW3LkDTgDNusHO2qVpIjwpJuSa8fFo5ZTJ
ISibAkEAtfiAhjvva781pdQf6dgXDChHQslxUa+IyIiTe15R+ic5+8coM6rIW8AI
XgKohs87qN5XlTKGgRuNOohukUKpnQJBAM/3xm5/byo2h2HoRG+mXYcNgdo6mBrk
E0ouYHUy2HK+oQT+PLKedbgDDMoAjtJF3oyFxmE4/wNlGdS3N9Xur60CQQCB9x6g
qr2U0GjiQzjr7RO0ILIZlYHUzihpoLQmm7EKMXhIm1gsb0Nzg4c7HdFWUu4XaEdu
s8WkxG27+drhHztF
-----END PRIVATE KEY-----
');
        $gateway->setNotifyUrl('https://www.example.com/notify');
//        https://github.com/lokielse/omnipay-alipay/wiki/FAQs


        $request = $gateway->purchase();
        $request->setBizContent([
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => 0.01,
            'subject'      => 'test',
            'product_code' => 'QUICK_WAP_PAY',
        ]);

        /**
         * @var AopCompletePurchaseResponse $response
         */
        $response = $request->send();

        $redirectUrl = $response->getRedirectUrl();
        //or
        $response->redirect();

    }


    public function wechatPayApp()
    {
        //gateways: WechatPay_App, WechatPay_Native, WechatPay_Js, WechatPay_Pos
        $gateway    = Omnipay::create('WechatPay_App');
        $gateway->setAppId('wx09daf09c8118c474');
        $gateway->setMchId('1362198902');
        $gateway->setApiKey('xnfLY8u1s0oPFebk5Gf5KDYYzfk62Z6G');
        $gateway->setNotifyUrl('https://www.example.com/notify');

        $order = [
            'body'              => 'The test order',
            'out_trade_no'      => date('YmdHis').mt_rand(1000, 9999),
            'total_fee'         => 1, //=0.01
            'spbill_create_ip'  => '192.168.1.1',
            'fee_type'          => 'CNY'
        ];

        /**
         * @var Omnipay\WechatPay\Message\CreateOrderRequest $request
         * @var Omnipay\WechatPay\Message\CreateOrderResponse $response
         */
        $request  = $gateway->purchase($order);
        $response = $request->send();

//available methods
        $response->isSuccessful();
        $response->getData(); //For debug
        $rst = $response->getAppOrderData(); //For WechatPay_App
//        var_dump($response);exit;
        return $rst;
//        $response->getJsOrderData(); //For WechatPay_Js
//        $response->getCodeUrl(); //For Native Trade Type
    }

    /**
     * 二维码 微信
     */
    public function wechatNative()
    {
        $gateway    = Omnipay::create('WechatPay_Native');
        $gateway->setAppId('wx09daf09c8118c474');
        $gateway->setMchId('1362198902');
        $gateway->setApiKey('xnfLY8u1s0oPFebk5Gf5KDYYzfk62Z6G');
        $gateway->setNotifyUrl('https://www.example.com/notify');

        $order = [
            'body'              => 'The test order',
            'out_trade_no'      => date('YmdHis').mt_rand(1000, 9999),
            'total_fee'         => 1, //=0.01
            'spbill_create_ip'  => '192.168.1.1',
            'fee_type'          => 'CNY'
        ];

        /**
         * @var Omnipay\WechatPay\Message\CreateOrderRequest $request
         * @var Omnipay\WechatPay\Message\CreateOrderResponse $response
         */
        $request  = $gateway->purchase($order);
        $response = $request->send();

        $response->isSuccessful();
        $response->getData(); //For debug
//        $response->getAppOrderData(); //For WechatPay_App
//        $response->getJsOrderData(); //For WechatPay_Js
        return $response->getCodeUrl(); //For Native Trade Type

    }


    public function qiniu()
    {
        $disk = \Storage::disk('qiniu');
//        $rst = $disk->exists('001NZcFCzy6VKRUYjIF1d&690.jpg');
//        $rst = $disk->get('001NZcFCzy6VKRUYjIF1d&690.jpg');
        $contents ='http://blog.dotalk.cn/wp-content/uploads/2016/12/qrcode_for_gh_4566810f39c8_430.jpg';
        $rst = $disk->getDriver()->downloadUrl('001NZcFCzy6VKRUYjIF1d&690.jpg');
//        $rst = $disk->put('fileqqqqqq.jpg',$contents);
        var_dump($rst);
    }


    public function yunpian()
    {
        // 发送单条短信
        $rst = Yunpian::sms()->singleSend('18911358085', '【胜乐典藏】您有1笔未支付的订单{$data}，将要过期，请尽快支付。（过期扣除保证金）', '回调地址');
        return $rst ;
//        var_dump($rst);
        // 发送多条短信
//        Yunpian::sms()->batchSend(['手机号数组'], '短信内容文本', '回调地址');
        // 发送语音验证码
//        Yunpian::voice()->voiceSend('手机号', '验证码', '回调地址');
    }


    public function kuaidi()
    {
        $info  = \Kuaidi\Kuaidi::query('yuantong', '882114232875886515');
        return $info;
    }

    public function umeng()
    {
        $apns = [
            'alert' => ['title'=>'biaoti','body'=>'fujingdexuanjianghu'],
            'badge' => 1,
            'sound' => 'bingbong.aiff'
        ];
        return IOS::customizedcast('S100000567',$apns);

        $body = [
            'ticker'=>'收到请告诉我',
            'title'=>'通知标题',
            'text'=>'通知文字描述',
            'after_open'=>'go_app'
        ];
        return Android::customizedcast('S100000597', $body);
    }

    /**
     * @param $msg
     * queue
     */
    public function triggerQueue( $msg )
    {
        Log::info('ready to trigger2::'.date('Y-m-d H:i:s'));
//        $this->dispatch(new TestQueueToEchoMsg($msg)); //commond bus的方式运行，测试成功

         $date = Carbon::now()->addSeconds(10);
        // // $date = Carbon::now()->addMinutes(15);
         Queue::later($date, new TestQueueToEchoMsg($msg)); //延迟执行任务，测试成功

        // Queue::push( new TestQueueToEchoMsg($msg));  //立即执行任务，测试成功

        Log::info('triggered:::'.date('Y-m-d H:i:s'));
        echo "trgiered2";
    }


    public function geoIp()
    {
        $location = GeoIP::getLocation('121.69.11.168');
        var_dump($location);
    }


    /**
     * 机关推送
     */
    public function jpush()
    {

        $app_key = '90c012299469493139d203e0';
        $master_secret = '3a107d1475fcd92875698bea';
        $logFile = storage_path('/logs/').'jpush.log';
        $client = new JPush($app_key, $master_secret,$logFile);

        $title = 'hello 开工大吉';

        // 这只是使用样例,不应该直接用于实际生产环境中 !!
        try {
            $response = $client->push()
                ->setPlatform(array('ios', 'android'))
                // 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd  或 addRegistrationId
                // 这四个方法中的某一个即可，这里仅作为示例，当然全部调用也可以，多项 audience 调用表示其结果的交集
                // 即是说一般情况下，下面三个方法和没有列出的 addTagAnd 一共四个，只适用一个便可满足大多数的场景需求
                 ->addAlias(['6263'])
//                ->addTag(array('tag1', 'tag2'))
                // ->addRegistrationId($registration_id)
                ->setNotificationAlert('Hi, JPush')
                ->iosNotification($title, array(
                    'sound' => 'sound.caf',
                    // 'badge' => '+1',
                    // 'content-available' => true,
                    // 'mutable-content' => true,
                    'category' => 'jiguang',
                    'extras' => array(
                        'key' => 'value',
                        'jiguang'
                    ),
                ))
                ->androidNotification('Hello Android', array(
                    'title' => 'hello jpush',
                    // 'build_id' => 2,
                    'extras' => array(
                        'key' => 'value',
                        'jiguang'
                    ),
                ))
                ->message('message content', array(
                    'title' => 'hello jpush',
                    // 'content_type' => 'text',
                    'extras' => array(
                        'key' => 'value',
                        'jiguang'
                    ),
                ))
                ->options(array(
                    // sendno: 表示推送序号，纯粹用来作为 API 调用标识，
                    // API 返回时被原样返回，以方便 API 调用方匹配请求与返回
                    // 这里设置为 100 仅作为示例
                    // 'sendno' => 100,
                    // time_to_live: 表示离线消息保留时长(秒)，
                    // 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
                    // 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
                    // 这里设置为 1 仅作为示例
                    // 'time_to_live' => 1,
                    // apns_production: 表示APNs是否生产环境，
                    // True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境
                    'apns_production' => true,
                    // big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
                    // 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
                    // 这里设置为 1 仅作为示例
                    // 'big_push_duration' => 1
                ))
                ->send();
        } catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            print $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            print $e;
        }
//        print_r($response);
        return $response;
    }
}
