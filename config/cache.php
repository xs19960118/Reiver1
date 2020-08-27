<?php

use think\facade\Env;

return [
    'type' => 'complex',
    // 默认
    'default' => [
        // 驱动方式
        'type' => 'File',
        // 缓存保存目录
        'path' => '',
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],
    // 文件
    'file' => [
        // 驱动方式
        'type' => 'File',
        // 缓存保存目录
        'path' => '',
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],
    // redis
    'redis' => [
        'type' => ENV::get('redis.redis_type'),
        'host' => ENV::get('redis.redis_host'),
        'port' => ENV::get('redis.redis_port'),
        'password' => ENV::get('redis.redis_password'),
        // 全局缓存有效期（0为永久有效）
        'expire' => ENV::get('redis.redis_expire'),
        // 缓存前缀
        'prefix' => ENV::get('redis.redis_prefix'),
    ],

    // redis
//    'redis' => [
//        'type' => 'redis',
//        'host' => '127.0.0.1',
//        'port' => '6379',
//        'password' => 'ailxma',
//        // 全局缓存有效期（0为永久有效）
//        'expire' => 0,
//        // 缓存前缀
//        'prefix' => '',
//    ],
];
