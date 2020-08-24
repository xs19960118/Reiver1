<?php


namespace app\user;


use think\Controller;

class Login extends Controller
{
    private function Login ()
    {
        $username = input('post.username'); // 获取用户名
        $password = input('post.password'); // 获取密码
        // 获取用户信息
        $baseInfo = model('common/User')->findUserInfoByUserNameAndPwd($username, $password);
        
        return json($baseInfo);
    }
}