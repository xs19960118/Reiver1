<?php


namespace app\common;

use Exception;
use think\Controller;
use \Firebase\JWT\JWT;
use think\facade\Cache;


class TokenVerify extends Controller
{

    // redis 键前缀
    private static string $redisPrefix = 'xs';

    // redis 过期时间
    private static int $redisExpire = 7200;

    // secret
    private static string $secret = '214';

    /**
     * 于生成一个 token
     * @param $info
     * 需要用户的部分信息
     * @return array
     * 返回一个数组，包含：token、uid、身份、权限
     */
    public function creatToken($info)
    {
        $secret = self::$secret; // secret
        $time = time(); // 当前时间
        $uid = md5($info['id'] . $info['username'] . $time); // 生成uid
        $payload = [ // payload
            'iss' => 'http://rangeloney.com', // 签发者 可选
            'aud' => [ // 接收该JWT的一方，可选
                'identity' => $info['identity'], // 用户身份
                'power' => $info['power'] // 权限数字
            ],
            'iat' => $time, // 签发时间
            'nbf' => $time, // 某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
            'exp' => $time + 3600 * 2, // 过期时间,这里设置2个小时
            'data' => [ // 自定义信息
                'uid' => $uid,
                'username' => $info['username']
            ]
        ];

        // 将这个 token 存到 redis中,设置键为：前缀 + 用户名，设置值为 uid
        $key = self::$redisPrefix . '_' . $info['username'];
        Cache::store('redis')->set($key, $uid, self::$redisExpire);

        // 返回 token (将其他信息都存在了token中，我并不需要额外设置)
        $token = JWT::encode($payload, $secret, 'HS256');
        return [
            'token' => $token, // token
        ];
    }

    /**
     * token验证
     * @param $token
     * 客户端传入的 token
     * @return bool
     * 返回 true 验证通过，返回 false 验证位通过
     */
    public function checkToken($token)
    {
        try {
            $clientToken = JWT::decode($token, self::$secret, ['HS256']); // 解码来自客户端的 token
            $tokenArr = self::object_array($clientToken); // stdClass 转 array
            list($username, $uid) = [$tokenArr['data']['username'], $tokenArr['data']['uid']];
            $redis = Cache::store('redis')->handler();
            $key = self::$redisPrefix . '_' . $username;

            // 如果这个键不存在则验证失败
            if (!$redis->exists($key)) {
                return false;
            }

            // 从新设置这个 token 的过期时间，达到延长的效果
            Cache::store('redis')->set($key, $uid, self::$redisExpire);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    // PHP stdClass Object转 array
    private static function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }

}