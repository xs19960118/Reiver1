<?php


namespace app\common;

use think\Controller;
use \Firebase\JWT\JWT;
use think\facade\Cache;

//导入JWT

class TokenVerify extends Controller
{

    // redis 键前缀
    private static $redisPrefix = 'xs';

    // redis 过期时间
    private static $redisExpire = 7200;

    // 用于生成一个 token
    public function creatToken($info)
    {
        $secret = '214'; // key
        $time = time(); // 当前时间
        $uid = md5($info['id'] . $info['username'] . $time); // 生成uid

        // payload
        $payload = [
            'iss' => 'http://rangeloney.com', // 签发者 可选
            'aud' => [ // 接收该JWT的一方，可选
                'identity' => $info['identity'], // 用户身份
                'power' => $info['power'] // 权限数字
            ],
            'iat' => $time, // 签发时间
            'nbf' => $time, // 某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time + 3600 * 2, // 过期时间,这里设置2个小时
            'data' => [ // 自定义信息，不要定义敏感信息
                'uid' => $uid,
                'username' => $info['username']
            ]
        ];
        // 将这个token存到 redis中
        $key = self::$redisPrefix . '_' . $uid;
        Cache::store('redis')->set('', 'value', 3600);

        // 返回 token
        $token = JWT::encode($payload, $secret, 'HS256');
    }

    // token及uid验证
    public function verifyToken($token)
    {
        // 判断是否存在

        // 若存在判断token是否过期


    }

}