<?php

namespace Admin\Controller;

/**
 * 实名认证
 * @author 
 */
class UserComplaController extends AdminController
{
    /**
     * 实名认证列表
     * @author 
     */
    public function index()
    {

        $user_compla = M('user_compla c'); // 实例化User对象
        $count      = $user_compla->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $user_compla->join('ysk_deal d ON c.deal_id=d.id')->limit($Page->firstRow.','.$Page->listRows)->order('c.status asc,c.id desc')->field('c.id,c.uid,d.img')->select();
        foreach($list as $k => $v){
            $list[$k]['username'] = M('user')->where(array('userid'=>$v['uid']))->getField('username');
            $list[$k]['account'] = M('user')->where(array('userid'=>$v['uid']))->getField('account');
            $list[$k]['mobile'] = M('user')->where(array('userid'=>$v['uid']))->getField('mobile');
        }

        $this->assign('show',$show);
        $this->assign('list',$list);
        $this->display();
    }

    public function setYesVerify(){
        $id = (int)I('id');
        $compla = M('user_compla')->where(array('id'=>$id))->field('deal_id,uid')->find();
        if(!$compla){
            $this->error('该订单状态错误，请重试');
        }
        M()->startTrans();
        //将积分还给用户
        $deal = M('deal')->where(array('id'=>$compla['deal_id']))->find();

        $user_arr['djie_num'] = array('exp','djie_num - '.$deal['tprice']);
        $user_arr['total_lingshi'] = array('exp','total_lingshi + '.$deal['tprice']);
        $res = M('user')->where(array('userid'=>$compla['uid']))->save($user_arr);

        $total_lingshi = M('user')->where(array('userid'=>$compla['uid']))->getField('total_lingshi');
        $tm['pay_id'] = 0;
        $tm['get_id'] = $compla['uid'];
        $tm['get_nums'] = $deal['tprice'];
        $tm['get_time'] = time();
        $tm['get_type'] = 45;
        $tm['now_nums'] = $total_lingshi;
        M('tranmoney')->add($tm);

        $res2 = M('user_compla')->where(array('id'=>$id))->setField('status',1);
        // 删除订单
        $res3 = M('deal')->where(array('id'=>$deal['id']))->delete();
        if($res !== false && $res2 !== false&&$res3){
            M()->commit();
            $this->success('投诉成功');
        }else{
            M()->rollback();
            $this->error('投诉失败，请重试');
        }
    }

    public function setNoVerify(){
        $id = (int)I('id');
        $is_exis = M('user_compla')->where(array('id'=>$id,'status'=>0))->count();
        if(!$is_exis){
            $this->error('该订单状态错误，请重试');
        }
        $res = M('user_compla')->where(array('id'=>$id))->setField('status',2);
        if($res !== false){
            $this->success('投诉失败成功');
        }else{
            $this->error('投诉失败，请重试');
        }
    }
    
}
