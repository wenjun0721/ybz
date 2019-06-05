<?php
namespace app\admin\controller;
/**
 * 基础控制器
 */
use think\Cache;
use think\Controller;
use think\Log;

class Base extends Controller {
	
    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$replace['__ADMIN__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/public/admin/';
        return $this->view->fetch($template, $vars, $replace, $config);
    }

    function adsCatName($id=''){
    	$arr = ['首页轮播','首页中部轮播','预约服务'];
        if ($id !== '') {
            return $arr[$id];
        }else{
            return $arr;
        }
    	
    }

    function tips($msg='错误',$status='-1',$url=''){
        if ($status == 1) {
            echo '<script>alert("'.$msg.'");window.location.href="'.$url.'";</script>';exit;
        }else{
            echo '<script>alert("'.$msg.'");history.back();</script>';exit;
        }
        
    }

}