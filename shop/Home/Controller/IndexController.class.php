<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController
{

  

    public function index()
    {

        $userid = session('userid');
		$wheres['sell_id|pay_id']=$userid;
		$wheres['status'] = 1;
		 //长时间未打款
		$chaoshi = M('deal')->where($wheres)->order('id asc')->select();
		foreach($chaoshi as $k=>$v){
			$time = $v['expiration_time']-time();
			if($time<0){
				$data['status'] = 0;
				$data['expiration_time'] = 0;
				$data['pay_id'] = 0;
				$save = M('deal')->where(array('id'=>$v['id']))->save($data);
			}
		}
		$whered['sell_id|pay_id'] = $userid;
		$whered['status'] = 2;
		$chaoshi2 = M('deal')->where($whered)->order('id asc')->select();
		foreach($chaoshi2 as $key=>$value){
			$time = $value['expiration_time']-time();
			
			if($time<0){
				$res = M('deal')->where(array('id'=>$value['id']))->setField(['status'=>3,'end_time'=>time()]);
				//出售用户
				// $tran_fee_lingshi = ($deal['tprice']-$deal['fee_num'])/$deal['dprice'];
				$lingshi = ($value['tprice'] - $value['fee_num'])/$value['dprice']; //积分数量
				M('user')->where(array('userid'=>$value['sell_id']))->setDec('djie_num',$lingshi);
				
				// 购买用户
				M('user')->where(array('userid'=>$value['pay_id']))->setInc('total_lingshi',$lingshi);
				
				//添加记录
				$total_lingshi = M("user")->where(array('userid'=>$value['pay_id']))->getField('total_lingshi');
				$tm['pay_id'] = 0;
				$tm['get_id'] = $value['pay_id'];
				$tm['get_nums'] = $lingshi;
				$tm['get_time'] = time();
				$tm['get_type'] = 32;
				$tm['now_nums'] = $total_lingshi;
				M('tranmoney')->add($tm);
			}
		}
        //轮播
        $banner = M('banner');
        $banner_list = $banner->order('sort asc')->select();
        $this->assign('banner_list',$banner_list);
		//公告
		$type = (int)I('type')?(int)I('type'):1;
        $where['type'] = $type;
        $newinfo = M('news')->where($where)->order('id desc')->limit(8)->select();
        $this->assign('newinfo', $newinfo);
        $this->assign('type',$type);
        //星座列表
        $list = M('scroll')->where(array('status'=>1))->select();
		foreach($list as $key => $value){
            $yuyue_start_time = strtotime($value['yuyue_start_time']);
            $yuyue_end_time = strtotime($value['yuyue_end_time']);
            $start_time = strtotime($value['start_time']);
            $end_time = strtotime($value['end_time']);
            $list[$key]['state'] = 3;
            
            if(time() > $yuyue_start_time && time() < $yuyue_end_time){
                $list[$key]['state'] = 1;
            }
            if(time() > $start_time && time() < $end_time){
                $list[$key]['state'] = 2;
            }
            $region = explode('-',$value['value_region']);
            $qujian1 = $region[0];
            $qujian2 = $region[1];
            $map['record_price'] = array(array('egt',$qujian1),array('elt',$qujian2));
            $map['record_status'] = 2;
            $map['out_uid'] = array('neq',$userid);
            $nums = M('record')->where($map)->select();
            
            if(empty($nums)){
                $list[$key]['state'] = 3;
            }
          
        }

        // exit;
		// var_dump($list);die();
//         foreach($list as $k => $v){
//             $is_scroll = M('user_scroll')->where(array('uid'=>$uid,'status'=>1,'scroll_id'=>$v['id']))->count();
//             if($is_scroll){
//                 $list[$k]['is_scroll'] = 1;
//             }else{
//                 $list[$k]['is_scroll'] = 0;
//             }
//         }
// 		$pic_array = $this->get_banner();
//         $repeat_exis = M('user_scroll')->where(array('uid'=>$userid,'status'=>1,'overtime'=>array('gt',time())))->count();
// 
//         $list2 = M('user_scroll')->alias('us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$uid,'us.status'=>1,'us.overtime'=>array('gt',time())))->field('s.single_num,s.reward_num,s.active,s.title,us.overtime')->select();
// 
//         $list3 = M('user_scroll')->alias('us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$uid,'us.status'=>0))->field('s.active,s.title,us.overtime')->select();
//         
//         $this->assign('repeat_exis',$repeat_exis);
        $this->assign('list',$list);
        // $this->assign('list2',$list2);
        // $this->assign('list3',$list3);
		$this->assign(array(
            'uinfo' => $uinfo,
            'moneyinfo' => $moneyinfo,
            'can_get' => $can_get,
            'is_setnums' => $is_setnums,
            'pic_array'=>$pic_array,
            'fUser'=>$fUser,
        ));   
            

            
		
        $where['userid'] = $userid;
		
        $pic_array = $this->get_banner();
        // $step_num = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->order('s.step_num desc')->getField('s.step_num');
        // $this->assign('step_num',$step_num);

        $uinfo = M('user')->where($where)->field('img_head,userid,releas_time,is_reward,today_releas,quanxian,vip_grade,total_lingshi,total_active')->find();
        $moneyinfo = M('store')->where(array('uid' => $userid))->field('cangku_num,fengmi_num')->find();
        
        // $is_real_name = M('user')->where(array('userid'=>$userid))->getField('is_real_name');
        // if(!$is_real_name){
        //     $this->redirect("/User/real_name");
        // }



        $user_scroll = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->field('s.single_num')->select();
        $get_lingshi = 0;
        foreach($user_scroll as $k => $v){
            $get_lingshi += $v['single_num'];
        }

        $clock = M('user_clock')->where(array('uid'=>$userid))->order('id desc')->field('lasttime,get_num')->find();
        $todaytime = strtotime(date('Y-m-d'));
        if($todaytime > $clock['lasttime']){
            $this->assign('get_lingshi',$get_lingshi);
            $this->assign('isClock',1);
        }else{
            $this->assign('get_lingshi',$clock['get_num']);
            $this->assign('isClock',0);
        }

        // 获取用户星座数
        $scroll_count = M('user_scroll')->where(array('uid'=>$userid,'status'=>1))->count();
        $this->assign('scroll_count',$scroll_count);

		

        //今日是否已经领取释放收益
        if (IS_AJAX) {
            if ($can_get > 0) {
                $getnums = $can_get;
                $nowjif=$moneyinfo['fengmi_num'];
                if($can_get>$nowjif)$getnums=$nowjif;

                $datapay['cangku_num'] = array('exp', 'cangku_num + ' . $getnums);
                $datapay['fengmi_num'] = array('exp', 'fengmi_num - ' . $getnums);
                $res_pay_get = M('store')->where(array('uid' => $userid))->save($datapay);//每日银积分释放金积分
//                $res_pay_get = M('store')->where(array('uid' => $userid))->setInc('cangku_num',$getnums);//每日银积分释放金积分
//                $res_pay = M('store')->where(array('uid' => $userid))->setDec('fengmi_num',$getnums);//每日银积分释放金积分
                

                  if ($res_pay_get) {
                
                    $get_n = M('store')->where(array('uid' => $userid))->getfield('cangku_num');
                    $data['pay_id'] = $userid;
                    $data['get_id'] = $userid;
                    $data['get_nums'] = $getnums;
                    $data['now_nums_get'] = $get_n;
                    $data['now_nums'] = $get_n;
                    $data['is_release'] = 1;
                    $data['get_time'] = time();
                    $data['get_type'] = 2;


                }
                $res_addrs = M('tranmoney')->add($data);

                $get_ny = M('store')->where(array('uid' => $userid))->getfield('fengmi_num');
                $jifendets['pay_id'] = $userid;
                $jifendets['get_id'] = $userid;
                $jifendets['get_nums'] = -$getnums;
                $jifendets['now_nums'] = $get_ny;
                $jifendets['now_nums_get'] = $get_ny;
                $jifendets['is_release'] = 1;
                $jifendets['get_time'] = time();
                $jifendets['get_type'] = 1;
                M('tranmoney')->add($jifendets);


                
                 //C宝冻结资产释放
                 $jshu=array(100,1000,5000,10000);
                 $shifshu=$total_wb*0.01;
                 $canshif=$huafei_total-$shifshu;//可以释放的冻结资产数
 
                 if($canshif<0)$shifshu=$huafei_total;
 
                if($shifshu>0){
                $datawb['huafei_total'] = array('exp', 'huafei_total - ' . $shifshu);
                $datawb['plant_num'] = array('exp', 'plant_num + ' . $shifshu);
                M('store')->where(array('uid' => $userid))->save($datawb);
                }


                //添加C宝交易记录
                $wbaoss["crowds_id"]=0;
                $wbaoss["create_time"]=time();
                $wbaoss["num"]=$shifshu;
                $wbaoss["uid"]=$userid;
                $wbaoss["dprice"]=0;
                $wbaoss["tprice"]=0;
                $wbaoss["type"]=3;//静态
                $wbao_ss = M('wbao_detail')->add($wbaoss);

                $wbaossd["crowds_id"]=0;
                $wbaossd["create_time"]=time();
                $wbaossd["num"]=$wb_dtotal;
                $wbaossd["uid"]=$userid;
                $wbaossd["dprice"]=0;
                $wbaossd["tprice"]=0;
                $wbaossd["type"]=4;//动态
                $wbao_ssd = M('wbao_detail')->add($wbaossd);
               
                    $dataper['today_releas'] = 0;
                    $dataper['is_reward'] = 1;
                    $dataper['releas_time'] = time();
                    $res_pay = M('user')->where(array('userid' => $userid))->save($dataper);//每日银积分释放金积分
                    if ($res_pay) {
                        $isgetnums = showtwo($getnums);
                        $res = $isgetnums . '银积分释放到金积分成功';
                        ajaxReturn($res, 1, '/Index/index');
                    }
            }
        }

        $fUser = M('config')->where(array('name'=>'false_user'))->getField('value');
        $add_user = M('config')->where(array('name'=>'add_user'))->getField('value');
        
        $min_balance = M('config')->where(array('name'=>'min_balance'))->find();

        if($min_balance && $min_balance['status'] == 1){
            $this->assign('min_balance',$min_balance);
        }else{
            $min_balance['value'] = 0;
            $this->assign('min_balance',$min_balance);
        }

        $this->assign(array(
            'uinfo' => $uinfo,
            'moneyinfo' => $moneyinfo,
            'can_get' => $can_get,
            'is_setnums' => $is_setnums,
            'pic_array'=>$pic_array,
            'fUser'=>$fUser,
        ));
        $this->display('/Index/index');
    }
    //预约
    public function yyue(){
        if(IS_AJAX){
            $userid = session('userid');
            $scroll_id = I('id');
            $scrollinfo = M('scroll')->where(array('id' => $scroll_id))->find();
            
            $yuyue_start_time = strtotime($scrollinfo['yuyue_start_time']);
            $yuyue_end_time = strtotime($scrollinfo['yuyue_end_time']);
            //是否存在预约单
            $have = M('yuyue')->where(array('uid'=>$userid,'scroll_id'=>$scroll_id))->count();
            $haves = M('record')->where(array('in_uid'=>$uid,'scroll_id'=>$scroll_id))->count();
            if($have+1>$scrollinfo['max_size'] || $haves+1>$scrollinfo['max_size']){
                $this->ajaxReturn(array('Boolean' => false,'text' => '次数已达上限'));
            }
            if(time() > $yuyue_end_time){
                 $this->ajaxReturn(array('Boolean' => false,'text' => '预约时间结束了'));
            }
            $kou_nums = $scrollinfo['book_consume'];
            $member = M('user')->where(array('userid'=>$userid))->field('total_lingshi,is_real_name')->find();

            if($member['is_real_name']==0){
                $this->ajaxReturn(array('Boolean' => false,'text' => '请先进行实名验证'));
            }
            if($member['total_lingshi']<$kou_nums){
                 $this->ajaxReturn(array('Boolean' => false,'text' => '账户金额不足'));
            }
            //添加预约表
            $yuyues['uid'] = $userid;
            $yuyues['scroll_id'] = $scroll_id;
            $yuyues['time'] = time();
            $yuyues['status'] = 1;
            $yuyues['book_consume'] = $scrollinfo['book_consume'];
            
            $addyuyue = M('yuyue')->add($yuyues);
            if($addyuyue){
                 //扣除相应金额
                $dec = M('user')->where('userid='.$userid)->setDec('total_lingshi',$kou_nums);
                //添加记录
                $adddata['pay_id'] = $userid;
                $adddata['get_id'] = 0;
                $adddata['get_nums'] = $scrollinfo['book_consume'];
                $adddata['get_type'] = 13;
                $adddata['get_time'] = time();
                $adddata['xing_title'] = $scrollinfo['title'];
                $adddata['now_nums'] = $member['total_lingshi']-$scrollinfo['book_consume'];
                $add = M('tranmoney')->add($adddata);

                // $adddatas['pay_id'] = $userid;
                // $adddatas['get_id'] = 0;
                // $adddatas['get_nums'] = $scrollinfo['feed_consume'];
                // $adddatas['get_type'] = 19;
                // $adddatas['get_time'] = time();
                // $adddatas['now_nums'] = $member['total_lingshi']-$scrollinfo['feed_consume']-$scrollinfo['book_consume'];
                // $adds = M('tranmoney')->add($adddatas);
            }
                   

            $vip_grade = pidisme($userid);
            
            if($addyuyue){
                $this->ajaxReturn(array('Boolean' => true,'text' => '预约成功'));
            }else{
                $this->ajaxReturn(array('Boolean' => false,'text' => '预约失败'));
            }
        }
    }
	//收藏
	public function adpot()
	{
		if(IS_AJAX){
			$userid = session('userid');
			$scroll_id = I('id');
            $scrollinfo = M('scroll')->where(array('id' => $scroll_id))->find();
            
			$user_scroll = M('yuyue')->where(array('scroll_id'=> $scroll_id,'uid'=>$userid,'status'=>1))->getField('id');//是否预约单
            $kou_nums = $scrollinfo['rush_consume']+$scrollinfo['feed_consume'];
            $member = M('user')->where(array('userid'=>$userid))->field('total_lingshi,is_real_name')->find();
            if($member['is_real_name']==0){
                $this->ajaxReturn(array('Boolean' => false,'text' => '请先进行实名验证','code'=>99));
            }

            $end_time = strtotime($scrollinfo['end_time']);
            if(time()>$end_time){
                $this->ajaxReturn(array('Boolean' => false,'text' => '收藏时间结束了'));
            }

            
            //查找订单
            $region_price = explode('-',$scrollinfo['value_region']);
            $qujian1 = $region_price[0];
            $qujian2 = $region_price[1];
            $map['record_price'] = array(array('egt',$qujian1),array('elt',$qujian2));
            $map['record_status'] = 2;
            $map['out_uid'] = array('neq',$userid);
            $nums = M('record')->where($map)->order('generate_time asc')->find();
			if(!empty($user_scroll)){//预约单
                if($nums){
                    if($member['total_lingshi']<$scrollinfo['feed_consume']){
                        $this->ajaxReturn(array('Boolean' => false,'text' => '账户金额不足'));
                    }
                    $data['is_yuyue'] = 1;
                    $data['profit_day'] = $scrollinfo['profit_day'];
                    $data['profit_value'] = $scrollinfo['profit_value'];
                    $data['feed_consume'] = $scrollinfo['feed_consume'];
                    $data['active_num'] = $scrollinfo['feed_consume']+$scrollinfo['rush_consume'];
                    $data['in_uid'] = $userid;
                    $data['scroll_id'] = $scroll_id;
                    $data['record_status'] = 6;
                    $data['pipeitime'] = time();
                    $data['title'] = $scrollinfo['title'];
                    $save = M('record')->where(array('record_id'=>$nums['record_id']))->save($data);

                    $dec = M('user')->where('userid='.$userid)->setDec('total_lingshi',$scrollinfo['feed_consume']);

                    $adddatas['pay_id'] = $userid;
                    $adddatas['get_id'] = 0;
                    $adddatas['get_nums'] = $scrollinfo['feed_consume'];
                    $adddatas['get_type'] = 19;
                    $adddatas['get_time'] = time();
                    $adddatas['now_nums'] = $member['total_lingshi']-$scrollinfo['feed_consume'];
                    $adds = M('tranmoney')->add($adddatas);

                    $updateyup['status'] = 0;
                    $update = M('yuyue')->where(array('id'=>$user_scroll))->save($updateyup);
                }else{
                    $this->ajaxReturn(array('Boolean' => false,'text' => '收藏数额已满'));
                }
                
			}else{
                //是否存在预约单
                $have = M('record')->where(array('in_uid'=>$userid,'scroll_id'=>$scroll_id))->count();
                if($have+1>$scrollinfo['max_size']){
                    $this->ajaxReturn(array('Boolean' => false,'text' => '次数已达上限'));
                }
                if($member['total_lingshi']<$kou_nums){
                    $this->ajaxReturn(array('Boolean' => false,'text' => '账户金额不足'));
                }

                if($nums){
                    $data['profit_day'] = $scrollinfo['profit_day'];
                    $data['profit_value'] = $scrollinfo['profit_value'];
                    $data['feed_consume'] = $scrollinfo['feed_consume'];
                    $data['active_num'] = $scrollinfo['feed_consume']+$scrollinfo['rush_consume'];
                    $data['in_uid'] = $userid;
                    $data['record_status'] = 6;
                    $data['scroll_id'] = $scroll_id;
                    $data['pipeitime'] = time();
                    $data['title'] = $scrollinfo['title'];
                    $save = M('record')->where(array('record_id'=>$nums['record_id']))->save($data);
                    //扣除相应金额
                    
                    $dec = M('user')->where('userid='.$userid)->setDec('total_lingshi',$kou_nums);
                    //添加记录
                    $adddata['pay_id'] = $userid;
                    $adddata['get_id'] = 0;
                    $adddata['get_nums'] = $scrollinfo['rush_consume'];
                    $adddata['get_type'] = 14;
                    $adddata['get_time'] = time();
                    $adddata['now_nums'] = $member['total_lingshi']-$scrollinfo['rush_consume'];
                    $add = M('tranmoney')->add($adddata);

                    $adddatas['pay_id'] = $userid;
                    $adddatas['get_id'] = 0;
                    $adddatas['get_nums'] = $scrollinfo['feed_consume'];
                    $adddatas['get_type'] = 19;
                    $adddatas['get_time'] = time();
                    $adddatas['now_nums'] = $member['total_lingshi']-$scrollinfo['feed_consume']-$scrollinfo['rush_consume'];
                    $adds = M('tranmoney')->add($adddatas);
 
                    $vip_grade = pidisme($userid);

                }else{
                    $this->ajaxReturn(array('Boolean' => false,'text' => '收藏数额已满'));
                }
            }
            if($save){
                $this->ajaxReturn(array('Boolean' => true,'text' => '收藏成功'));
            }else{
                $this->ajaxReturn(array('Boolean' => false,'text' => '收藏失败'));
            }
		}else{
			$this->ajaxReturn(array('Boolean' => false,'text' => '参数错误'));
		}
	}
//收藏记录
public function adoption(){
    $uid = session('userid');
    //收藏中
    $where['in_uid'] = $uid;
    $where['record_status'] = array('in',array('6','7','8'));

    $res1 = M('record')->where($where)->order('pipeitime desc')->select();
    foreach ($res1 as $k => $v) {
        $userinfo = M('user')->where('userid='.$v['out_uid'])->field('username')->find();
        $res1[$k]['profit_value'] = $v['profit_value']*100;
        $res1[$k]['out_username'] = $userinfo['username'];
        $res1[$k]['fukuantime'] = $v['pipeitime']+2*3600;
    }
    //以收藏
    $res2 = M('record')->where(array('in_uid'=>$uid,'record_status'=>4))->order('complete_time desc')->select();
    // var_dump($res2);die();
    foreach ($res2 as $k1 => $v1) {
        $userinfo2 = M('user')->where('userid='.$v1['out_uid'])->field('username')->find();
        $res2[$k1]['profit_value'] = $v1['profit_value']*100;
        $res2[$k1]['out_username'] = $userinfo2['username'];
        $res2[$k1]['dongjirtime'] = $v1['complete_time']+$v1['profit_day']*86400;
    }
    $res3 = M('record')->where(array('in_uid'=>$uid,'record_status'=>9))->order('getmoney_time desc')->select();
    // var_dump($res2);die();
    foreach ($res3 as $k3 => $v3) {
        $userinfo3 = M('user')->where('userid='.$v3['out_uid'])->field('username')->find();
        $res3[$k3]['profit_value'] = $v3['profit_value']*100;
        $res3[$k3]['out_username'] = $userinfo3['username'];
    }
    // var_dump($res2);die();
    $this->assign('list1',$res1);
    $this->assign('list2',$res2);
    $this->assign('list3',$res3);
    $this->display();
}
//转让列表
public function transfer(){
    $uid = session('userid');
    //待转让
    $wheres['out_uid'] = $uid;
    $wheres['record_status'] = array('in',array('1','2'));
    $res1 = M('record')->where($wheres)->order('generate_time desc')->select();
    //收藏中
    $where1['out_uid'] = $uid;
    $where1['record_status'] = array('in',array('6','7','10'));
    $res2 = M('record')->where($where1)->order('pipeitime desc')->select();
    foreach ($res2 as $k => $v) {
        $userinfo = M('user')->where('userid='.$v['in_uid'])->field('username')->find();
        $res2[$k]['profit_value'] = $v['profit_value']*100;
        $res2[$k]['in_username'] = $userinfo['username'];
        $res2[$k]['getmoney_time'] = $v['getmoney_time']+2*3600;
    }
    
    //交易完成
    $res3 = M('record')->where(array('out_uid'=>$uid,'record_status'=>4))->order('complete_time desc')->select();
    foreach ($res3 as $k3 => $v3) {
        $userinfo3 = M('user')->where('userid='.$v3['in_uid'])->field('username')->find();
        $res3[$k3]['profit_value'] = $v3['profit_value']*100;
        $res3[$k3]['in_username'] = $userinfo3['username'];
    }

    $res4 = M('record')->where(array('out_uid'=>$uid,'record_status'=>8))->order('pipeitime desc')->select();
    // var_dump($res4);die();
    foreach ($res4 as $k4 => $v4) {
        $userinfo4 = M('user')->where('userid='.$v4['in_uid'])->field('username')->find();
        $res4[$k4]['profit_value'] = $v4['profit_value']*100;
        $res4[$k4]['in_username'] = $userinfo4['username'];
    }

    $this->assign('list3',$res3);
    $this->assign('list4',$res4);
    $this->assign('list1',$res1);
    $this->assign('list2',$res2);
    $this->display();
}

public function pond(){
    $uid = session('userid');
    $res = M('record')->where(array('in_uid'=>$uid,'record_status'=>4))->select();
    $zongjf = M('record')->where(array('in_uid'=>$uid,'record_status'=>4))->sum('record_price');
    $active_num = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
    $this->assign('zongjf',$zongjf);
    $this->assign('active_num',$active_num);
    $this->assign('list',$res);
    $this->display();
}

//星座预约列表
public function appointment(){
    $uid = session('userid');
    $where = "pay_id={$uid} AND get_type=13";
    $order = "id desc";
    $res = M('tranmoney')->where($where)->order($order)->select();

    $this->assign('res',$res);
    $this->display();
}
/**
 * 升级条件是否符合
 */
public function shengji(){
    $uid = session('userid');
    $pidnums = steamsy($uid,120);//直推数
    var_dump($pidnums);
}
  /*
  * 轮播私有方法链接数据库
  */
private function get_banner()
{
    $user_object   = M('banner');
    $data_list = $user_object->order('sort asc')->select();
    return $data_list;
}


    //每天打卡
    public function clock(){
        $userid = session('userid');
        $user = M('user')->where(array('userid'=>$userid))->field('truename,id_card,total_active')->find();
        if(!$user['truename'] && !$user['id_card']){
            $arr['code'] = 2;
            $arr['msg'] = '请先进行实名认证';
            $arr['url'] = U('User/real_name');
            exit(json_encode($arr));
        }
        $todaytime = strtotime(date('Y-m-d',time()));
        $lasttime = M('user_clock')->where(array('uid'=>$userid))->order('id desc')->getField('lasttime');
        M()->startTrans();
        if($todaytime > $lasttime){
            $diff = $todaytime - $lasttime;
            // if($diff >= 86400 && $lasttime){

            //     $user_step = M('user')->where(array('userid'=>$userid))->getField('add_step');
            //     //添加步数记录
            //     $step_num = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->order('s.step_num desc')->getField('s.step_num');
            //     $add_step = M('user')->where(array('userid'=>$userid))->getField('add_step');
            //     $tm3['pay_id'] = $userid;
            //     $tm3['get_id'] = 0;
            //     $tm3['get_nums'] = $user_step;
            //     $tm3['get_time'] = time();
            //     $tm3['get_type'] = 40;
            //     $tm3['now_nums'] = $step_num+$add_step;
            //     M('tranmoney')->add($tm3);

            //     //断签到步数清零
            //     M('user')->where(array('userid'=>$userid))->setField('add_step',0);
            // }
            $user_scroll = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->field('s.single_num')->order('s.id desc')->find();
            if(!$user_scroll){
                $arr['code'] = 0;
                $arr['msg'] = '购买星座后才能领取收益';
                exit(json_encode($arr));
            }


            // 获取总星座
            $user_scroll = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->field('s.single_num')->select();
            $get_num = 0;
            foreach($user_scroll as $k => $v){
                $get_num += $v['single_num'];
            }
            // dump($get_num);
            // exit;
            //增加步数
            // $step = 5;
            // $res2 = M('user')->where(array('userid'=>$userid))->setInc('add_step',$step);
            // $add_step = M('user')->where(array('userid'=>$userid))->getField('add_step');
            
            //添加步数记录
            // $step_num = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->order('s.step_num desc')->getField('s.step_num');
            // $add_step = M('user')->where(array('userid'=>$userid))->getField('add_step');
            // $tm3['pay_id'] = 0;
            // $tm3['get_id'] = $userid;
            // $tm3['get_nums'] = $step;
            // $tm3['get_time'] = time();
            // $tm3['get_type'] = 39;
            // $tm3['now_nums'] = $step_num+$add_step;
            // M('tranmoney')->add($tm3);

            //获取用户直推活跃度
            // $where['pid'] = $uid;
            // $where['vip_grade'] = array('egt',1);
            // $total_child_active = M('user')->where($where)->sum('total_active');
            // $push_active = $total_child_active * 0.007;
            // $total_active = $user['total_active']; //用户总活跃度
            //计算今天所获得的积分数量
            // $get_num = ($add_step + $user_scroll['step_num']) * $user_scroll['single_num'] * $total_active;

            // 检测用户是否拥有皮肤
            // $total_lingshi_plus = M('user_skin us')->join('ysk_skin s ON us.skin_id=s.id')->where(array('us.uid'=>$userid))->sum('s.lingshi_plus');
            // $add_skin_num = $get_num * ($total_lingshi_plus/100);//皮肤加成
            // $get_num = $get_num + $add_skin_num;
            //添加打卡记录
            $data['uid'] = $userid;
            $data['lasttime'] = time();
            $data['get_num'] = $get_num;
            $res = M('user_clock')->add($data);

            // 为用户添加积分
            M('user')->where(array('userid'=>$userid))->setInc('total_lingshi',$get_num);

            $total_lingshi = M('user')->where(array('userid'=>$userid))->getField('total_lingshi');
            //添加 tranmoney记录
            $tm['pay_id'] = 0;
            $tm['get_id'] = $userid;
            $tm['get_nums'] = $get_num;
            $tm['get_time'] = time();
            $tm['get_type'] = 25;
            $tm['now_nums'] = $total_lingshi;
            M('tranmoney')->add($tm);

            if($res && $res !== false){
                M()->commit(); 
                $arr['code'] = 1;
                $arr['msg'] = '领取成功';
                exit(json_encode($arr));
            }else{
                M()->rollback();
                $arr['code'] = 0;
                $arr['msg'] = '领取失败';
                exit(json_encode($arr));
            }
            
        }else{
            $arr['code'] = 0;
            $arr['msg'] = '已领取，请勿重复';
            exit(json_encode($arr));
        }
    }




    public function Dotrrela()
    {
        if (IS_AJAX) {
            $userid = session('userid');
            //是否存在当日转账释放红包
            $startime = date('Y-m-d');
            $endtime = date("Y-m-d", strtotime("+1 day"));
            $todaystime = strtotime($startime);
            $endtime = strtotime($endtime);
            $whereres['get_id'] = $userid;
            $whereres['is_release'] = 0;
            $whereres['get_type'] = 22;
            $whereres['get_time'] = array('between', array($todaystime, $endtime));
            $is_setnums = M('tranmoney')->where($whereres)->sum('get_nums') + 0;
            if ($is_setnums > 0) {
                $datapay['cangku_num'] = array('exp', 'cangku_num + ' . $is_setnums);
                $datapay['fengmi_num'] = array('exp', 'fengmi_num - ' . $is_setnums);
                $res_pay = M('store')->where(array('uid' => $userid))->save($datapay);//每日银积分释放金积分

                //添加释放记录
                $jifen_nums = $is_setnums;
                $jifen_dochange['pay_id'] = $userid;
                $jifen_dochange['get_id'] = $userid;
                $jifen_dochange['get_nums'] = $jifen_nums;
                $jifen_dochange['get_time'] = time();
                $jifen_dochange['get_type'] = 2;
                $res_addres = M('tranmoney')->add($jifen_dochange);
                //改成已释放
                $savedata['is_release'] = 1;
                $savedata['get_time'] = time();
                $is_setnums = M('tranmoney')->where($whereres)->save($savedata);
                if ($is_setnums) {
                    ajaxReturn('转账银积分释放成功', 1);
                } else {
                    ajaxReturn('转账银积分释放失败', 0);
                }
            }
        }
    }

    //金积分记录
    public function Bancerecord()
    {
        $traInfo = M('tranmoney');
        $uid = session('userid');
        $where['pay_id|get_id'] = $uid;
        $where['get_type'] = array('in','13,14,19,0,20,21,25,26');

        $is_real_name = M('user')->where('userid='.$uid)->getField('is_real_name');
        $this->assign('is_real_name',$is_real_name);
        //分页
        $p = getpage($traInfo, $where, 50);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        // var_dump($Chan_info);die();
        $this->assign('Chan_info', $Chan_info);
        $this->assign('uid', $uid);
        $this->display();
    }

    //星座收益记录
    public function activeRecord()
    {
        $traInfo = M('tranmoney');
        $uid = session('userid');
        $where['get_id|pay_id'] = $uid;
		$where['get_type'] = array('in', '15,16,17,18,22,23,27');

        //是否实名
        $is_real_name = M('user')->where('userid='.$uid)->getField('is_real_name');
        $this->assign('is_real_name',$is_real_name);

        //分页
        $p = getpage($traInfo, $where, 50);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        
        $this->assign('Chan_info', $Chan_info);
        $this->assign('uid', $uid);
        $this->display();
    }

    //推广收益记录
    public function extension()
    {
       $traInfo = M('tranmoney');
        $uid = session('userid');
        $where['get_id|pay_id'] = $uid;
        $where['get_type'] = array('in', '16,18,17,24');

        //是否实名
        $is_real_name = M('user')->where('userid='.$uid)->getField('is_real_name');
        $this->assign('is_real_name',$is_real_name);

        //分页
        $p = getpage($traInfo, $where, 50);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        
        $this->assign('Chan_info', $Chan_info);
        $this->assign('uid', $uid);
        $this->display();
    } 
	
	public function trans()
	{
		if(IS_POST){
			$userid = session('userid');
			$type = I('type');//3:待转让 0:转让中 1:已完成 2:取消/申诉
			// $this->ajaxReturn(array('type' => $type));
			if($type == 3){
				$record_status = 5;
			}else if($type == 0){
				$record_status = array('in', '6,7');
			}else if($type == 3){
				$record_status = 4;
			}else if($type == 2){ 
			 	$record_status = 8;
			}
			$limit = I('limit');//条数
			$page = I('page');
			$where['out_uid'] = $userid;
			$where['record_form'] = 5;
			$where['record_type'] = array('in', '2,3');
			$where['record_status'] = $record_status;
			$info = M('record')->where($where)->order('generate_time desc')->select();
			//判断是什么熊
			$scroll = M('scroll')->select();
			foreach($scroll as $sk => $sv){
				$value_region = explode('-',$sv['value_region']);
				foreach($info as $ik => $iv){
					if($iv['record_price'] >= $value_region[0] && $iv['record_price'] <= $value_region[1]){
						$info[$ik]['scroll'] = $scroll[$sk];
					}
				}
			}
			$this->ajaxReturn(array('info' => $info,'code' => 0));
		}
	}


    // 星座购买
    public function scroll_exchange(){
        $id = (int)I('id');
        $pwd = I('pwd');
        $userid = session('userid');
        
        $user = M('user')->where(array('userid'=>$userid))->field('is_real_name,is_pay,total_lingshi')->find();
        if($user['is_real_name'] == 0 || $user['is_pay'] ==0){
            $arr['code'] = 0;
            $arr['msg'] = "请先进行实名验证";
            $arr['url'] = U('User/real_name');
            exit(json_encode($arr));
        }
        $is_exis = M('scroll')->where(array('id'=>$id,'status'=>1))->count();
        if(!$is_exis){
            $arr['code'] = 0;
            $arr['msg'] = "你所选择的星座不存在，请刷新重试";
            exit(json_encode($arr));
        }

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $userid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);
        // $repeat_exis = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id = s.id')->where(array('us.uid'=>$userid,'us.status'=>1,'us.overtime'=>array('gt',time())))->field('us.id,s.active')->select();
        // $count = count($repeat_exis);
        // if($count > 0){
        //     foreach($repeat_exis as $v){
        //         M('user_scroll')->where(array('id'=>$v['id']))->setField('status',0);
        //         M('user')->where(array('userid'=>$userid))->setDec('total_active',$v['active']);
        //     }
        // }

        $scroll = M('scroll')->where(array('id'=>$id,'status'=>1))->find();
        if($user['total_lingshi'] < $scroll['sell_num']){
            $arr['code'] = 0;
            $arr['msg'] = "您的积分不足，请先获取积分进行购买";
            exit(json_encode($arr));
        }
        // 检测用户拥有星座的最大数
        $user_scroll_count = M('user_scroll')->where(array('uid'=>$userid,'scroll_id'=>$id))->count();
        if($user_scroll_count >= $scroll['max_size']){
            $arr['code'] = 0;
            $arr['msg'] = $scroll['title'].'以拥有最大数量';
            exit(json_encode($arr));
        }
        M()->startTrans();
        $user_data['total_lingshi'] = array('exp','total_lingshi - '.$scroll['sell_num']);
        $user_data['total_active'] = array('exp','total_active + '.$scroll['active']);
        $res = M('user')->where(array('userid'=>$userid))->save($user_data);

        //添加记录
        //积分
        $total_lingshi = M('user')->where(array('userid'=>$userid))->getField('total_lingshi');
        $tm['pay_id'] = $userid;
        $tm['get_id'] = 0;
        $tm['get_nums'] = $scroll['sell_num'];
        $tm['get_time'] = time();
        $tm['get_type'] = 26;
        $tm['now_nums'] = $total_lingshi;
        M('tranmoney')->add($tm);
        //活跃度
        $total_active = M('user')->where(array('userid'=>$userid))->getField('total_active');
        $tm2['pay_id'] = 0;
        $tm2['get_id'] = $userid;
        $tm2['get_nums'] = $scroll['active'];
        $tm2['get_time'] = time();
        $tm2['get_type'] = 30;
        $tm2['now_nums'] = $total_active;
        M('tranmoney')->add($tm2);

        //上级添加直推活跃度
        // $pid = M('user')->where(array('userid'=>$userid))->getField('pid');
        // $p_active = $scroll['active'] *0.07;
        // M('user')->where(array('userid'=>$pid))->setInc('total_active',$p_active);

        // $total_active = M('user')->where(array('userid'=>$pid))->getField('total_active');
        // $tm['pay_id'] = 0;
        // $tm['get_id'] = $pid;
        // $tm['get_nums'] = $p_active;
        // $tm['get_time'] = time();
        // $tm['get_type'] = 47;
        // $tm['now_nums'] = $total_active;
        // M('tranmoney')->add($tm);

        //添加步数记录
        // $step_num = M('user_scroll us')->join('ysk_scroll s ON us.scroll_id=s.id')->where(array('us.uid'=>$userid,'us.status'=>1))->order('s.step_num desc')->getField('s.step_num');
        // $add_step = M('user')->where(array('userid'=>$userid))->getField('add_step');
        // $tm3['pay_id'] = 0;
        // $tm3['get_id'] = $userid;
        // $tm3['get_nums'] = $scroll['step_num'];
        // $tm3['get_time'] = time();
        // $tm3['get_type'] = 38;
        // $tm3['now_nums'] = $step_num+$add_step;
        // M('tranmoney')->add($tm3);


        $users_data['uid'] = $userid;
        $users_data['scroll_id'] = $scroll['id'];
        $users_data['overtime'] = time() + 86400 * $scroll['max_day'];
        $users_data['status'] = 1;
        $res2 = M('user_scroll')->add($users_data);

        if($res !== false && $res2){
            M()->commit();
            $arr['code'] = 1;
            $arr['msg'] = '购买'.$scroll['title'].'成功';
            $arr['url'] = U('Index/index');
        }else{
            M()->rollback();
            $arr['code'] = 0;
            $arr['msg'] = "购买".$scroll['title']."失败";
        }
        exit(json_encode($arr));

    }



    //皮肤购买
    public function skin_exchange(){
        $id = (int)I('id');
        $pwd = trim(I('pwd'));
        $userid = session('userid');
        
        $user = M('user')->where(array('userid'=>$userid))->field('truename,id_card,total_lingshi')->find();
        if(!$user['truename'] && !$user['id_card']){
            $arr['code'] = 0;
            $arr['msg'] = "请先进行实名验证";
            $arr['url'] = U('User/real_name');
            exit(json_encode($arr));
        }
        $is_exis = M('skin')->where(array('id'=>$id,'code'=>1))->count();
        if(!$is_exis){
            $arr['code'] = 0;
            $arr['msg'] = "你所选择的皮肤不存在，请刷新重试";
            exit(json_encode($arr));
        }

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $userid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        $is_user_skin = M('user_skin us')->where(array('uid'=>$userid,'skin_id'=>$id))->count();
        if($is_user_skin){
            $arr['code'] = 0;
            $arr['msg'] = '你已购买该皮肤，无法重复购买';
            exit(json_encode($arr));
        } 

        $skin = M('skin')->where(array('id'=>$id,'status'=>1))->field('sell_num')->find();
        if($user['total_lingshi'] < $skin['sell_num']){
            $arr['code'] = 0;
            $arr['msg'] = "您的积分不足，请先获取积分进行购买";
            exit(json_encode($arr));
        }

        M('user')->where(array('userid'=>$userid))->setDec('total_lingshi',$skin['sell_num']);

        //添加记录
        $total_lingshi = M('user')->where(array('userid'=>$userid))->getField('total_lingshi');
        $tm['pay_id'] = $userid;
        $tm['get_id'] = 0;
        $tm['get_nums'] = $skin['sell_num'];
        $tm['get_time'] = time();
        $tm['get_type'] = 27;
        $tm['now_nums'] = $total_lingshi;
        M('tranmoney')->add($tm);

        $data['uid'] = $userid;
        $data['skin_id'] = $id;
        $res = M('user_skin')->add($data);
        if($res){
            $arr['code'] = 1;
            $arr['msg'] = '购买皮肤成功';
            $arr['url'] = U('Index/skin');
        }else{
            $arr['code'] = 0;
            $arr['msg'] = '购买皮肤失败';
        }
        exit(json_encode($arr));
    }

    //转出
    public function Turnout()
    {
        if (IS_AJAX) {
            $uinfo = trim(I('uinfo'));
            //手机号码或者用户id
            $map['userid|mobile'] = $uinfo;

        //    dump($map);die;
            $issetU = M('user')->where($map)->field('userid,username')->find();
            $userid = session('userid');

            if ($userid == $issetU['userid']) {
                ajaxReturn('您不能给自己转账哦~', 0);
            }
            if ($issetU) {
                $url = '/Index/Changeout/sid/' . $issetU['userid'];
                ajaxReturn($url, 1);
            } else {
                ajaxReturn('并不存在该用户哦~', 0);
            }
        }
        $this->display();
    }


    public function Changeout()
    {
        $sid = trim(I('sid'));
        $uinfo = M('user as us')->JOIN('ysk_store as ms')->where(array('us.userid' => $sid))->field('us.mobile,us.userid,us.img_head,us.username,ms.cangku_num')->find();
        if (IS_AJAX) {
            $data = $_POST['post_data'];
            $trid = trim($data['zuid']);
            $paytype = trim($data['paytype']);
            $paynums = $data['paynums'];
            $mobila = trim($data['mobila']);
            $pwd = trim(I('pwd'));
            $uid = session('userid');
            
            $is_real_name = M('user')->where('userid='.$uid)->getField('is_real_name');
            if($is_real_name==0){
                ajaxReturn('请先进行实名验证',0);
            }

            $info2=$paynums%1;

            if($paynums<1){
                ajaxReturn('不得小于1',0);
            }

            if($info2){
                ajaxReturn('请输入1的倍数',0);
            }
			
            //验证交易密码
            $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
            $user_object = D('Home/User');
            $user_info = $user_object->Trans($minepwd['account'], $pwd);
            //验证手机号码后四位
            $is_setm['userid|mobile'] = $trid;
            $tmobile = M('user')->where($is_setm)->getfield('mobile');
            $tmobile = substr($tmobile, -4);
            $toinfo = M('user')->where($is_setm)->field('total_lingshi')->find();
            if ($tmobile != $mobila) {
                ajaxReturn('您输入的手机号码后四位有误', 0);
            }
            if ($paynums <= 0) {
                ajaxReturn('您输入的转账金额有误哦~', 0);
            }
            if ($uid == $trid) {
                ajaxReturn('您不能给自己转账哦~', 0);
            }
            $mine_money = M('user')->where(array('userid' => $uid))->getfield('total_lingshi');
            if ($mine_money < $paynums) {
                ajaxReturn('您的积分暂无这么多哦~', 0);
            }
			$mine_money2 = M('user')->where(array('userid' => $trid))->getfield('total_lingshi');

			$datas['pay_id'] = $uid;
            $datas['get_nums'] = $paynums;
			$datas['get_time'] = time();
            $datas['get_type'] = 0;
            $datas['now_nums'] = $mine_money-$paynums;

            $add_Dets = M('tranmoney')->add($datas);

            $datass['get_id'] = $trid;
            $datass['get_nums'] = $paynums;
            $datass['get_time'] = time();
            $datass['get_type'] = 20;
            $datass['now_nums'] = $toinfo['total_lingshi'] + $paynums;

            $add_Detss = M('tranmoney')->add($datass);
            if ($add_Dets) {
				M('user')->where(array('userid'=>$uid))->setDec('total_lingshi',$paynums);
				M('user')->where(array('userid'=>$trid))->setInc('total_lingshi',$paynums);
                ajaxReturn('转账成功哦~', 1, '/Index/index');
            }
        }
        $this->assign('uinfo', $uinfo);
        $this->display();
    }

    //金积分转银积分

    public function test()
    {
          $userid = session('userid');

       

    }

    // 更新升级人数
    public function add_unums(){
        $add = I('add');
        $update_time = time();
        $res = M('config')->where(array('name'=>'add_user'))->setInc('value',$add);
        $res3 = M('config')->where(array('name'=>'add_user'))->setField('update_time',$update_time);
        $res2 = M('config')->where(array('name'=>'false_user'))->setInc('value',$add);
        if( $res && $res2){
            ajaxReturn('YES',0);
        }
    }



 public function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
    return $substr;

}


    //管理奖和直推奖， 管理拿2-4代
    private function Manage_reward($uid,$paynums){

    $Lasts = D('Home/index');
    $Lastinfo = $Lasts->Getlasts($uid, 15, 'path');  
    
    if (count($Lastinfo) > 0) {

        $Manage_b = M('config')->where(array('group' => 6, 'status' => 1))->order('id asc')->select();//分享奖比例
        $Manage_a = M('config')->where(array('group' => 7, 'status' => 1))->order('id asc')->select();//管理奖比例
   
        foreach ($Lastinfo as $k => $v) {
  
            if (!empty($v)) {//当前会员信息
              

                    if($k==0) {//第一代，即为直推奖 

                        $u_Grade = M('user')->where(array('userid' => $v))->getfield('use_grade');
                        $direct_fee=0;
                        if($u_Grade>0)$direct_fee=(float)$Manage_b[$u_Grade-1]["value"];//判断是什么比例

                        $zhitui_reward = $direct_fee / 100 * $paynums;//直推的人所得分享奖
                        M('user')->where(array('userid' => $v))->setInc('releas_rate', $zhitui_reward);
                    }

                    if ($k>0&&$k<=3) {//2-4代,拿直推的人的分享奖*相应比例，即为管理奖
                         $t=$k-1; 
                         $zhitui_num = M('user')->where(array('pid' => $v))->count(1);//计算直推人数
                         $suoxu_num=(int)$Manage_a[$t]["tip"];
                        
                        if($zhitui_num>=$suoxu_num){//直推人数满足条件

                            $My_reward=$Manage_a[$t]["value"]/100*$zhitui_reward;                    
                            $res_Incrate = M('user')->where(array('userid' => $v))->setInc('releas_rate', $My_reward);
                               
                        }
                    }                  
                   
                
            }//if
        }//foreach

    }
  }

    //区块奖和VIP奖   区块拿15层
    private function Addreas15($uid,$paynums){

    $Lasts = D('Home/index');
    $Lastinfo = $Lasts->Getlasts($uid, 15, 'path');
    if (count($Lastinfo) > 0) {
        $add_relinfo = M('config')->where(array('group' => 9, 'status' => 1))->order('id asc')->select();
        $vips = M('config')->where(array('group' => 10, 'status' => 1))->order('id asc')->select();
        $i = 0;
        $n = 0;
        foreach ($Lastinfo as $k => $v) {
            //查询当前自己等级
            if (!empty($v)) {

                    $zhitui_num = M('user')->where(array('pid' => $v))->count(1);//计算直推人数
                    $t=$k+1;
                    $tkey =0;
                    $daishu=array(3,6,9,12,15);
                    foreach ($daishu as $key1 => $value1) {
                     if($t>$value1)$tkey=$key1+1;
                    }
                    
                    
                    $v_Grade = M('user')->where(array('userid' => $v))->getfield('vip_grade');

                    $suoxu_num=(int)$add_relinfo[$tkey]["tip"];
                    if($add_relinfo['options'] >= 1 && $add_relinfo['options'] == $v_Grade && $zhitui_num>=$suoxu_num){//普通会员直推人数满足条件 得区块奖

                        $Lastone = $My_reward=$add_relinfo[$tkey]["value"]/100*$paynums; 
                        $res_Incrate = M('user')->where(array('userid' => $v))->setInc('releas_rate', $Lastone);

                                
                    }






                    //VIP奖，有集差，加速释放
                    if( $add_relinfo['options'] >= 2 && $u_Grade == $add_relinfo['options'] && $zhitui_num >= $suoxu_num){ //蓝钻会员奖
                        
                        $u_get_money = $vips[0]['value'] / 100 * $paynums;
                        $res_Add = M('user')->where(array('userid'=>$v))->setInc('release_rate' , $u_get_money);

                    }elseif( $add_relinfo['options'] == 3 && $u_Grade == $add_relinfo['options'] && $zhitui_num >= $suoxu_num){ //金钻会员奖
                        
                        $u_get_money = $vips[1]['value'] / 100 * $paynums;
                        $res_Add = M('user')->where(array('userid'=>$v))->setInc('release_rate' , $u_get_money);
                    
                    }elseif( $add_relinfo['options'] == 4 && $u_Grade == $add_relinfo['options'] && $zhitui_num >= $suoxu_num){
                        $u_get_money = $vips[2]['value'] / 100 * $paynums;
                        $res_Add = M('user')->where(array('userid'=>$v))->setInc('release_rate' , $u_get_money);
                    }
                    
                    // if(($v_Grade == 1 && $i == 0)||($v_Grade == 2 && $i == 0)){//VIP1奖

                    //         $u_get_money = $vips[0]['value'] / 100 * $paynums;
                    //         $res_Add = M('user')->where(array('userid' => $v))->setInc('releas_rate', $u_get_money);
                    //         $i++;
                            
                            
                    // }elseif($v_Grade==2 && $i!=0 &&$n==0){//VIP2奖
                    //      $u_get_money = $vips[1]['value'] / 100 * $paynums;
                    //      $res_Add = M('user')->where(array('userid' => $v))->setInc('releas_rate', $u_get_money);
                    //      $n++;

                    // }



               
            }//if
        }//foreach

     }
}



    //金积分转动奖  拿15层
    public function zhuand15($uid,$paynums)
    {
            $Lasts = D('Home/index');
            $Lastinfo = $Lasts->Getlasts($uid, 8, 'path');  
            if (count($Lastinfo) > 0) {
                    
                    $Manage_b = M('config')->where(array('group' => 8, 'status' => 1))->order('id asc')->select();//金积分转动奖比例   
                    foreach ($Lastinfo as $k => $v) {
              
                        if (!empty($v)) {//当前会员信息

                            $u_Grade = M('user')->where(array('userid' => $v))->getfield('use_grade');
                            $direct_fee=0;
                            if($u_Grade>0)$direct_fee=(float)$Manage_b[$u_Grade-1]["value"];//判断是什么比例

                            $zhuand_reward = $direct_fee / 100 * $paynums;//我得到转动奖的加速
                            M('user')->where(array('userid' => $v))->setInc('releas_rate', $zhuand_reward);
                        }
                    }

            }


    }


    public function Turncords()
    {
        $traInfo = M('tranmoney');
        $uid = session('userid');
        $where['pay_id'] = $uid;
        $where['get_type'] = 0;
        //分页
        $p = getpage($traInfo, $where, 20);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        foreach ($Chan_info as $k => $v) {
            $getinfos = M('user')->where(array('userid' => $v['get_id']))->Field('img_head,username')->find();
            $Chan_info[$k]['imghead'] = $getinfos['img_head'];
            $Chan_info[$k]['guname'] = $getinfos['username'];

        }
        if (IS_AJAX) {
            if (count($Chan_info) >= 1) {
                ajaxReturn($Chan_info, 1);
            } else {
                ajaxReturn('暂无记录', 0);
            }
        }
        $this->assign('page', $page);
        $this->assign('Chan_info', $Chan_info);
        $this->assign('uid', $uid);

        $this->display();
    }


    //根据关系进行分销
    public function Doprofit($uid, $paynums, $type)
    {
        $Lasts = D('Home/index');
        $Lastinfo = $Lasts->Getlasts($uid, 15, 'path');
        //数量的多少
        if($type == 1){
            $paynums = $paynums * 20/100;
        }else{
            $paynums = $paynums;

        }
        if (count($Lastinfo) > 0) {
            $this->Addreas($uid,$Lastinfo,$paynums,$type);//加速银积分释放
        }
    }

    //加速银积分释放【银积分基础释放， 1代银积分加速释放，2-15代，2代vip ，2-15代vip银积分】
    private function Addreas($uid,$Lastinfo,$paynums,$type){
        //银积分加速释放率
        $add_relinfo = M('config')->where(array('group' => 4, 'status' => 1))->order('id asc')->select();
        $i = 0;
        foreach ($Lastinfo as $k => $v) {
            $k = $k + 1;
            //查询当前自己等级
            if (!empty($v)) {
                //当前会员信息 等级字段
                $u_Grade = M('user')->where(array('userid' => $v))->getfield('use_grade');

                if ($u_Grade >= 1) {
                    if ($k == 1) {
                        $release_bili = $add_relinfo[1]['value'];
                    } else {
                        $release_bili = $add_relinfo[2]['value'];
                    }
                    $Lastone = $release_bili / 100 * $paynums;
                    //加速银积分释放
                    $res_Incrate = M('user')->where(array('userid' => $v))->setInc('releas_rate', $Lastone);

                    //增加银积分
                        $u_get_money = $add_relinfo[3]['value'] / 100 * $paynums;
                        if($u_Grade == 3 && $i == 0){
                            $res_Add = M('store')->where(array('uid' => $v))->setInc('fengmi_num', $u_get_money);//给上级会员加银积分
                            if ($res_Add) {
                                $earns['pay_id'] = $uid;
                                $earns['get_id'] = $v;
                                $earns['get_nums'] = $u_get_money;
                                $earns['get_level'] = $k;
                                $earns['get_types'] = $type;
                                $earns['get_time'] = time();
                                $res_Earn = M('moneyils')->add($earns);

                                // $jifendets['pay_id'] = $uid;
                                // $jifendets['get_id'] = $v;
                                // $jifendets['get_nums'] = $u_get_money;
                                // $jifendets['get_time'] = time();
                                // $jifendets['get_type'] = 1;
                                // M('tranmoney')->add($jifendets);
                                $i++;
                            }
                    }
                }
            }//if
        }//foreach
    }


    //转出记录
    public function Outrecords()
    {
        $traInfo = M('tranmoney');
        $uid = session('userid');
        $where['pay_id|get_id'] = $uid;
        $where['get_type'] = 0;
        //分页
        $p = getpage($traInfo, $where, 50);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        foreach ($Chan_info as $k => $v) {
            $Chan_info[$k]['get_timeymd'] = date('Y-m-d', $v['get_time']);
            $Chan_info[$k]['get_timedate'] = date('H:i:s', $v['get_time']);
            //转入转出
            if ($uid == $v['pay_id']) {
                $Chan_info[$k]['trtype'] = 1;
            } else {
                $Chan_info[$k]['trtype'] = 2;
            }
        }
        if (IS_AJAX) {
            if (count($Chan_info) >= 1) {
                ajaxReturn($Chan_info, 1);
            } else {
                ajaxReturn('暂无记录', 0);
            }
        }
        $this->assign('page', $page);
        $this->assign('Chan_info', $Chan_info);
        $this->assign('uid', $uid);
        $this->display();
    }

   


