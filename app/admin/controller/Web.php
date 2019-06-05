<?php
namespace app\admin\controller;
use think\Db;
class Web extends Base
{
    public function index()
    {
    	$rs = Db::name('web')->order('id asc')->paginate(15);
        $page = $rs->render();
        $res = $rs->toArray();
    	
    	$this->assign('res',$res);
        $this->assign('page',$page);
    	return $this->fetch();
    }
    
    public function edit()
    {
        $id = input('id/d',0);
        $web = Db::name('web')->where(['id'=>$id])->find();
        $this->assign('web',$web);
        return $this->fetch();
    }

    public function toedit()
    {
        $data = input();
        $id = $data['id'];
        $res = Db::name('web')->where(['id'=>$id])->update($data);
        if ($res) {
            $this->tips('修改成功',1,Url('Web/index'));
        }else{
            $this->tips('修改失败');
        }
    }
}
