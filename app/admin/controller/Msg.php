<?php
namespace app\admin\controller;
use think\Db;
class Msg extends Base
{
    public function index()
    {
    	$rs = Db::name('msg')->order('isRead asc,isok asc,id desc')->where(['isdel'=>0])->paginate(15);
        $page = $rs->render();
        $res = $rs->toArray();
    	foreach ($res['data'] as $k => $v) {
    		$res['data'][$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    	}
    	$this->assign('res',$res);
        $this->assign('page',$page);
    	return $this->fetch();
    }

    public function add()
    {
        $catName = $this->adsCatName();
        $this->assign('catName',$catName);
        return $this->fetch();
    }

    public function del(){
        $id = input('id/d',0);
        if (empty($id)) {
             return json_encode('未知错误，刷新重试');
        }
        $res = Db::name('msg')->where(['id'=>$id])->update(['isdel'=>1,'del_time'=>time()]);
        if ($res) {
            return json_encode('删除成功');
        }else{
            return json_encode('删除失败');
        }
    }

    public function edit()
    {
        $id = input('id/d',0);
        Db::name('msg')->where(['id'=>$id])->update(['isRead'=>1]);
        $msg = Db::name('msg')->where(['id'=>$id])->find();
        $this->assign('msg',$msg);
        return $this->fetch();
    }


    public function chuli(){
        $id = input('id/d',0);
        $isok = input('isok/d',0);
        if (empty($id)) {
             return json_encode('未知错误，刷新重试');
        }
        $msg = Db::name('msg')->where(['id'=>$id])->update(['isok'=>$isok]);
        if ($msg) {
            return json_encode('处理成功');
        }else{
            return json_encode('处理失败，请刷新重新处理');
        }
    }
}
