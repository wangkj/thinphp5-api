<?php
namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
{
    public function add()
    {
        if(request()->isPost()){
            //这个是打印 post 方法
            //dump(input('post.'));
            //halt = dump + exit
            $data = input('post.');
            // validate 校验机制
            $validate = validate('AdminUser');
            //test
            //halt($validate->check($data));
            if(!$validate->check($data)) {
                $this->error($validate->getError());
            }

            $data['password'] = md5($data['password'].'_#maxboren');
            $data['status'] = 1;

            try {
                $id = model('AdminUser')->add($data);
            }catch (\exceotion $e) {
                $this->error($e->getMessage());
            }
            //测试是否插入成功，即id是否存在
            if($id) {
                $this->success('id='.$id.'的用户新增成功');
            }else {
                $this->error('error');
            }

        }else{
            return $this->fetch();
        }

    }

}
