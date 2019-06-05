<?php
namespace app\admin\controller;
use think\Db;
class Art extends Base
{
    public function index()
    {
    	$rs = Db::name('art')->order('id desc')->paginate(15);
        $page = $rs->render();
        $res = $rs->toArray();
    	foreach ($res['data'] as $k => $v) {
    		$res['data'][$k]['catName'] = $this->artCatName($v['catId']);
    		$res['data'][$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    	}

    	$this->assign('res',$res);
        $this->assign('page',$page);
    	return $this->fetch();
    }

    function artCatName($id=''){
        $arr = Db::name('cat')->order('catId desc')->select();
        if ($id !== '') {
            $name = '分类已被删除';
            foreach ($arr as $k => $v) {
                if ($v['catId'] == $id) {
                    $name = $arr[$k]['catName'];
                }
            }
            return $name;
        }else{
            return $arr;
        }
    }

    public function add()
    {
        $catName = $this->artCatName();
        $this->assign('catName',$catName);
        return $this->fetch();
    }

    public function toadd()
    {
        if ($_FILES['img']['error'] == 4) {
            $this->tips('没有上传广告图片');
        }
        $fielName = 'upload/image/'.date('Ymd');
        $dir = iconv("UTF-8", "GBK", ROOT_PATH .$fielName);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        $img =time().'.png';
        $fiel = $dir.DS.$img;
        move_uploaded_file($_FILES['img']['tmp_name'],$fiel);
        $data = input();
        $data['img'] = $fielName.'/'.$img;
        $data['add_time'] = time();
        $res = Db::name('art')->insert($data);
        if ($res) {
            $this->tips('添加成功',1,Url('Art/index'));
        }else{
            $this->tips('添加失败');
        }
    }

    public function del(){
        $id = input('id/d',0);
        if (empty($id)) {
             return json_encode('未知错误，刷新重试');
        }
        $art = Db::name('art')->where(['id'=>$id])->find();
        $res = Db::name('art')->where(['id'=>$id])->delete();
        if ($res) {
            @unlink('./'.$art['img']);
            return json_encode('删除成功');
        }else{
            return json_encode('删除失败');
        }
    }

    public function edit()
    {
        $id = input('id/d',0);
        $art = Db::name('art')->where(['id'=>$id])->find();
        $catName = $this->artCatName();
        $this->assign('catName',$catName);
        $this->assign('art',$art);
        return $this->fetch();
    }

    public function toedit()
    {
        $data = input();
        $id = $data['id'];
        if ($_FILES['img']['error'] != 4) {
            $fielName = 'upload/ads/'.date('Ymd');
            $dir = iconv("UTF-8", "GBK", ROOT_PATH .$fielName);
            if (!file_exists($dir)){
                mkdir ($dir,0777,true);
            }
            $img =time().'.png';
            $fiel = $dir.DS.$img;
            move_uploaded_file($_FILES['img']['tmp_name'],$fiel);
            $data['img'] = $fielName.'/'.$img;
            $art = Db::name('art')->where(['id'=>$id])->find();
            @unlink('./'.$art['img']);
        }
        $res = Db::name('art')->where(['id'=>$id])->update($data);
        if ($res) {
            
            $this->tips('修改成功',1,Url('Art/index'));
        }else{
            $this->tips('修改失败');
        }
    }

    public function upload(){
        $fielName = 'upload/image/'.date('Ymd');
        $dir = iconv("UTF-8", "GBK", ROOT_PATH .$fielName);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        $img =time().'.png';
        $fiel = $dir.DS.$img;
        move_uploaded_file($_FILES['iFile']['tmp_name'],$fiel);
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => '../../../'.$fielName.'/'.$img]);
    }
}
