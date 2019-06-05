<?php
namespace app\admin\controller;
use think\Db;
class Cat extends Base
{
    public function index()
    {
    	$rs = Db::name('cat')->order('catId desc')->paginate(15);
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
        
        return $this->fetch();
    }

    public function toadd()
    {
        if ($_FILES['img']['error'] == 4) {
            $this->tips('没有上传广告图片');
        }
        $fielName = 'upload/cat/'.date('Ymd');
        $dir = iconv("UTF-8", "GBK", ROOT_PATH .$fielName);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        $img =time().'.png';
        $fiel = $dir.DS.$img;
        move_uploaded_file($_FILES['img']['tmp_name'],$fiel);
        $data = input();
        $data['catImg'] = $fielName.'/'.$img;
        $data['add_time'] = time();
        $res = Db::name('cat')->insert($data);
        if ($res) {
            $this->tips('添加成功',1,Url('Cat/index'));
        }else{
            $this->tips('添加失败');
        }
    }

    public function del(){
        $id = input('id/d',0);
        if (empty($id)) {
             return json_encode('未知错误，刷新重试');
        }
        $cat = Db::name('cat')->where(['catId'=>$id])->find();
        $res = Db::name('cat')->where(['catId'=>$id])->delete();
        if ($res) {
            @unlink('./'.$cat['catImg']);
            return json_encode('删除成功');
        }else{
            return json_encode('删除失败');
        }
    }

    public function edit()
    {
        $id = input('id/d',0);
        $cat = Db::name('cat')->where(['catId'=>$id])->find();
        $this->assign('cat',$cat);
        return $this->fetch();
    }

    public function toedit()
    {
        $data = input();
        $catId = $data['catId'];
        if ($_FILES['img']['error'] != 4) {
            $fielName = 'upload/cat/'.date('Ymd');
            $dir = iconv("UTF-8", "GBK", ROOT_PATH .$fielName);
            if (!file_exists($dir)){
                mkdir ($dir,0777,true);
            }
            $img =time().'.png';
            $fiel = $dir.DS.$img;
            move_uploaded_file($_FILES['img']['tmp_name'],$fiel);
            $data['catImg'] = $fielName.'/'.$img;
            $cat = Db::name('cat')->where(['catId'=>$catId])->find();
            @unlink('./'.$cat['catImg']);
        }
        $res = Db::name('cat')->where(['catId'=>$catId])->update($data);
        if ($res) {
            $this->tips('修改成功',1,Url('Cat/index'));
        }else{
            $this->tips('修改失败');
        }
    }
}
