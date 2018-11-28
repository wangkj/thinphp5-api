<?php
namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //halt(session(config('admin.session_user'),'',config('admin.session_user_scope')));
        return $this->fetch();
    }

    public function welcome()
    {
        return "hello thinkphp";
    }

    public function logout(){
//        1.清空session
//        2.转到登陆页面
        //清空指定作用域全部内容
        session(null, config('admin_user_scope'));
        //跳转
        $this->redirect('login/index');
    }
}
