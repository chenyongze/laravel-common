<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Omnipay\Omnipay;
use Overtrue\Pinyin\Pinyin;
use Symfony\Component\Console\Helper\ProcessHelper;

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
}
