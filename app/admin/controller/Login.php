<?php
namespace app\admin\controller;
use think\Session;
use think\Db;
class Login extends Base
{
    public function index()
    {
    	return $this->fetch();
    }

    public function login()
    {
    	$data = input();
    	if ($data['name'] == '' || $data['password'] == '') {
    		$this->tips('请填写完整信息');
    	}

    	$data['password'] = md5($data['password']);
    	$res = Db::name('adminuser')->where($data)->find();
    	if (empty(count($res))) {
    		$this->tips('用户名或密码错误');
    	}
    	Session::set('adminId',$res['id']);
    	$this->tips('登录成功',1,Url('Index/index'));
    }
}
