<?php

namespace app\http\middleware;

use app\common\TokenVerify;
use think\facade\Request;

class Check
{
    // 放行的baseUrl
    private static array $release = [
        // 放行用户进行注册
        'http://rangeloney.com/index.php/user/index/register',
        'https://rangeloney.com/index.php/user/index/register',
        // 测试时放行 login
        // 'http://rangeloney.com/index.php/user/index/login',
        // 'https://rangeloney.com/index.php/user/index/login',
    ];

    // 入口方法
    public function handle($request, \Closure $next)
    {
        // 获取 baseUrl，不要查询字符串
        $baseUrl = Request::baseUrl(true);

        // 请求放行
        if (in_array($baseUrl, self::$release) || !isset($token) || $token === '') {
            return $next($request);
        }

        // 获取请求中的 token 和 uid
        $token = $request->header('token');
        $back = []; // 定义一个用于返回消息的数组

        // token 验证
        $res = (new TokenVerify())->checkToken($token);
        if (!$res) {
            list($back['status'], $back['msg']) = ['101', 'token验证失败'];
        } else { // 验证成功则用户不需要登录，前台控制页面的跳转
            list($back['status'], $back['msg']) = ['100', 'token验证成功'];
        }

        return json($back);
    }
}
