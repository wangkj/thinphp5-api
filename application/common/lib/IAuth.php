<?php
namespace app\common\lib;

class IAuth
{
    //设置密码md5这的代码复用
    public static function setPassword($data) {
        return md5($data.config('app.password_pre_halt'));
    }

}
