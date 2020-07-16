<?php
/**
 * 本程序仅供娱乐开发学习，如有非法用途与本公司无关，一切法律责任自负！
 */
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
        //判断网站是否关闭
        $close=is_close_site();
        if($close['value']==0){
          success_alert($close['tip'],U('Login/logout'));
        }
        //验证用户登录
        $this->is_user();

        $uid = session('userid');

       //时间到期增加收益
		$lingqu = M('record')->where(array('in_uid'=>$uid,'is_lin'=>0,'record_status'=>4))->select();
		
		//收益转让金额限制
		$max = M('config')->where(array('name'=>'zhuanrang_max'))->getField('value');
		$min = M('config')->where(array('name'=>'zhuanrang_min'))->getField('value');
        
        foreach ($lingqu as $klingqu => $vlingqu) {
            if(time()-$vlingqu['dj_time']>=0){
                $data['is_lin'] = 1;
                $saves = M('record')->where(array('record_id'=>$vlingqu['record_id']))->save($data);
                $shouyinums = $vlingqu['record_price'] + $vlingqu['record_price']*$vlingqu['profit_value'];//收益
                $yue = M('user')->where(array('userid'=>$uid))->getField('total_active');
                $zengjia = M('user')->where(array('userid'=>$uid))->setInc('total_active',$shouyinums);
                $piddata['get_id'] = $uid;
                $piddata['get_nums'] = $shouyinums;
                $piddata['get_time'] = time();
                $piddata['get_type'] = 22;
                $piddata['now_nums'] = $shouyinums+$yue;
                $addpid = M('tranmoney')->add($piddata);
				
				
				//收益自动挂单
				$now_balance = M('user')->where(array('userid'=>$uid))->getField('total_active');
				if($shouyinums > $max && $shouyinums-$max >= $min){
					$index = floor($shouyinums/$max);
					$reduce_num = 0;
					for($i = 0;$i < $index;$i++){
						$recorddata['out_uid'] = $uid;
						$recorddata['record_form'] = 5;
						$recorddata['record_price'] = $max;
						$recorddata['record_type'] = 2;
						$recorddata['generate_time'] = time();
						$recorddata['record_status'] = 2;
						$recorddata['out_now_nums'] = $now_balance - $i * $max;
						$recorddata['record_no'] = build_order_no();
						$recordres = M('record')->add($recorddata);
						
						//添加卖出余额记录
						$transdata['pay_id'] = $uid;
						$transdata['get_nums'] = $max;
						$transdata['get_time'] = time();
						$transdata['now_nums'] = $now_balance - ($i+1) * $max;
						$transdata['get_type'] = 15;
						M('tranmoney')->add($transdata);
						
						if($recordres){
							M('user')->where(array('userid'=>$uid))->setDec('total_active',$max);
						}
						
						$reduce_num += $max; 
					}
					
					$small_num = $shouyinums - $reduce_num;
					if($small_num >= $min){
						$recorddata['out_uid'] = $uid;
						$recorddata['record_form'] = 5;
						$recorddata['record_price'] = $small_num;
						$recorddata['record_type'] = 2;
						$recorddata['generate_time'] = time();
						$recorddata['record_status'] = 2;
						$recorddata['out_now_nums'] = $now_balance - $reduce_num;
						$recorddata['record_no'] = build_order_no();
						$recordres = M('record')->add($recorddata);
						
						//添加卖出余额记录
						$transdata['pay_id'] = $uid;
						$transdata['get_nums'] = $small_num;
						$transdata['get_time'] = time();
						$transdata['now_nums'] = $now_balance - $reduce_num - $small_num;
						$transdata['get_type'] = 15;
						M('tranmoney')->add($transdata);
						
						if($recordres){
							M('user')->where(array('userid'=>$uid))->setDec('total_active',$small_num);
						}
					}
					
				}else if($shouyinums > $max && $shouyinums-$max < $min){
					$recorddata['out_uid'] = $uid;
					$recorddata['record_form'] = 5;
					$recorddata['record_price'] = $max;
					$recorddata['record_type'] = 2;
					$recorddata['generate_time'] = time();
					$recorddata['record_status'] = 2;
					$recorddata['out_now_nums'] = $now_balance;
					$recorddata['record_no'] = build_order_no();
					$recordres = M('record')->add($recorddata);
					
					//添加卖出余额记录
					$transdata['pay_id'] = $uid;
					$transdata['get_nums'] = $max;
					$transdata['get_time'] = time();
					$transdata['now_nums'] = $now_balance-$max;
					$transdata['get_type'] = 15;
					M('tranmoney')->add($transdata);
					
					if($recordres){
						M('user')->where(array('userid'=>$uid))->setDec('total_active',$max);
					}
				}else if($shouyinums <= $max && $shouyinums >= $min){
					$recorddata['out_uid'] = $uid;
					$recorddata['record_form'] = 5;
					$recorddata['record_price'] = $shouyinums;
					$recorddata['record_type'] = 2;
					$recorddata['generate_time'] = time();
					$recorddata['record_status'] = 2;
					$recorddata['out_now_nums'] = $now_balance;
					$recorddata['record_no'] = build_order_no();
					$recordres = M('record')->add($recorddata);
					
					//添加卖出余额记录
					$transdata['pay_id'] = $uid;
					$transdata['get_nums'] = $shouyinums;
					$transdata['get_time'] = time();
					$transdata['now_nums'] = 0;
					$transdata['get_type'] = 15;
					M('tranmoney')->add($transdata);
					
					if($recordres){
						M('user')->where(array('userid'=>$uid))->setDec('total_active',$shouyinums);
					}
				}
            }
        }
		
      	//pidisme($uid);
        //自动解除订单
        $where6['in_uid|out_uid'] = $uid;
        $where6['record_status'] = 6;
        $end_time = time()-3600*2;
        $where6['pipeitime'] = array('elt',$end_time);
        $order_6 = M('record')->where($where6)->select();
        foreach ($order_6 as $k6 => $v6) {
            $data6['record_status'] = 2;
            $data6['pipeitime'] = null;
            $data6['feed_consume'] = null;
            $data6['profit_value'] = null;
            $data6['profit_day'] = null;
            $data6['scroll_id'] = null;
            $data6['in_uid'] = null;

            M('record')->where(array('record_id'=>$v6['record_id']))->save($data6);
        }

        //自动收款
        $where7['in_uid|out_uid'] = $uid;
        $where7['record_status'] = 7;
        $end_time = time()-3600*2;
        $where7['getmoney_time'] = array('elt',$end_time);
        $order_7 = M('record')->where($where7)->select();
        foreach ($order_7 as $k7 => $v7) {
            $data7['record_status'] = 4;
            $data7['complete_time'] = time();
            $data7['dj_time'] = strtotime($v7['profit_day']."day");
            M('record')->where(array('record_id'=>$v7['record_id']))->save($data7);
        }
        //为过期的星座设置为过期
        $time = time();
       //十二点
        $today = strtotime(date("Y-m-d"),time());
        $yuyue = M('yuyue')->where(array('time'=>array('elt',$today),'status'=>1))->select();
        if($yuyue){
            foreach($yuyue as $yuyuekey=>$yuyuevalue){
                //余额
                $yues = M('user')->where(array('userid'=>$yuyuevalue['uid']))->getField('total_lingshi');
                //返回金额
                $lingshi = $yuyuevalue['book_consume'];
                $fanhui = M('user')->where(array('userid'=>$yuyuevalue['uid']))->setInc('total_lingshi',$lingshi);
                //增加记录
                $tuihuitran['get_id'] = $yuyuevalue['uid'];
                $tuihuitran['get_nums'] = $yuyuevalue['book_consume'];
                $tuihuitran['get_time'] = time();
                $tuihuitran['get_type'] = 25;
                $tuihuitran['now_nums'] = $yues+$yuyuevalue['book_consume'];
                $addtuihui = M('tranmoney')->add($tuihuitran);

                // $tuihuitrans['get_id'] = $yuyuevalue['uid'];
                // $tuihuitrans['get_nums'] = $yuyuevalue['feed_consume'];
                // $tuihuitrans['get_time'] = time();
                // $tuihuitrans['get_type'] = 26;
                // $tuihuitrans['now_nums'] = $yues+$yuyuevalue['feed_consume']+$yuyuevalue['book_consume'];
                // $addtuihuis = M('tranmoney')->add($tuihuitrans);

                M('yuyue')->where('id='.$yuyuevalue['id'])->delete();
            }
        }

        //超时收益
        $record_status_2 = M('record')->where(array('record_status'=>2,'is_chaoshi_lin'=>1))->select();
        foreach ($record_status_2 as $record_status_key => $record_status_value) {

            $start_time = $record_status_value['generate_time']+86400;
            $end_time = $record_status_value['generate_time']+86400*2;
            if(time()>=$start_time && time()<=$end_time){
                //余额
                $chaoshiyue = M('user')->where(array('userid'=>$record_status_value['uid']))->getField('total_active');
                //订单所属星座
                $scrollid = M('scroll')->where(array('start_price'=>array('elt',$record_status_value['record_price']),'end_price'=>array('egt',$record_status_value['record_price'])))->field('id,title,profit_day,profit_value')->find();
                $getchaoshisy = $scrollid['profit_value']/$scrollid['profit_day']*$record_status_value['record_price'];
                $getchaoshisy = round($getchaoshisy,2);
                
                $record_update['is_chaoshi_lin'] = 0;
                $record_save = M('record')->where(array('record_id'=>$record_status_value['record_id']))->save($record_update);
                $record_inc = M('user')->where(array('userid'=>$record_update['out_uid']))->setInc('total_active',$getchaoshisy);

                $chaoshitran['get_id'] = $record_status_value['out_uid'];
                $chaoshitran['get_nums'] = $getchaoshisy;
                $chaoshitran['get_time'] = time();
                $chaoshitran['get_type'] = 27;
                $chaoshitran['now_nums'] = $chaoshiyue+$getchaoshisy;

                M('tranmoney')->add($chaoshitran);
            }
        }
        $user_scroll = M('user_scroll')->where(array('overtime'=>array('elt',$time)))->field('id,uid,scroll_id')->select();
        if($user_scroll){
            foreach($user_scroll as $v){
                M('user_scroll')->where(array('id'=>$v['id']))->setField('status',0);
                $reduce_active = M('scroll')->where(array('id'=>$v['scroll_id']))->getField('active');
                // $reduce_step = M('scroll')->where(array('id'=>$v['scroll_id']))->getField('step_num');
                // M('user')->where(array('userid'=>$v['uid']))->setDec('total_active',$reduce_active);

               
            }
        }
        $user_level = M('user_level')->order('id asc')->select();
        foreach($user_level as $v){
            $grade = M('user_level')->where(array('id'=>$v['level_id']))->getField('vip_grade');
            $childUsersCount = M('user')->where(array('pid'=>$uid,'vip_grade'=>$grade))->count();
            $userActive = M('user')->where(array('userid'=>$uid))->getField('total_active');
            $userGrade = M('user')->where(array('userid'=>$uid))->getField('vip_grade');
            if($userGrade > 0 && $userGrade == ($v['vip_grade'] - 1)&&$childUsersCount >= $v['push_num'] && $userActive >= $v['active_num']){
                $count = $v['scroll_num'];
                $is_give = true;
                $vip_grade = $v['vip_grade'];
                $service_charge = $v['service_charge'];
                $scroll_id = $v['scroll_id'];
            }
        }

        if(isset($is_give) && $is_give){
            for($i = 0;$i<$count;$i++){
                //赠送星座
                $scroll = M('scroll')->where(array('id'=>$scroll_id))->find();
                $uscroll['uid'] = $uid;
                $uscroll['scroll_id'] = $scroll['id'];
                $uscroll['overtime'] = time() + $scroll['max_day'] * 86400;
                $uscroll['status'] = 1;
                $res3 = M('user_scroll')->add($uscroll);

                //为用户添加活跃度
                M('user')->where(array('userid'=>$uid))->setInc('total_active',$scroll['active']);

                //添加活跃度
                $total_active = M('user')->where(array('userid'=>$uid))->getField('total_active');
                $tm['pay_id'] = 0;
                $tm['get_id'] = $uid;
                $tm['get_nums'] = $scroll['active'];
                $tm['get_time'] = time();
                $tm['get_type'] = 47;
                $tm['now_nums'] = $total_active;
                M('tranmoney')->add($tm);

            }
            $arr['vip_grade'] = $vip_grade;
            $arr['service_charge'] = $service_charge;
            M('user')->where(array('userid'=>$uid))->setField($arr);
        }

   
        
        


        // 市场封号
        // 出售
        $sell_deal = M('deal')->where(array('status'=>1,'expiration_time'=>array('elt',time())))->select();
        if($sell_deal){
            foreach($sell_deal as $k => $v){
                if($v['type'] == 1){
                    // M('user')->where(array('userid'=>$v['pay_id']))->setField('status',0);
                    $deal_arr['pay_id'] = 0;
                    $deal_arr['status'] = 0;
                    M('deal')->where(array('id'=>$v['id']))->save($deal_arr);
                }elseif($v['type'] == 2){
                    // M('user')->where(array('userid'=>$v['pay_id']))->setField('status',0);
                    $djie_num = ($v['tprice']-$v['fee_num'])/$v['dprice'] + $v['fee_num'];
                    $arr['djie_num'] = array('exp','djie_num - '.$djie_num);
                    $arr['total_lingshi'] = array('exp','total_lingshi + '.$djie_num);
                    M('user')->where(array('userid'=>$v['sell_id']))->save($arr);
                    
                    //添加记录
                    $total_lingshi = M('user')->where(array('userid'=>$v['uid']))->getField('total_lingshi');
                    $tm['pay_id'] = 0;
                    $tm['get_id'] = $v['uid'];
                    $tm['get_nums'] = $djie_num;
                    $tm['get_time'] = time();
                    $tm['get_type'] = 36;
                    $tm['now_nums'] = $total_lingshi;
                    M('tranmoney')->add($tm);

                    $deal_arr['sell_id'] = 0;
                    $deal_arr['status'] = 0;
                    M('deal')->where(array('id'=>$v['id']))->save($deal_arr);
                }
                
                
            }
        }

        // 购买
        $pay_deal = M('deal')->where(array('status'=>2,'expiration_time'=>array('elt',time())))->select();
        if($pay_deal){
            foreach($pay_deal as $k => $v){
                $deal_arr['status'] = 3;
                $deal_arr['end_time'] = time();
                M('deal')->where(array('id'=>$v['id']))->save($deal_arr);

                //出售用户
                $lingshi = ($v['tprice']-$v['fee_num'])/$v['dprice'] + $v['fee_num']; //积分数量
                M('user')->where(array('userid'=>$v['sell_id']))->setDec('djie_num',$lingshi);
                // 购买用户
                M('user')->where(array('userid'=>$v['pay_id']))->setInc('total_lingshi',$lingshi);
                //添加记录
                $total_lingshi = M('user')->where(array('userid'=>$v['pay_id']))->getField('total_lingshi');
                $tm['pay_id'] = 0;
                $tm['get_id'] = $v['pay_id'];
                $tm['get_nums'] = $lingshi;
                $tm['get_time'] = time();
                $tm['get_type'] = 32;
                $tm['now_nums'] = $total_lingshi;
                M('tranmoney')->add($tm);

                //星级会员收取手续费
                
                // $user_star = M('user_star')->select();
                // foreach($user_star as $key => $val){
                //     $star_user = M('user')->where(array('user_star_id'=>$val['id']))->field('userid')->select();
                //     if($star_user){
                //         //计算所获取得手续费
                //         $num = $deal['fee_num'] * $val['get_fee'] / 100;
                //         $count = count($star_user);
                //         $num = $num / $count;
                //         foreach($star_user as $vals){
                //             M('user')->where(array('userid'=>$vals['userid']))->setInc('total_lingshi',$num);

                //             //添加记录
                //             $total_lingshi = M('user')->where(array('userid'=>$v['uid']))->getField('total_lingshi');
                //             $tm['pay_id'] = 0;
                //             $tm['get_id'] = $vals['userid'];
                //             $tm['get_nums'] = $num;
                //             $tm['get_time'] = time();
                //             $tm['get_type'] = 37;
                //             $tm['now_nums'] = $total_lingshi;
                //             M('tranmoney')->add($tm);
                //         }
                //     }
                // }
            }
        }
    }


    protected function getChild($pid){
        $data = M('user')->where(array('vip_grade'=>array('egt',1)))->field('userid,pid')->select();
        return $this->getTreeChild($data,$pid);
    }


    protected function getTeamChild($pid,$data){
		$data = M('user')->where(array('status'=>1))->field('userid,pid')->select();
        return $this->getTreeChild($data,$pid,true);
    }


    private function getTreeChild($data,$pid,$flag){

        static $list = array();
        if($flag){
            $list = array();
        }
        foreach($data as $k => $v){
            if($v['pid'] == $pid){
                $list[] = $v;
                $this->getTreeChild($data,$v['userid'],false);
            }
        }
        return $list;

    }


 protected function is_user(){
        $userid=user_login();
        $user=M('user');
        if(!$userid){
            $this->redirect('Login/login');
            exit();
        }

        //判断12小时后必须重新登录
        $in_time=session('in_time');
        $time_now=time();
        $between=$time_now-$in_time;
        if($between > 3600 * 24 * 5){
            $this->redirect('Login/logout');
        }

        $where['userid']=$userid;
        $u_info=$user->where($where)->field('status,session_id')->find();
        //判断用户是否锁定
        $login_from_admin=session('login_from_admin');//是否后台登录
        if($u_info['status']==0 && $login_from_admin!='admin'){
            if(IS_AJAX){
                ajaxReturn('你账号已锁定，请联系管理员',0);
            }else{
                success_alert('你账号已锁定，请联系管理员',U('Login/logout'));
                exit();
            }
        }

        //判断用户是否在他处已登录
        $session_id=session_id();
        // if($session_id != $u_info['session_id'] && empty($login_from_admin)){

            // if(IS_AJAX){
                // ajaxReturn('您的账号在他处登录，您被迫下线',0);
            // }else{
                // success_alert('您的账号在他处登录，您被迫下线',U('Login/logout'));
                // exit();
            // }
        // }
        //记录操作时间
        // session('in_time',time());
    }


}

