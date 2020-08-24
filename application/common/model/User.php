<?php


namespace app\common\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Model;

class User extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'user';

    // 设置主键
    protected $pk = 'IDX';

    // 根据用户名和密码查询单个用户信息
    public function findUserInfoByUserNameAndPwd($username, $password)
    {
        try {
            $user = User::where([
                'USERNAME' => $username,
                'PASSWORD' => $password
            ])->findOrEmpty();
        } catch (DataNotFoundException $e) {
            return '数据未查到:' . $e;
        } catch (ModelNotFoundException $e) {
            return '模型未查到:' . $e;
        } catch (DbException $e) {
            return '数据库连接异常' . $e;
        }

        return json($user);
    }

}