//兑换银积分
    public function Exehange()
    {
        $uid = session('userid');
        $minems = M('store')->where(array('uid' => $uid))->find();
        $minmoney = $minems['cangku_num'] * 0.01;
        $where = 'pay_id = '.$uid.' AND get_id = '.$uid;
        $count = M('tranmoney')->where($where)->count(1);
        if (IS_AJAX) {
            $dhnums = I('dhnums');
            $pwd = I('pwd');
            if ($dhnums < $minmoney) {
                $this->ajaxReturn('最少兑换数量为'.$minmoney.'哦~', 0);
            }
            if ($dhnums % 2 != 0) {
                $this->ajaxReturn('兑换数量必须为2的倍数哦~', 0);
            }
            if ($dhnums > $minems['cangku_num']) {
                $this->ajaxReturn('您账户暂时没有这么多金积分', 0);
            }
            //验证交易密码
            $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
            $user_object = D('Home/User');
            $user_info = $user_object->Trans($minepwd['account'], $pwd);

            // $where = 'pay_id = '.$uid.' AND get_id = '.$uid;
            // $count = M('tranmoney')->where($where)->count(1);
            // ajaxReturn()
            if($count == 0){
                $canget = $dhnums * 5;
            }else{
                $canget = $dhnums * 6;
            }

            $dataget['cangku_num'] = array('exp', "cangku_num - $dhnums");
            $dataget['fengmi_num'] = array('exp', 'fengmi_num + ' . $canget);
            $res_get = M('store')->where(array('uid' => $uid))->save($dataget);//金积分转入银积分
            //查找当前账户金积分
            $is_yue = M('store')->where(array('uid' => $uid))->getField('cangku_num');
            //执行兑换
           //执行兑换
            if ($res_get) {
                $datac['pay_id'] = $uid;
                $datac['get_id'] = $uid;
                $datac['now_nums'] = $is_yue;
                $datac['now_nums_get'] = $is_yue;
                $datac['is_release'] = 1;                
                $datac['get_nums'] = $dhnums;
                $datac['get_time'] = time();
                $datac['get_type'] = 13;

                $pay_n = M('store')->where(array('uid' => $uid))->getfield('fengmi_num');
                $data['pay_id'] = $uid;
                $data['get_id'] = $uid;
                $data['now_nums'] = $pay_n;
                $data['now_nums_get'] = $pay_n;
                $data['is_release'] = 1;                
                $data['get_nums'] = $canget;
                $data['get_time'] = time();
                $data['get_type'] = 1;
            }

            $add_Detsc = M('tranmoney')->add($datac);

            $add_Dets = M('tranmoney')->add($data);

            if ($add_Dets) {
               
               
               $this->Manage_reward($uid,$dhnums); //产生管理奖和分享奖
               $this->Addreas15($uid,$dhnums);//产生区块奖和VIP奖
             
            
                //判断用户等级
                // $uChanlev = D('Home/index');
                // $uChanlev->Checklevel($uid);
                ajaxReturn('金积分兑换银积分成功', 1, '/Index/exehange');
            }
        }
        $this->assign('count',(int)$count);
        $this->assign('minmoney',$minmoney);
        $this->assign('minems', $minems);
        $this->display();
    }
  
    //银积分记录
    public function Exchangerecords()
    {
        $uid = session('userid');
        $where['get_id|pay_id'] = $uid;
        $where['get_type'] = array('in', '1,23,24');
        // $where['get_type'] = 1;
        $traInfo = M('tranmoney');
        //分页
        $p = getpage($traInfo, $where, 50);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        foreach ($Chan_info as $k => $v) {
            $Chan_info[$k]['get_nums'] = $v['get_nums'];
            $Chan_info[$k]['get_timeymd'] = date('Y-m-d', $v['get_time']);
            $Chan_info[$k]['get_timedate'] = date('H:i:s', $v['get_time']);
            if ($uid == $v['pay_id']) {
                $Chan_info[$k]['trtype'] = 1;
            } else {
                $Chan_info[$k]['trtype'] = 2;
            }
        }
        if (IS_AJAX) {
            if (count($Chan_info) >= 1) {
                ajaxReturn($Chan_info, 1);
            } else {
                ajaxReturn('暂无记录', 0);
            }
        }
        $this->assign('uid', $uid);
        $this->assign('Chan_info', $Chan_info);
        $this->assign('page', $page);
        $this->display();
    }


    //获取仓库数据
    public function StoreData()
    {
        if (!IS_AJAX) {
            return false;
        }
        $store = D('Store');
        $userid = get_userid();
        $where['uid'] = $userid;
        $s_info = $store->field('cangku_num,fengmi_num,plant_num,huafei_total')->where($where)->find();

        $data['cangku'] = $s_info['cangku_num'] + 0;
        // $data['fengmi']=$s_info['fengmi_num']+0;
        $data['plant'] = $s_info['plant_num'] + 0;
        // $data['huafei_total']=$s_info['huafei_total']+0;
        // $data['total']=$s_info['cangku_num']+$s_info['plant_num'];
        $this->ajaxReturn($data);
    }

    //果树数据
    public function landdata()
    {
        if (!IS_AJAX) {
            return false;
        }
        $table = M('nzusfarm');
        $uid = session('userid');
        $where['uid'] = $uid;
        $where['status'] = array('gt', 0);
        $info = $table->field('id,seeds+fruits as num,farm_type type,status')->where($where)->order('id')->select();
        if ($info) {
            $this->ajaxReturn($info);
        }

    }


    public function tooldata()
    {
        if (!IS_AJAX) {
            return false;
        }

        $tree = M('config')->where(array('id' => array('in', array(8, 10, 12, 36))))->order('id asc')->field('value as price,id')->select();
        $tool = M('tool')->field('t_num as price,id')->order('id asc')->select();
        $data = array_merge($tree, $tool);
        if (empty($data)) {
            ajaxReturn('数据加载失败');
        } else {
            ajaxReturn('数据加载成功', 1, '', $data);
        }
    }

    //一键采蜜和狗粮
    public function onefooddata()
    {
        if (!IS_AJAX) {
            return false;
        }

        $where['uid'] = session('userid');
        $data = M('user_tool_month')->field('oneclick one,end_oneclick_time endo,dogfood food,end_dogfood_time endf')->where($where)->find();

        if (empty($data)) {
            ajaxReturn(null);
        } else {
            $time = time();
            if ($data['one'] > 0) {
                if ($time > $data['endo'])
                    $data['one_status'] = '已过期';
                else
                    $data['one_status'] = '使用中';

                $data['endo1'] = date('Y-m-d', $data['endo']);
            }
            if ($data['food'] > 0) {
                if ($time > $data['endf'])
                    $data['food_status'] = '已过期';
                else
                    $data['food_status'] = '使用中';

                $data['endf1'] = date('Y-m-d', $data['endf']);
            }
            ajaxReturn('数据加载成功', 1, '', $data);
        }
    }

    /**
     * 站内信
     */
    public function znx()
    {
        if (IS_AJAX) {
            $db_letter = M('nzletter');
            $userid = session('userid');

            $userInfo = session('user_login');

            $data['recipient_id'] = 0;
            $data['send_id'] = $userid;
            $data['title'] = trim(I('post.title'));
            $data['content'] = trim(I('post.content'));
            $data['username'] = $userInfo['username'];
            $data['account'] = $userInfo['account'];

            if (empty($data['title']) || empty($data['content'])) {
                ajaxReturn('标题或内容不能为空');
                return;
            }

            $data['time'] = time();
            $res = $db_letter->data($data)->add();
            if ($res) {
                ajaxReturn('我们已收到，会尽快处理您的问题', 1);
            } else {
                ajaxReturn('提交失败');
            }
        }

    }


    //购买道具
    public function buytool()
    {
        if (!IS_AJAX) {
            return false;
        }

        $id = I('post.id', 0, 'intval');
        $num = I('post.num', 1, 'intval');
        $typetree = I('post.type');
        if (empty($id)) {
            ajaxReturn('参数错误');
        }

        $uid = session('userid');
        if ($typetree == 'tree') {

            if ($id == 8 || $id == 36) {
                $type = 1;
            } elseif ($id == 10) {
                $type = 2;
            } elseif ($id == 12) {
                $type = 3;
            } else {
                ajaxReturn("操作失败");
            }
            //农田里最低的果子数
            $config = D('config');
            $min_guozi = $config->where(array('id' => $id))->getField('value');

            $des_num = $min_guozi;
            $is_land = no_land();
            if ($is_land && $id != 36) {
                $des_num = $des_num + 30;
            }

            $t_info['t_num'] = $des_num;
            $t_info['t_name'] = '树';
            $t_info['t_img'] = '';
            $num = 1;
            $order_type = 1; //树
        } else {

            $t_info = M('tool')->find($id);
            if (empty($t_info)) {
                ajaxReturn('参数错误');
            }

            //判断是否已拥有此道具，如果已拥有，不在购买
            $type = $t_info['t_type'];
            if ($type == 2) {
                $field = $t_info['t_fieldname'];
                $isbuytool = M('user_level')->where(array('uid' => $uid))->getField($field);
                if ($isbuytool > 0) {
                    ajaxReturn('您已经拥有该宠物了哦！');
                }
            }
            $order_type = 0; //道具
        }


        $data['tool_id'] = $id;
        $data['tool_name'] = $t_info['t_name'];
        $data['tool_price'] = $t_info['t_num'];
        $data['tool_img'] = $t_info['t_img'];
        $data['order_status'] = 0;
        $data['order_no'] = date('YmdHis');
        $data['tool_num'] = $num;
        $data['total_price'] = $num * $t_info['t_num'];
        $data['uid'] = $uid;
        $data['order_type'] = $order_type;


        $order = M('order');
        $order->startTrans();
        $res = $order->add($data);
        if ($res) {
            $url = U('Index/orderdetail', array('order_no' => $data['order_no']));
            ajaxReturn('购买成功', 1, $url);
        } else {
            ajaxReturn('购买失败');
            $order->startTrans();
        }
    }


    //选择支付
    public function orderdetail()
    {
        $order_no = I('order_no');
        $order_no = safe_replace($order_no);
        if (empty($order_no)) {
            return false;
        }
        $where['order_no'] = $order_no;
        $where['order_status'] = 0;
        $order = M('order');
        $o_info = $order->where($where)->find();
        if (empty($o_info)) {
            return false;
        }
        $uid = session('userid');
        $cangku_num = M('store')->where(array('uid' => $uid))->getField('cangku_num');
        $this->assign('o_info', $o_info)->assign('cangku_num', $cangku_num)->display();

    }

    public function heavenlyscript(){
        $uid = session('userid');
        
        $this->display();
    }

    public function skin(){
        $userid = session('userid');
        $user_skin = M('user_skin us')->join('ysk_skin k ON us.skin_id=k.id')->where(array('us.uid'=>$userid))->field('k.*')->select();
        $list = M('skin')->where(array('status'=>1))->select();
        $this->assign('user_skin',$user_skin);
        $this->assign('list',$list);
        $this->display();
    }



    public function gopay()
    {
        if (!IS_POST) {
            return false;
        }

        $order_paytype = I('post.paytype');
        $type_arr = array(1, 2, 3);
        if (!in_array($order_paytype, $type_arr)) {
            ajaxReturn('请选择支付方式');
        }
        $order_no = I('post.order_no');
        $order_no = safe_replace($order_no);
        if (empty($order_no)) {
            ajaxReturn('订单不存在');
        }
        $where['order_no'] = $order_no;
        $where['order_status'] = 0;
        $order = M('order');
        $count = $order->where($where)->count(1);
        if ($count == 0) {
            ajaxReturn('该订单已失效，请重新下单');
        }

        $arr = array(1 => '微信支付', 2 => '支付宝支付', 3 => '果子支付');
        $res = $order->where($where)->setField('order_paytype', $arr[$order_paytype]);
        $wxurl = 'http://yxgsgy.com/wxPay/example/jsapi.php?order_no=' . $order_no;
        $arr_url = array(1 => $wxurl, 2 => '', 3 => U('Ajaxdz/kaiken'));
        if ($res === false) {
            ajaxReturn('下单失败');
        } else {
            ajaxReturn('', 1, $arr_url[$order_paytype]);
        }
    }

    public function DogEat()
    {

        $uid = session('userid');

        $eat = M('user_dogeat');
        $pcount = $eat->where(array('uid' => $uid, 'datestr' => date('Ymd')))->count(1);
        if ($pcount > 0) {
            ajaxReturn('今天已经喂食过了哦');
        }

        $where['uid'] = $uid;
        $dog = M('user_level')->where($where)->getField('zangao_num');
        if ($dog) {
            //判断是否过期
            $table = M('user_tool_month');
            $where['dogfood'] = array('gt', 0);
            $info = $table->where($where)->field('dogfood,end_dogfood_time')->find();
            if (empty($info)) {
                ajaxReturn('您还没狗粮哦，赶紧去购买吧');
            }
            $time = time();
            if ($info['end_dogfood_time'] < $time) {
                ajaxReturn('狗粮没有了，赶紧去购买吧');
            }

            $eat = M('user_dogeat');
            $count = $eat->where(array('uid' => $uid))->count(1);
            $data['uid'] = $uid;
            if ($count == 0) {
                $eat->add($data);
            }
            $data['datestr'] = date('Ymd');
            $data['create_time'] = time();
            $res = $eat->where(array('uid' => $uid))->save($data);
            if ($res)
                ajaxReturn('喂食成功！', 1);
            else
                ajaxReturn('喂食失败！');
        }
    }
}