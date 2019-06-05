<?php
namespace app\home\model;
use think\Db;
use think\Session;
class Index extends Base
{
    
    public function banner()
    {
        
        $data = Db::name('banner')->where('catId','in','0,1')->order('id desc')->select();
        foreach ($data as $k => $v) {
            $v['img'] = WEBURL.$v['img'];
            $key = $v['catId'];
            $arr[$key][] = $v;
        }
        echo(json_encode(WSTReturn('success',1,$arr)));die;
    }
    
}
