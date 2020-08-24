<?php


namespace app\user;


use think\Controller;

class Login extends Controller
{
    private function Login ()
    {
        // 获取用户名
        // 获取密码
        model('common/User')::findOrEmpty();
    }
}