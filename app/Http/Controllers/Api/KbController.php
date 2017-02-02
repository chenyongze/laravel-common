<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class KbController extends Controller
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
}
