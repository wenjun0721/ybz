<?php
namespace app\admin\controller;
use think\Db;
class Ads extends Base
{
    public function index()
    {
    	$rs = Db::name('banner')->order('id desc')->paginate(15);
        $page = $rs->render();
        $res = $rs->toArray();
    	foreach ($res['data'] as $k => $v) {
    		$res['data'][$k]['catName'] = $this->adsCatName($v['catId']);
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

    public function toadd()
    {
        if ($_FILES['img']['error'] == 4) {
            $this->tips('没有上传广告图片');
        }
        $fielName = 'upload/ads/'.date('Ymd');
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
        $data['url'] = $data['url']?$data['url']:'###';
        $res = Db::name('banner')->insert($data);
        if ($res) {
            $this->tips('添加成功',1,Url('Ads/index'));
        }else{
            $this->tips('添加失败');
        }
    }

    public function del(){
        $id = input('id/d',0);
        if (empty($id)) {
             return json_encode('未知错误，刷新重试');
        }
        $banner = Db::name('banner')->where(['id'=>$id])->find();
        $res = Db::name('banner')->where(['id'=>$id])->delete();
        if ($res) {
            @unlink('./'.$banner['img']);
            return json_encode('删除成功');
        }else{
            return json_encode('删除失败');
        }
    }

    public function edit()
    {
        $id = input('id/d',0);
        $banner = Db::name('banner')->where(['id'=>$id])->find();
        $catName = $this->adsCatName();
        $this->assign('catName',$catName);
        $this->assign('banner',$banner);
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
            $banner = Db::name('banner')->where(['id'=>$id])->find();
            @unlink('./'.$banner['img']);
        }
        $data['url'] = $data['url']?$data['url']:'###';
        $res = Db::name('banner')->where(['id'=>$id])->update($data);
        if ($res) {
            
            $this->tips('修改成功',1,Url('Ads/index'));
        }else{
            $this->tips('修改失败');
        }
    }
}
