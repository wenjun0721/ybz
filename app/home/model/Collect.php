<?php
namespace app\home\model;
use think\Db;
use think\Session;
class Collect extends Base
{
    public function collect()
    {
    	$where['userId'] = input('userId/d',0);
    	$where['isok']   = 1;
        $where['isshow']   = 1;
    	$res = Db::name('collection')->where($where)->order(SO_ADDTIME_COMMON)->select();
        if (empty($res)) {
            return json_encode(WSTReturn('亲，您没有收藏任何的锦集呢,可以去"每天100分"挑选哦，么么哒！'));
        }
    	foreach ($res as $k => $v) {
            $img = Db::name('sharer_img')->where(['sharerId'=>$v['sharerId'],'isshow'=>1])->order('sort asc,id desc')->limit(1)->value('img');
            if ($img) {
                $res[$k]['bgImg'] = WEBURL.$img;
                $res[$k]['select'] = false;
            }else{
                // $res[$k]['bgImg'] = WEBURL.'upload/common/logo.png';
                unset($res[$k]);
            }
        }
        $res = array_values($res);
        if (empty($res)) {
            return json_encode(WSTReturn('亲，您的收藏锦集可能被该主人删除,可以去"每天100分"挑选哦，么么哒！'));
        }
    	return json_encode(WSTReturn('success',1,$res));
    }

    public function collectDel()
    {
        $userId = input('userId/d',0);
        $ids = input('Ids','');
        if (empty($ids)) {
            return json_encode(WSTReturn('请选择要删除的锦集'));
        }
        $where['userId'] = $userId;
        $where['id'] = ['in',$ids];
        $res = Db::name('collection')->where($where)->update(['isok'=>0,'del_time'=>time()]);
        if ($res) {
            return json_encode(WSTReturn('删除成功',1));
        }else{
            return json_encode(WSTReturn('删除失败'));
        }
    }

    public function collectRead()
    {
        $sharerId = input('sharerId/d',0);
        $where['isshow']   = 1;
        $where['isSharer'] = 1;
        $where['id']   = $sharerId;

        $sharerWhere['sharerId']=$sharerId;
        $sharerWhere['isshow']   = 1;
        //判断锦集是否能被查看
        $sharer = Db::name('sharer')->where($where)->find();
        if (empty($sharer)) {
            return json_encode(WSTReturn('此锦集已被该主人删除了哦！可以点击右下角按钮查看她的主页哦'));
        }
        $xp = Db::name('sharer_img')->where($sharerWhere)->order(SO_SORT_COMMON)->limit(30)->select();
        if (empty($xp)) {
            return json_encode(WSTReturn('此锦集已被该主人删除了哦！可以点击右下角按钮查看她的主页哦'));
        }
        //获取音乐ID
        $videoId = $sharer['videoId'];
        $sharerUserId  = $sharer['userId'];
        $video   = Db::name('video')->where(['id'=>$videoId])->value('video');
        foreach ($xp as $k => $v) {
            $xp[$k]['img'] = WEBURL.$v['img'];
        }
        //判断是否已经收藏了
        $co = Db::name('collection')->where(['sharerId'=>$sharerId,'isok'=>1])->count();
        $co = empty($co)?1:0;
        $rs['xp'] = $xp;
        $rs['video'] = $video;
        $rs['sharerUserId'] = $sharerUserId;
        $rs['co'] = $co;
        echo(json_encode(WSTReturn('success',1,$rs)));die;
    }

    public function collectOne()
    {
        $userId = input('userId/d',0);
        $sharerId = input('sharerId/d',0);
        $co = input('co/d',0);
        //co 等于0 代表已经收藏了
        $where['userId'] = $userId;
        $where['sharerId'] = $sharerId;
        if (empty($co)) {
            $res = Db::name('collection')->where($where)->update(['isok'=>0,'del_time'=>time()]);
            return json_encode(WSTReturn('取消收藏',1,1));
        }else{
            //先看看是否已经收藏了的，有收藏的话，就直接修改，没有的话就添加
            $res = Db::name('collection')->where($where)->count();
            if (empty($res)) {
                $where['add_time'] = time();
                $res = Db::name('collection')->insert($where);
            }else{
                $res = Db::name('collection')->where($where)->update(['isok'=>1,'del_time'=>'']);
            }
            return json_encode(WSTReturn('收藏成功',1,-1));
        }
        
    }

    public function sharerUserList()
    {
        $sharerUserId = input('sharerUserId/d',0);
        $where['isshow']   = 1;
        $where['isSharer'] = 1;
        $where['userId']   = $sharerUserId;
        
        //判断锦集是否有分享锦集
        $sharerUserList = Db::name('sharer')->where($where)->select();
        if (empty($sharerUserList)) {
            return json_encode(WSTReturn('他/她没有分享过锦集哦'));
        }

        foreach ($sharerUserList as $k => $v) {
            $img = Db::name('sharer_img')->where(['sharerId'=>$v['id'],'isshow'=>1])->order('sort asc,id desc')->limit(1)->value('img');
            if ($img) {
                $sharerUserList[$k]['bgImg'] = WEBURL.$img;
            }else{
                // $sharerUserList[$k]['bgImg'] = WEBURL.'upload/common/logo.png';
                unset($sharerUserList[$k]);
            }
        }
        $sharerUserList = array_values($sharerUserList);
        echo(json_encode(WSTReturn('success',1,$sharerUserList)));die;
    }
    
}
