<?php


namespace app\user\controller;


use app\common\TokenVerify;
use think\Controller;

class Index extends Controller
{
    /**
     * 用户登录：用户名密码正确后签发 token 给客户端端
     * @return string|
     */
    public function Login()
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
        return json((new TokenVerify)->creatToken($info));
    }

    // 用户注册
    public function Register()
    {

        return '进行用户注册';
        // 用户名
        // 手机号
        // 密码
    }

}