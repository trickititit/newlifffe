<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
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
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'js' => [
            'driver' => 'local',
            'root' => storage_path('app/public/'.env('THEME','default').'/js'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'xml' => [
            'driver' => 'local',
            'root' => storage_path('app/public/'.env('THEME','default').'/xml'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'phantom' => [
            'driver' => 'local',
            'root' => base_path("phantomjs/bin"),
            'url' => env('APP_URL').'phantomjs/bin',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'ftp' => [
            'driver'   => 'ftp',
            'host'     => 'records.megapbx.ru',
            'username' => 'direktor@ip-plehanov.megapbx.ru',
            'password' => 'Gkt[fyjd_2019',

            // Optional FTP Settings...
             'port'     => 21,
             'root'     => '/recordings',
             'passive'  => true,
             'ssl'      => false,
            // 'timeout'  => 30,
        ],

    ],



];
