<?php

namespace app\http\middleware;

use app\common\TokenVerify;
use think\Cache;
use think\facade\Request;

class Check
{

    // 放行的baseUrl
    private static $release = [
        'http://rangeloney.com/index.php/user/index/login',
    ];

    // 入口方法
    public function handle($request, \Closure $next)
    {
        // 获取 baseUrl，不要查询字符串
        $baseUrl = Request::baseUrl(true);

        // 获取请求中的 token 和 uid
        $token = $request->header('token');
        $uid = $request->header('uid');

        // 不能为 null
        if (!isset($token, $uid)) {
            return redirect('/index.php/user/login/login');

//            return json([
//                'status' => 101,
//                'msg' => 'token或uid为null'
//            ]);
        }

        // 不能为 ''
        if ($token === '' || $uid === '') {
            return json([
                'status' => 102,
                'msg' => 'token或uid为空字符串'
            ]);
        }

        // token 验证
        $res = (new TokenVerify())->checkToken($token, $uid);
        if (!$res) {
            return json([
                'status' => 103,
                'msg' => 'token 验证失败'
            ]);
        }

        // 请求放行
        return $next($request);
    }
}
