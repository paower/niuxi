<?php

namespace Admin\Controller;

/**
 * 赠送星座
 * @author 
 */
class GiftScrollController extends AdminController
{
    /**
     * 赠送星座列表
     * @author 
     */
    public function index()
    {
        $list = M('gift_scroll gs')->join('ysk_user u ON gs.uid=u.userid')->join('ysk_scroll s ON gs.scroll_id=s.id')->field('gs.id,u.account,u.username,u.mobile,s.title')->order('gs.id desc')->select();
        $this->assign('list',$list);
        $this->display();
    }


    public function add(){
        if(IS_POST){
            $mobile = I('mobile');
            $scroll_id = (int)I('scroll_id');
            if($mobile == ''){
                $this->error('用户手机号不能为空');
            }
            $is_mobile = M('user')->where(array('mobile'=>$mobile))->field('userid')->find();
            if(!$is_mobile){
                $this->error('该手机号不存在');
            }
            
            $is_scroll = M('scroll')->where(array('id'=>$scroll_id))->count();
            if(!$is_scroll){
                $this->error('该星座不存在');
            }

            M()->startTrans();

            //赠送星座
            $uscroll['uid'] = $is_mobile['userid'];
            $uscroll['scroll_id'] = $scroll_id;
            $uscroll['overtime'] = time() + 40 * 86400;
            $uscroll['status'] = 1;
            $res3 = M('user_scroll')->add($uscroll);

            //为用户添加活跃度
            $active = M('scroll')->where(array('id'=>$scroll_id))->getField('active');
            M('user')->where(array('userid'=>$is_mobile['userid']))->setInc('total_active',$active);

            $total_active = M('user')->where(array('userid'=>$is_mobile['userid']))->getField('total_active');
            $tm['pay_id'] = 0;
            $tm['get_id'] = $is_mobile['userid'];
            $tm['get_nums'] = $active;
            $tm['get_time'] = time();
            $tm['get_type'] = 43;
            $tm['now_nums'] = $total_active;
            M('tranmoney')->add($tm);

            //添加步数记录
            // $step = M('scroll')->where(array('id'=>$scroll_id))->getField('step_num');
            // $step_num = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$is_mobile['userid'],'us.status'=>1))->order('s.step_num desc')->getField('s.step_num');
            // $add_step = M('user')->where(array('userid'=>$is_mobile['userid']))->getField('add_step');
            // $tm3['pay_id'] = 0;
            // $tm3['get_id'] = $is_mobile['userid'];
            // $tm3['get_nums'] = $step;
            // $tm3['get_time'] = time();
            // $tm3['get_type'] = 44;
            // $tm3['now_nums'] = $step_num+$add_step;
            // M('tranmoney')->add($tm3);

            $gift['uid'] = $is_mobile['userid'];
            $gift['scroll_id'] = $scroll_id;
            $res = M('gift_scroll')->add($gift);
            if($res){
                M()->commit();
                $this->success('赠送星座成功',U('GiftScroll/index'));
            }else{
                M()->rollback();
                $this->error('赠送星座失败');
            }


        }

        $list = M('scroll')->select();
        $this->assign('list',$list);
        $this->display();
    }

    public function del(){
        $id = (int)I('ids');
        $scroll_exis = M('gift_scroll')->where(array('id'=>$id))->count();
        if(!$scroll_exis){
            $this->error('该参数不存在，请重试');
        }

        $res = M('gift_scroll')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }
    
}
