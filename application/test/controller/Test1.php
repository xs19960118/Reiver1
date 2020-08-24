<?php


namespace app\test\controller;


use think\Controller;

class Test1 extends Controller
{
    // 测试连接数据库
    protected function testConn()
    {
//        return 'in';

        $user = model('common/User')::get(1);

        return json($user);
    }

}