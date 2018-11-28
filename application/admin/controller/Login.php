<?php
namespace app\admin\controller;

use think\Controller;

//use namespace app\common\lib\IAuth;

use app\common\lib\IAuth;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function check(){
        if(request()->isPost()){
            $data = input('post.');
            //halt($data);
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            };
            //判定输入合法 validate
            $validate = validate('AdminUser');
            if(!$validate->check($data)) {
                $this->error($validate->getError());
            }

            try {
                $user = model('AdminUser')->get(['username' => $data['username']]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
                //这里改用extra里面code.php的状态码参数
//                if(!$user || $user->status != 1){
//                    $this->error('该用户不存在');
//                }
                if(!$user || $user->status != config('code.status_normal')){
                    $this->error('该用户不存在');
                }

                //再对密码校验
                //这里代码复用了！！！
//            $data['password'] = md5($data['password'].'_#maxboren');
//            if($data['password'] != $user['password']){
//                $this->error('密码不正确');
//            }
                if(IAuth::setPassword($data['password']) != $user['password']){
                    $this->error('密码不正确');
                }
                //1.更新数据库，登陆时间，Ip等
                //2.把用户保存到session
                //1.
                $udata = [
                    'last_login_time' => time(),
                    'last_login_ip' => request()->ip(),
                ];
            try{
                model('AdminUser')->save($udata,['id'=>$user->id]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            };
            //2.session 1.1 标识， 2.内容 3作用域
            session(config('admin.session_user'),$user,config('admin.session_user_scope'));
            $this->success('登陆成功','index/index');
        }else{
            $this->error("请求不合法");
        }



    }
}
