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
}
