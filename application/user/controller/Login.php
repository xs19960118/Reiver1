<?php


namespace app\user\controller;


use app\common\TokenVerify;
use think\Controller;

class Login extends Controller
{
    public function Login ()
    {
        $username = input('username'); // 获取用户名
        $password = input('password'); // 获取密码
        // 获取用户信息
        $info = model('common/User')->findUserInfoByUserNameAndPwd($username, $password);

        // 未查到相关信息
        if (!$info) {
            return json([
                'msg' => '密码或用户名输入错误',
                'status' => 'fail'
            ]);
        }

        // 签发token给客户端
        $var = (new TokenVerify)->creatToken($info);
        halt($var);

    }
}