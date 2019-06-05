<?php
namespace app\admin\controller;
use think\Loader;
use think\Cache;
use think\Controller;
use think\Session;
class Index extends Base
{
    public function index()
    {
    	if (empty(Session::get('adminId'))) {
    		$url = Url('Login/index');
    		header("location:".$url."");exit;
    	}
    	return $this->fetch();
    }
}
