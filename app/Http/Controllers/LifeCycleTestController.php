<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceContainerTest()
    {
        app()->bind('lifeCycleTest',function(){
            return 'ライフサイクルテスト' ;
        });

        /**
         * サービスコンテナありのバージョン
         */
        app()->bind('sample',Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        dd(app());
    }

    public function showServiceProviderTest()
    {
        $encrypt = app()->make('encrypter');
        $password = $encrypt->encrypt('password');

        $sample = app()->make('serviceProviderTest');

        dd($password,$encrypt->decrypt($password),$sample);
    }
}

class Sample{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function run()
    {
        $this->message->send();
    }
}

class Message
{
    public function send()
    {
        echo('メッセージ表示');
    }
}
