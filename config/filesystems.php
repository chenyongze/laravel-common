<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'webpath' => '/uploads',
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'qiniu' => [
            'driver'  => 'qiniu',
            'domains' => [
                'default'   => 'o6wypsyc2.bkt.clouddn.com', //你的七牛域名
                'https'     => 'dn-yourdomain.qbox.me',     //你的HTTPS域名
                'custom'    => 'static.abc.com',            //你的自定义域名
            ],
            'access_key'=> 'SzN37zs9qwj1FbWUYoBJZPrVz1B23IHe1L_i-sGK',  //AccessKey
            'secret_key'=> 'MW0EKfu31DHqWGNPyH7kfPpYRJHthQj8l6_Zs467',  //SecretKey
            'bucket'    => 'lvjudongfang',  //Bucket名字
            'notify_url'=> '',  //持久化处理回调地址
        ],

        'upyun' => [
            'driver'        => 'upyun',
            'domain'        => '',//你的upyun域名
            'username'      => '',//UserName
            'password'      => '',//Password
            'bucket'        => '',//Bucket名字
            'timeout'       => 130,//超时时间
            'endpoint'      => null,//线路
            'transport'     => 'http',//如果支持https，请填写https，如果不支持请填写http
        ],

        'oss'   => [
            'driver'            => 'oss',
            'accessKeyId'       => '',
            'accessKeySecret'   => '',
            'endpoint'          => '',
            'isCName'           => false,
            'securityToken'     => null,
            'bucket'            => '',
            'timeout'           => '5184000',
            'connectTimeout'    => '10',
            'transport'         => 'http',//如果支持https，请填写https，如果不支持请填写http
            'max_keys'          => 1000,//max-keys用于限定此次返回object的最大数，如果不设定，默认为100，max-keys取值不能大于1000
        ],

        'cos'   => [
            'driver'            => 'cos',
            'domain'            => '',      // 你的 COS 域名
            'app_id'            => '',
            'secret_id'         => '',
            'secret_key'        => '',
            'region'            => 'gz',        // 设置COS所在的区域
            'transport'         => 'http',      // 如果支持 https，请填写 https，如果不支持请填写 http
            'timeout'           => 60,          // 超时时间
            'bucket'            => '',
        ],

    ],

];
