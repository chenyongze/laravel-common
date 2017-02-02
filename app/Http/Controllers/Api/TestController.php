<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Overtrue\Pinyin\Pinyin;

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
}
