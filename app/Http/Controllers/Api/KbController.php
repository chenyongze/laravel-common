<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class KbController extends Controller
{
    //
    public function abc(){
        $user = User::find(1);
        return (string) $user;

        Redis::set('name', 'todo.....');
        return [12232,432432];
    }
}
