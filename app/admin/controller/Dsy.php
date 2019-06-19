<?php
namespace app\admin\controller;
use think\Db;
class Dsy extends Base
{
    public function index()
    {
        
    	$rs = Db::name('dsy')->order('id desc')->paginate(30);
        $page = $rs->render();
        $res = $rs->toArray();
    	foreach ($res['data'] as $k => $v) {
    		$res['data'][$k]['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    	}
        $catName = ['左上角','上居中','右上角','左居中','居中','右居中','左下角','下居中','右下角'];
        $setUpFontColorArr=['黑色','白色','粉红色','灰色','天蓝色','碧绿色','淡紫色','浅灰蓝色','淡黄色','乌贼墨棕','孔雀蓝','土耳其玉色'];
    	$this->assign('catName',$catName);
        $this->assign('setUpFontColorArr',$setUpFontColorArr);
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
        $setUpFontColorArr = ['#000000','#FFFFFF','#FFC0CB','#C0C0C0','#F0FFFF','#00C957','#DA70D6','#B0E0E6','#F5DEB3','#5E2612','#33A1C9','#00C78C'];
        $fontColor = $setUpFontColorArr[input('color')];
        
        $backGroundImg = $_FILES['img']['tmp_name'];
        //生成带水印的图片
        require(ROOT_PATH.'/vendor/topthink/think-image/src/Image.php');
        $image = \think\Image::open($backGroundImg);
        //生成图片位置
        $file = date('Ymd');
        $file_path = './upload/dsy/'.$file;
        if(!file_exists($file_path))
        {
            mkdir ($file_path,0777,true);
        }
        $fileName = 'upload/dsy/'.$file.'/'.date('YmdHis').rand(10000,100000).'.jpg';
        $path="./".$fileName;
        // 字体
        $fontFamily = './upload/font/zt.ttf';
        $wz  = input('catId');
        $str = input('name');
        $fontSize = input('fontSize');
        $fontSize = $fontSize?$fontSize:16;
        $image->text($str, $fontFamily, $fontSize, $fontColor,$wz)->save($path);
        
        $data['img'] = $fileName;
        $data['add_time'] = time();
        $data['name'] = $str;
        $res = Db::name('dsy')->insert($data);
        if ($res) {
            $this->tips('打水印成功',1,Url('Dsy/index'));
        }else{
            $this->tips('打水印失败');
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
