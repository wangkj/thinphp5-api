<?php
namespace app\common\model;


use think\Model;

class AdminUser extends Model
{
    //再model层直接加以写默认的不用操作的参数，例如创建时间
    protected  $autoWriteTimestamp = true;
    public function add($data) {
        if(!is_array($data)){
            exception('传递数据不合法');
        }
        $this->allowField(true)->save($data);

        return $this->id;
    }

}
