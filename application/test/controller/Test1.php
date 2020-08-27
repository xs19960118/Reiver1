<?php


namespace app\test\controller;


use think\Controller;
use think\facade\Cache;

class Test1 extends Controller
{
    // 测试连接 mysql 数据库
    public function testConn()
    {
        $user = model('common/User')::get(1);

        return json($user);
    }

    // 测试连接 redis
    public function testConnRedis()
    {
        // 使用Redis缓存
        $name = Cache::store('redis')->get('age');

        return json($name);
    }
}