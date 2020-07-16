<?php

namespace Admin\Controller;

/**
 * 实名认证
 * @author 
 */
class PhonerechargeController extends AdminController
{
    /**
     * 实名认证列表
     * @author 
     */
    public function index()
    {

        $phone_recharge = M('phone_recharge'); // 实例化User对象
        $count      = $phone_recharge->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $phone_recharge->limit($Page->firstRow.','.$Page->listRows)->order('status asc,id desc')->select();
        foreach($list as $k => $v){
            $list[$k]['username'] = M('user')->where(array('userid'=>$v['uid']))->getField('username');
            $list[$k]['account'] = M('user')->where(array('userid'=>$v['uid']))->getField('account');
            $list[$k]['mobile'] = M('user')->where(array('userid'=>$v['uid']))->getField('mobile');
        }

        $this->assign('show',$show);
        $this->assign('list',$list);
        $this->display();
    }

    // 通过
    public function setYesVerify(){
        $id = (int)I('id');
        $is_exis = M('phone_recharge')->where(array('id'=>$id,'status'=>0))->field('price_num,uid')->find();
        if(!$is_exis){
            $this->error('该订单状态错误，请重试');
        }
        M()->startTrans();
        $res = M('phone_recharge')->where(array('id'=>$id))->setField('status',1);
        
        if($res !== false){
            M()->commit();
            $this->success('审核通过成功');
        }else{
            M()->rollback();
            $this->error('审核通过失败，请重试');
        }
    }

    // 不通过
    public function setNoVerify(){
        $id = (int)I('id');
        $is_exis = M('phone_recharge')->where(array('id'=>$id,'status'=>0))->count();
        if(!$is_exis){
            $this->error('该订单状态错误，请重试');
        }
        M()->startTrans();
        $res = M('phone_recharge')->where(array('id'=>$id))->setField('status',2);
        //返还用户积分
        $phone_recharge = M('phone_recharge')->where(array('id'=>$id))->field('uid,price_num')->find();
        $res2 = M('user')->where(array('userid'=>$phone_recharge['uid']))->setInc('total_lingshi',$phone_recharge['price_num']);

        //添加记录
        $total_lingshi = M('user')->where(array('userid'=>$userid))->getField('total_lingshi');
        $tm['pay_id'] = 0;
        $tm['get_id'] = $uid;
        $tm['get_nums'] = $phone_recharge['price_num'];
        $tm['get_time'] = time();
        $tm['get_type'] = 33;
        $tm['now_nums'] = $total_lingshi;
        M('tranmoney')->add($tm);


        if($res !== false && $res2 !== false){
            M()->commit();
            $this->success('审核不通过成功');
        }else{
            M()->rollback();
            $this->error('审核不通过失败，请重试');
        }
    }
    
}
