<?php
namespace Home\ Controller;
use Think\Controller;
class TurntableController extends CommonController {
    /**
     * 直推奖励 
     */
//   public function test(){

    


//  $allid = M('deals')->Field("sell_id,id")->select();
// //dump($allid);die;
//   foreach ($allid as $k => $v) {


//         $uname = M('user')->where(array('userid'=>$v['sell_id']))->getField('username');       
//         $datapay["buy_uname"]=$uname;
//         $res_pay = M('deals')->where(array("id"=>$v['id']))->save($datapay);

       
//      }

//  }

    public function index(){

        $uid = session('userid');
        //查询当前币对应价格

         $coindets=array();
        for($i=1;$i<=5;$i++){
           $coindets[]= D('coindets')->where("cid=".$i)->order('coin_addtime desc')->find();

        }

        $jdjdj = D('coindets')->where("cid=1")->order('coin_addtime desc')->find();

        // var_dump($jdjdj);
    
        //当前我的资产
        $minecoins = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>array("neq",0)))->order('cid asc')->select();
        // var_dump($minecoins);
        //我的钱包地址 没有则自动生成
        $waadd = M('user')->where(array('userid'=>$uid))->getField('wallet_add');
        if(empty($waadd) || $waadd == ''){
            $waadd = build_wallet_add();

            M('user')->where(array('userid'=>$uid))->setField('wallet_add',$waadd);
        }
        $this->assign('coindets',$coindets);
        $this->assign('minecoins',$minecoins);
        $this->assign('waadd',$waadd);
        $this->assign('uid',$uid);

        $this->display();
    }

    // public function vip_grade(){
    //     $locknumd = M('store')->where(array('uid'=>$uid))->find();
    //     $locknum=$locknumd['plant_num']+$locknumd['huafei_total'];
    //     // $oldgrade = M('store')->where(array('uid'=>$uid))->getField('vip_grade');
    //     // $locknumz =$mwenums+$locknumd;//总资产低于相应币数就会降级
    //     // $locknum=$locknumz-$paynums;//当前总资产数
    //     $grade=0;
    //     if($locknum>=10000){
    //          $grade=3;
    //     }elseif($locknum>=5000){
    //          $grade=2;
    //     }elseif($locknum>=1000){
    //          $grade=1;
    //     }
    //     // $graden=$grade1>$grade?$grade:$grade1;//取最小的
    //     // if($oldgrade>$graden) $datapay['vip_grade'] = $graden;//只降级不升级

    //     // $datapay['plant_num'] = array('exp', 'plant_num - ' . $paynums);
    //     $res_pay = M('store')->where(array('uid'=>$uid))->save(array('vip_grade'=>$grade));//转出-NYT
    // }
    //转账的对象
    public function Checkuser(){
        $paynums = I('paynums','float',0);
        $getu = trim(I('moneyadd'));
        $uid = session('userid');
        $mwenums = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->getField('c_nums');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多积分币哦~',0);
        }

        $where['userid|mobile|wallet_add'] = $getu;
        $uinfo = M('user')->where($where)->Field('userid,username')->find();
        if($uinfo['userid'] == $uid){
            ajaxReturn('您不能给自己转账哦~',0);
        }

        if(empty($uinfo) || $uinfo == ''){
            ajaxReturn('您输入的转出地址有误哦~',0);
        }
        $getmsg = array('uname'=>$uinfo['username'],'getuid'=>$uinfo['userid']);
        ajaxReturn($getmsg,1);
    }



 //NYT
    public function Wbaobei(){
        $uid = session('userid');
        $step = I('step');
        if($step < 1){
            $step = 1;
        }


        $times=strtotime(date("Y-m-d"));
        $timee=$times+86400;

        $lastsy = M('wbao_detail')->where(array('uid'=>$uid,'type'=>array("in","3,4"),'create_time'=>array("between",$times.",".$timee)))->sum('num');
       

        if($step==1){
             $list=M('wbao_detail')->where("(type=3 or type=4) and uid=".$uid)->order("create_time desc")->select(); //转入记录

        }elseif($step==2){
             $list=M('wbao_detail')->where("type=1 and uid=".$uid)->order("create_time desc")->select(); //转入记录

        }elseif($step==3){
             $list=M('wbao_detail')->where("type=2 and uid=".$uid)->order("create_time desc")->select(); //转入记录

        }

        
        $wbd = M('store')->where(array('uid'=>$uid))->getField('huafei_total');
        $wbc = M('store')->where(array('uid'=>$uid))->getField('plant_num');
        $wbtotal=number_format($wbd+$wbc,4,".", "");
        $grade= M('store')->where(array('uid'=>$uid))->getField('vip_grade');

        $this->assign('step',$step);
        $this->assign('lastsy',$lastsy);
        $this->assign('wbc',$wbc);
        $this->assign('grade',$grade);
        $this->assign('wbtotal',$wbtotal);
        $this->assign('list',$list);
        $this->display();
    }



    //NYT转入页面
    public function WbaoIn(){

    $uid = session('userid');
    $mwenums = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->getField('c_nums');
    $this->assign('mwenums',$mwenums);
    $this->display();
    }



    //NYT冻结资产页面
    public function WBDongjie(){

    $uid = session('userid');
    $mwenums = M('store')->where(array('uid'=>$uid))->getField('plant_num');
    $this->assign('mwenums',$mwenums);
    $this->display();
    }





 //NYT转入核对
    public function WBCheckuser(){
        $paynums = I('paynums','float',0);
        $paynums = (float)$paynums;



        $uid = session('userid');
        $mwenums = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->getField('c_nums');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多积分币哦~',0);
        }

   
        $getmsg = array('uname'=>$uinfo['username'],'getuid'=>$uinfo['userid']);
        ajaxReturn($getmsg,1);
    }


//NYT转出核对
    public function WBCheckuser1(){
        $paynums = I('paynums','float',0);
        $paynums = (float)$paynums;

        $uid = session('userid');
        $mwenums = M('store')->where(array('uid'=>$uid))->getField('plant_num');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多NYT可用资产哦~',0);
        }

   
        $getmsg = array('uname'=>$uinfo['username'],'getuid'=>$uinfo['userid']);
        ajaxReturn($getmsg,1);
    }



    //NYT转出页面
    public function WbaoOut(){

    $uid = session('userid');
    $mwenums = M('store')->where(array('uid'=>$uid))->getField('plant_num');
    $this->assign('mwenums',$mwenums);
    $this->display();
    }


// NYT冻结资产
    public function WBDong(){
        $paynums = I('paynums','float',0);
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        $mwenums = M('store')->where(array('uid'=>$uid))->getField('plant_num');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多NYT可用资产哦~',0);
        }
        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //冻结减NYT可用资产 加锁定资产  

        $locknumy = M('store')->where(array('uid'=>$uid))->getField('huafei_total');
        $locknum=$locknumy+$paynums;
        $grade=0;
        if($locknum>=10000){
             $grade=3;
        }elseif($locknum>=5000){
             $grade=2;
        }elseif($locknum>=1000){
             $grade=1;
        }

        $datapay['vip_grade'] =$grade;
        $datapay['plant_num'] = array('exp', 'plant_num - ' . $paynums);
        $datapay['huafei_total'] = array('exp', 'huafei_total + ' . $paynums);
        $res_pay = M('store')->where(array('uid'=>$uid))->save($datapay);

        if($res_pay){

        //添加NYT交易记录
        $wbaoss["crowds_id"]=0;
        $wbaoss["create_time"]=time();
        $wbaoss["num"]=$paynums;
        $wbaoss["uid"]=$uid;
        $wbaoss["dprice"]=0;
        $wbaoss["tprice"]=0;
        $wbaoss["type"]=5;//锁定资产
        $wbao_ss = M('wbao_detail')->add($wbaoss);

            ajaxReturn('NYT可用资产锁定成功',1,"Wbaobei");
        }else{
            ajaxReturn('NYT可用资产锁定失败',0);
        }
    }



 // NYT转出
    public function WBgetout(){
        $paynums = I('paynums','float',0);
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        $mwenums = M('store')->where(array('uid'=>$uid))->getField('plant_num');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多NYT可用资产哦~',0);
        }
          if($paynums<=0){
            ajaxReturn('非法操作~',0);
        }

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);


        //一旦用户转出小于某数量的币，则等级会降
        $grade1=3;
        if($paynums<1000){
             $grade1=0;
        }elseif($paynums<5000){
             $grade1=1;
        }elseif($paynums<10000){
             $grade1=2;
        }

        //转出减NYT可用资产 加Ypay币  

        $locknumd = M('store')->where(array('uid'=>$uid))->getField('huafei_total');
        $oldgrade = M('store')->where(array('uid'=>$uid))->getField('vip_grade');
        $locknumz =$mwenums+$locknumd;//总资产低于相应币数就会降级
        $locknum=$locknumz-$paynums;//当前总资产数
        $grade=0;
        if($locknum>=10000){
             $grade=3;
        }elseif($locknum>=5000){
             $grade=2;
        }elseif($locknum>=1000){
             $grade=1;
        }
        $graden=$grade1>$grade?$grade:$grade1;//取最小的
        if($oldgrade>$graden) $datapay['vip_grade'] = $graden;//只降级不升级

        $datapay['plant_num'] = array('exp', 'plant_num - ' . $paynums);
        $res_pay = M('store')->where(array('uid'=>$uid))->save($datapay);//转出-NYT
     
        $payout['c_nums'] = array('exp', 'c_nums + ' . $paynums);
        $res_pay = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->save($payout);//转出+Ypay




        if($res_pay){

        //添加NYT交易记录
        $wbaoss["crowds_id"]=0;
        $wbaoss["create_time"]=time();
        $wbaoss["num"]=$paynums;
        $wbaoss["uid"]=$uid;
        $wbaoss["dprice"]=0;
        $wbaoss["tprice"]=0;
        $wbaoss["type"]=1;//转出
        $wbao_ss = M('wbao_detail')->add($wbaoss);

            ajaxReturn('NYT可用资产转出成功',1,"Wbaobei");
        }else{
            ajaxReturn('NYT可用资产转出失败',0);
        }
    }


// NYT转入
    public function WBgetin(){
        $paynums = I('paynums','float',0);

        $pwd = trim(I('pwd'));
        $uid = session('userid');
        $mwenums = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->getField('c_nums');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多积分币哦~',0);
        }

         if($paynums<=0){
            ajaxReturn('非法操作~',0);
        }


        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //转入加NYT可用资产 减Ypay币  
        
        $datapay['plant_num'] = array('exp', 'plant_num + ' . $paynums);
        $res_pay = M('store')->where(array('uid'=>$uid))->save($datapay);//转出+Ypay
        //转出的扣钱
        $payout['c_nums'] = array('exp', 'c_nums - ' . $paynums);
        $res_pay = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->save($payout);//转出-Ypay

        if($res_pay){

        //添加NYT交易记录
        $wbaoss["crowds_id"]=0;
        $wbaoss["create_time"]=time();
        $wbaoss["num"]=$paynums;
        $wbaoss["uid"]=$uid;
        $wbaoss["dprice"]=0;
        $wbaoss["tprice"]=0;
        $wbaoss["type"]=2;//转入
        $wbao_ss = M('wbao_detail')->add($wbaoss);

            ajaxReturn('积分币转入成功',1,"Wbaobei");
        }else{
            ajaxReturn('积分币转入失败',0);
        }
    }




       


//    Ypay转入
    public function Wegetin(){
        $paynums = I('paynums','float',0);
        $getu = trim(I('moneyadd'));
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        $mwenums = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->getField('c_nums');
        if($paynums > $mwenums){
            ajaxReturn('您当前暂无这么多积分币哦~',0);
        }

        $where['userid|mobile|wallet_add'] = $getu;
        $uinfo = M('user')->where($where)->Field('userid,username')->find();
        if($uinfo['userid'] == $uid){
            ajaxReturn('您不能给自己转账哦~',0);
        }

        if(empty($uinfo) || $uinfo == ''){
            ajaxReturn('您输入的转出地址有误哦~',0);
        }

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //转入的加钱
        $issetgetu = M('ucoins')->where(array('c_uid'=>$uinfo['userid'],'cid'=>1))->count(1);
        if($issetgetu <= 0){
            $coinone['cid'] = 1;
            $coinone['c_nums'] = 0.0000;
            $coinone['c_uid'] = $uinfo['userid'];
            M('ucoins')->add($coinone);
        }
        $datapay['c_nums'] = array('exp', 'c_nums + ' . $paynums);
        $res_pay = M('ucoins')->where(array('c_uid'=>$uinfo['userid'],'cid'=>1))->save($datapay);//转出+Ypay
        //转出的扣钱
        $payout['c_nums'] = array('exp', 'c_nums - ' . $paynums);
        $res_pay = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>1))->save($payout);//转出-Ypay

        //转入的人+20%积分记录EEE
        $jifen_dochange['pay_id'] = $uid;
        $jifen_dochange['get_id'] = $uinfo['userid'];
        $jifen_dochange['get_nums'] = $paynums;
        $jifen_dochange['get_time'] = time();
        $jifen_dochange['get_type'] = 1;
        $res_tran = M('wetrans')->add($jifen_dochange);
        if($res_tran){
            ajaxReturn('积分币转出成功',1,"index");
        }else{
            ajaxReturn('积分币转出失败',0);
        }
    }

    public function Trans(){
        $type = I('type','intval',0);
        $traInfo = M('wetrans');
        $uid = session('userid');
        if($type == 1){
            $where['pay_id'] = $uid;
        }else{
            $where['get_id'] = $uid;
        }

        $where['get_type'] = 1;
        //分页
        $p = getpage($traInfo, $where, 15);
        $page = $p->show();
        $Chan_info = $traInfo->where($where)->order('id desc')->select();
        foreach ($Chan_info as $k => $v) {
            $Chan_info[$k]['get_timeymd'] = date('Y-m-d', $v['get_time']);
            $Chan_info[$k]['get_timedate'] = date('H:i:s', $v['get_time']);
            $Chan_info[$k]['outinfo'] = M('user')->where(array('userid'=>$v['get_id']))->getField('username');
            $Chan_info[$k]['ininfo'] = M('user')->where(array('userid'=>$v['pay_id']))->getField('username');

            //转入转出
            if ($type == 1) {
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
        $this->assign('type',$type);
        $this->display();
    }


    public function Turnout(){

        $this->display();
    }
	

    //金积分交易
    public function transaction(){

       
        $uid = session('userid');
        $type = (int)I('type')?(int)I('type'):1;
        if($type==1){
            //出售
            $where2['status'] = array('in','0');
            // $where2['sell_id'] = array('neq',$uid);
            $where2["type"]=2;
            $list = M('deal')->order('id desc')->where($where2)->limit(25)->select();
            foreach($list as $k => $v){
                $list[$k]['username'] = M('user')->where(array('userid'=>$v['pay_id']))->getField('username');
                $list[$k]['truename'] = M('user')->where(array('userid'=>$v['pay_id']))->getField('truename');
                $list[$k]['img_head'] = M('user')->where(array('userid'=>$v['pay_id']))->getField('img_head');
            }
        }elseif($type==2){
            //购买
            $where2['status'] = array('in','0');
            $where['status'] = 0;
            // $where['pay_id'] = array('neq',$uid);
            $where["type"]=1;
            $list = M('deal')->order('id desc')->where($where)->limit(25)->select();
            foreach($list as $k => $v){
                $list[$k]['username'] = M('user')->where(array('userid'=>$v['sell_id']))->getField('username');
                $list[$k]['truename'] = M('user')->where(array('userid'=>$v['sell_id']))->getField('truename');
                $list[$k]['img_head'] = M('user')->where(array('userid'=>$v['sell_id']))->getField('img_head');                
            }
        
        }
        $start_time = strtotime(date('Y-m-d').'-7 day');
        $end_time = time();
        $map['create_time'] = array(
            array('egt',$start_time),
            array('elt',$end_time),
        );
        $deal = M('deal')->where($map)->order('create_time asc')->select();
        $kline = array();
        while($start_time <= $end_time){
            $arr['sell_num'] = 0;
            $arr['purch_num'] = 0;
            $kline[date('m-d',$start_time)] = $arr;
            $start_time = $start_time + 86400;
        }
        
        foreach($deal as $k => $v){
            if($v['type'] == 1){
                $arr['purch_num'] = $v['dprice'];
            }elseif($v['type'] == 2){
                $arr['sell_num'] = $v['dprice'];
            }
            $kline[date('m-d',$v['create_time'])] = $arr;
        }
        $this->assign('kline',$kline);
        $token_code = getCode();
        session('token_code',$token_code);
        $this->assign('token_code',$token_code);
        $this->assign('uid',$uid);
        $this->assign('type',$type);
        $this->assign('list',$list);
        $this->display();

    }


//金积分购买
    public function yue_goumai(){

//防重复提交
    if(session("gou_last_time")){
                 if((int)time()-(int)session("gou_last_time") <10 ){           
                  ajaxReturn('对不起，10秒内不能频繁提交~',0);
                 }
    }

    
    $t = (int)time();
    session("gou_last_time", $t);
    

        $num = (float)I('num');
        $cid = (int)I('cid','intval',0);
        $dealid = I('dealid','intval',0);
        $dprice = trim(I('dprice'));
        $tprice = trim(I('tprice'));
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        

        $ss1 = M('deal')->where(array('id'=>$dealid,'type'=>1))->getField('num');
        $restn= $num-$ss1;

        if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
        if(!$num|!$tprice)ajaxReturn('交易币的数量不能为空~',0);
        if($restn>0)ajaxReturn('交易币的数量超过最大限制~',0);



        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //自己是否有足够金积分        
            $my_yue = M('store')->where(array('uid'=>$uid))->getField('cangku_num');
            if($tprice> $my_yue){
                ajaxReturn('您当前账户暂无这么多金积分~',0);
            }


        //挂卖单人的ID
        $sell_id = M('deal')->where(array('id'=>$dealid,'type'=>1))->getField('sell_id');

        if($uid==$sell_id){
                ajaxReturn('您不能和自己交易~',0);
            }
        //检查 store表和 coindets 表是否有记录

         $ishas_store_u = M('store')->where(array('uid'=>$uid))->count(1);
        if(!$ishas_store_u)M('store')->add(array('uid'=>$uid,'cangku_num'=>0.0000));   
        $ishas_store_s = M('store')->where(array('uid'=>$sell_id))->count(1);
        if(!$ishas_store_s)M('store')->add(array('uid'=>$sell_id,'cangku_num'=>0.0000));   


        $issetgetu = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->count(1);
        if($issetgetu <= 0){
            $coinone['cid'] = $cid;
            $coinone['c_nums'] = 0.0000;
            $coinone['c_uid'] = $uid;
            M('ucoins')->add($coinone);
        }


        $issetgets = M('ucoins')->where(array('c_uid'=>$sell_id,'cid'=>$cid))->count(1);
        if($issetgets <= 0){
            $coinone1['cid'] = $cid;
            $coinone1['c_nums'] = 0.0000;
            $coinone1['c_uid'] = $sell_id;
            M('ucoins')->add($coinone1);
        }

        //购买的加币的数量、减金积分    



        $datapay['c_nums'] = array('exp', 'c_nums + ' . $num);
        $res0 = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->save($datapay);

        $datapay1['cangku_num'] = array('exp', 'cangku_num - ' . $tprice);
        $res1 = M('store')->where(array('uid'=>$uid))->save($datapay1);

        //出售的扣币的数量、加金积分
        
        $payout['djie_nums'] = array('exp', 'djie_nums - ' . $num);
        $res2 = M('ucoins')->where(array('c_uid'=>$sell_id,'cid'=>$cid))->save($payout);

        $payout1['cangku_num'] = array('exp', 'cangku_num + ' . $tprice);
        $res3 = M('store')->where(array('uid'=>$sell_id))->save($payout1);


        $pay_n = M('store')->where(array('uid' => $uid))->getField('cangku_num');
        $get_n = M('store')->where(array('uid' => $sell_id))->getField('cangku_num');


        $changenums['now_nums'] = $pay_n;
        $changenums['now_nums_get'] = $get_n;
        $changenums['is_release'] = 1;                 
        $changenums['pay_id'] = $uid;
        $changenums['get_id'] = $sell_id;
        $changenums['get_nums'] = $tprice;
        $changenums['get_time'] = time();
        $changenums['get_type'] = 4;
        M('tranmoney')->add($changenums);


        //剩余数量，更新订单状态1，为匹配交易
        if($restn>=0)$deals["status"]=1;
        $deals["num"]=array('exp', 'num - ' . $num);
        $deal_s = M('deal')->where(array('id'=>$dealid,'type'=>1))->save($deals);

        //添加交易记录
        $buy_name = M('user')->where(array('userid'=>$uid))->getField('username');    

        $dealss["d_id"]=$dealid;
        $dealss["sell_id"]=$sell_id;
        $dealss["buy_id"]=$uid;
        $dealss["create_time"]=time();
        $dealss["buy_uname"]=$buy_name;
        $dealss["cid"]=$cid;
        $dealss["type"]=1;
        $dealss["num"]=$num;
        $dealss["dprice"]=$dprice;
        $dealss["tprice"]=$tprice;
        $deal_ss = M('deals')->add($dealss);

        if($res0&&$res3&&$deal_ss){
            ajaxReturn('购买成功',1,"/Turntable/Transaction");
        }else{
            ajaxReturn('购买失败',0);
        }

    }

    //取消交易
    public function quxiao(){
        $id = (int)I('id');
        $type = (int)I('type');
        
        $deal = M('deal')->where(array('id'=>$id,'type'=>$type,'status'=>0))->find();
        if(!$deal){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '该数据不存在，请刷新重试';
            exit(json_encode($ajax_arr));
        }

        $token_code = trim(I('token_code'));
        if($token_code&&$token_code != session('token_code')){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '请勿重复提交';
            exit(json_encode($ajax_arr));
        }
        session('token_code',getCode());

        M()->startTrans();
        if($deal['type'] == 1){
            //返还积分,出售
            $lingshi = ($deal['tprice'] - $deal['fee_num'])/$deal['dprice'] + $deal['fee_num'];
            $u_arr['djie_num'] = array('exp','djie_num -'.$lingshi);
            $u_arr['total_lingshi'] = array('exp','total_lingshi +'.$lingshi);
            M('user')->where(array('userid'=>$deal['sell_id']))->save($u_arr);

            $total_lingshi = M('user')->where(array('userid'=>$deal['sell_id']))->getField('total_lingshi');
            //添加 tranmoney记录
            $tm['pay_id'] = 0;
            $tm['get_id'] = $deal['sell_id'];
            $tm['get_nums'] = $lingshi;
            $tm['get_time'] = time();
            $tm['get_type'] = 46;
            $tm['now_nums'] = $total_lingshi;
            M('tranmoney')->add($tm);

            $res = M('deal')->where(array('id'=>$id))->setField('status',4);
        }else{
            // 购买单
            $res = M('deal')->where(array('id'=>$id))->setField('status',4);

        }
        if($res !== false){
            M()->commit();
            $ajax_arr['code'] = 1;
            $ajax_arr['msg'] = '取消交易成功';
            $ajax_arr['url'] = U('Turntable/Transaction');
            exit(json_encode($ajax_arr));
        }else{
            M()->rollback();
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '取消交易失败';
            exit(json_encode($ajax_arr));
        }
    }


//出售币
    public function yue_chushou(){

    if(session("chu_last_time")){
                 if((int)time()-(int)session("chu_last_time") <10 ){           
                  ajaxReturn('对不起，10秒内不能频繁提交~',0);
                 }
    }
    $t = (int)time();
    session("chu_last_time", $t);


        
        $num = (float)I('num');
        $cid = (int)I('cid','intval',0);
        $dealid = I('dealid','intval',0);
        $dprice = trim(I('dprice'));
        $tprice = trim(I('tprice'));
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        

         $ss1 = M('deal')->where(array('id'=>$dealid,'type'=>2))->getField('num');
         $restn= $num-$ss1;


        if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
        if(!$num|!$tprice)ajaxReturn('交易币的数量不能为空~',0);
        if($restn>0)ajaxReturn('交易币的数量超过最大限制~',0);
        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);



        //自己是否有足够币出售        
        $my_bi = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->getField('c_nums');            
            if($num> $my_bi){
                ajaxReturn('您当前账户暂无这么多币出售~',0);
            }


        //挂买单人的ID
        $sell_id = M('deal')->where(array('id'=>$dealid,'type'=>2))->getField('sell_id');
        if($uid==$sell_id){
                ajaxReturn('您不能和自己交易~',0);
            }


        //检查 store表和 coindets 表是否有记录

         $ishas_store_u = M('store')->where(array('uid'=>$uid))->count(1);
        if(!$ishas_store_u)M('store')->add(array('uid'=>$uid,'cangku_num'=>0.0000));   
        $ishas_store_s = M('store')->where(array('uid'=>$sell_id))->count(1);
        if(!$ishas_store_s)M('store')->add(array('uid'=>$sell_id,'cangku_num'=>0.0000));      



        $issetgetu = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->count(1);
        if($issetgetu <= 0){
            $coinone['cid'] = $cid;
            $coinone['c_nums'] = 0.0000;
            $coinone['c_uid'] = $uid;
            M('ucoins')->add($coinone);
        }


        $issetgets = M('ucoins')->where(array('c_uid'=>$sell_id,'cid'=>$cid))->count(1);
        if($issetgets <= 0){
            $coinone1['cid'] = $cid;
            $coinone1['c_nums'] = 0.0000;
            $coinone1['c_uid'] = $sell_id;
            M('ucoins')->add($coinone1);
        }

   
       

        //出售的减对应的币数、加对应的金积分
        $datapay['c_nums'] = array('exp', 'c_nums - ' . $num);
        $res_pay0 = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->save($datapay);

        $datapay1['cangku_num'] = array('exp', 'cangku_num + ' . $tprice);
        $res_pay1 = M('store')->where(array('uid'=>$uid))->save($datapay1);


        //购买的扣金积分、加币
         $payout['c_nums'] = array('exp', 'c_nums + ' . $num);
         $res_pay2 = M('ucoins')->where(array('c_uid'=>$sell_id,'cid'=>$cid))->save($payout);
         
         $payout1['cangku_num'] = array('exp', 'cangku_num - ' . $tprice);
         
         $res_pay3= M('store')->where(array('uid'=>$sell_id))->save($payout1);
        //  var_dump($res_pay3);
        // var_dump(M('store')->getLastSql());

        //更新订单状态1，为匹配交易
        if($restn>=0) $deals["status"]=1;
        $deals["num"]=array('exp', 'num - ' . $num);
        $deal_s = M('deal')->where(array('id'=>$dealid,'type'=>2))->save($deals);
//dump($res_pay3);die;

        //添加交易记录
        $buy_name = M('user')->where(array('userid'=>$sell_id))->getField('username');    

        $dealss["d_id"]=$dealid;
        $dealss["sell_id"]=$sell_id;
        $dealss["buy_id"]=$uid;
        $dealss["create_time"]=time();
        $dealss["buy_uname"]=$buy_name;
        $dealss["cid"]=$cid;
        $dealss["type"]=2;
        $dealss["num"]=$num;
        $dealss["dprice"]=$dprice;
        $dealss["tprice"]=$tprice;
        
        $deal_ss = M('deals')->add($dealss);



        $pay_n = M('store')->where(array('uid' => $sell_id))->getField('cangku_num');
        $get_n = M('store')->where(array('uid' => $uid))->getField('cangku_num');


        $changenums['now_nums'] = $pay_n;
        $changenums['now_nums_get'] = $get_n;
        $changenums['is_release'] = 1;  
        $changenums['pay_id'] = $sell_id;
        $changenums['get_id'] = $uid;
        $changenums['get_nums'] = $tprice;
        $changenums['get_time'] = time();
        $changenums['get_type'] = 5;
        M('tranmoney')->add($changenums);


        
        // var_dump($res_pay3);
       
        if($res_pay0&&$res_pay3&&$deal_ss){
            ajaxReturn('售出成功',1,"/Turntable/Transaction");

        }else{
            ajaxReturn('售出失败',0);
        }

    }



    //交易中心
    public function Transactionsell(){
        
       $cid = (int)I('cid','intval',0);
       if($cid=='intval')$cid=1;
        $uid = session('userid');

       //查询当前币对应价格名称信息
        $coindets = M('coindets')->order('coin_addtime desc,cid asc')->where(array("cid"=>$cid))->find();

         //当前我的资产
        $minecoins = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->order('id asc')->find();
        $my_yue = M('store')->where(array('uid'=>$uid))->getField('cangku_num');

         //交易列表
              

        $deals = M('deal a')->join('ysk_user b ON a.sell_id=b.userid')->field('b.username as u_name,a.id as d_id,b.account as u_account,b.img_head as u_img_head,a.num as d_num,a.dprice as d_dprice,a.id as d_id')->where(array("a.type"=>2,"a.status"=>0,"a.cid"=>$cid))->limit($page, 5000)->order('d_dprice desc')->select();


      
        $this->assign('coindets',$coindets);
        $this->assign('cname',$cname);
        $this->assign('deals',$deals);
        $this->assign('minecoins',$minecoins);
        $this->assign('my_yue',$my_yue);
        $this->assign('cid',$cid);

        $this->display();


    }






//取消订单
 public function quxiao_order(){
    $id = (int)I('id','intval',0);
    $uid = session('userid');
    $mydeal = M('deal')->where(array("id"=>$id,"sell_id"=>$uid))->find();

    if(!$mydeal){
        ajaxReturn('订单不存在~',0);
    }

    $type=$mydeal["type"];
    $num=$mydeal["num"];
    $cid=$mydeal["cid"];
    $dprice=$mydeal["dprice"];
    if($mydeal['status'] != 2){
        if($type==1){//为出售单，则返还剩余相应的币
            $payout['c_nums'] = array('exp', 'c_nums + ' . $num);
            $res1 = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->save($payout); 
        }elseif($type==2){//为购买单，则返还剩余相应的金积分

            $tprice=$num*$dprice;
            $payout1['cangku_num'] = array('exp', 'cangku_num + ' . $tprice);
            $res2 = M('store')->where(array('uid'=>$uid))->save($payout1);


            //生成金积分记录
            $pay_n = M('store')->where(array('uid' => $uid))->getField('cangku_num');

            $changenums['now_nums'] = $pay_n;
            $changenums['now_nums_get'] = $pay_n;
            $changenums['is_release'] = 1;
            $changenums['pay_id'] = 0;
            $changenums['get_id'] = $uid;
            $changenums['get_nums'] = $tprice;
            $changenums['get_time'] = time();
            $changenums['get_type'] = 6;
            M('tranmoney')->add($changenums);

        }
    }
    //把此订单状态设置为2，即为取消

    $payout2['status'] =2;
    $res3 =M('deal')->where(array("id"=>$id,"sell_id"=>$uid))->save($payout2);

    if($res3){       
        ajaxReturn('取消成功',0,"Orderinfos");
    }else{
        ajaxReturn('操作失败',0,"Orderinfos");
    }
}



    //提交发布出售订单
    public function T_Salesell(){

        $num = (float)I('num');
        $cid = (int)I('cid','intval',0);
        $dprice = trim(I('dprice'));
        $tprice = trim(I('tprice'));
        $pwd = trim(I('pwd'));
        $uid = session('userid');

        //检测是否存在别的单
        $is_deal = M('deal')->where(array('pay_id|sell_id'=>$uid,'status'=>array('in','1,2')))->count();
        if($is_deal){
            ajaxReturn('请先完成订单后再下单',0);
        }


        $nowprice=M('coindets')->where(array('cid'=>$cid))->order('coin_addtime desc')->getField('coin_price');

          if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
    
        if(!$num|!$tprice)ajaxReturn('积分的数量不能为空~',0);
     

        // if($dprice>1.1*$nowprice)ajaxReturn('交易币的单价不能高过当前价格10%~',0);

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //当前我的资产
        $minecoins = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->order('id asc')->getField('c_nums');
      //  $my_yue = M('store')->where(array('uid'=>$uid))->getField('cangku_num');   
 
        if($minecoins<$num){
             ajaxReturn('积分的数量不足',0);
         }

        //冻结我的资产
        $payout['djie_nums'] = array('exp', 'djie_nums + ' . $num);
        $payout['c_nums'] = array('exp', 'c_nums - ' . $num);
        $res2 = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->save($payout);
         

        //生成交易记录
        $deal['sell_id'] = $uid;  //挂售出单人ID
        $deal['num'] = $num;
        $deal['ynum'] = $num;
        $deal['create_time'] = time();
        $deal['tprice'] = $tprice;       
        $deal['dprice'] = $dprice;
       
        $deal['cid'] = $cid;
        $deal['type'] = 1;//1为出售订单
        $res_tran = M('deal')->add($deal);
 
        ajaxReturn('发布成功',1,"/Turntable/Transaction/cid/".$cid);         
 

    }




    //发布出售订单的页面
    public function Salesell(){

        $uid = session('userid');
        $cid = (int)I('cid','intval',0);

        //查询当前币对应价格及名称
        $coindets = M('coindets')->order('coin_addtime desc,cid asc')->where(array("cid"=>$cid))->find();
    

        //当前我的资产
        $minecoins = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->order('id asc')->find();
         $my_yue = M('store')->where(array('uid'=>$uid))->getField('cangku_num');


        $this->assign('minecoins',$minecoins);
        $this->assign('my_yue',$my_yue);
        $this->assign('coindets',$coindets);
        $this->assign('cid',$cid);

        $this->display();

    }
    
    //发布购买订单的页面
    public function Salebuys(){
        
        $uid = session('userid');


       //查询当前用户等级扣除手续费
       $tran_fee = M('user u')->join('ysk_user_level ul ON u.vip_grade=ul.vip_grade')->where(array('u.userid'=>$uid))->getField('ul.tran_fee');

       $buy_new_price = M('config')->where(array('name'=>'buy_new_price'))->getField('value');
    

        //当前我的资产
        $my_yue = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        $this->assign('buy_new_price',$buy_new_price);
        $this->assign('tran_fee',$tran_fee);
        $this->assign('my_yue',$my_yue);

        $this->display();


    }


    //提交发布购买订单
    public function T_Salebuys(){
        $num = (float)I('num');
        $dprice = trim(I('dprice'));
        $tprice = $num*$dprice;
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        // $tran_price = trim(I('tran_frice')); //手续费

        // 实名认证和支付
        $is_real_name = M('user')->where(array('userid'=>$uid))->getField('is_real_name');
        $is_pay = M('user')->where(array('userid'=>$uid))->getField('is_pay');
        if($is_real_name == 0 || $is_pay == 0){
            ajaxReturn('请先进行实名认证',1,U('User/real_name'));
        }

        //检测是否存在支付宝
        $is_default = M('ubanks')->where(array('user_id'=>$uid))->count();
        if(!$is_default){
            ajaxReturn('请先填写支付宝',1,U('Growth/Cardinfos'));
        }

        //检测是否存在别的单
        $is_deal = M('deal')->where(array('pay_id|sell_id'=>$uid,'status'=>array('in','1,2')))->count();
        if($is_deal){
            ajaxReturn('请先完成订单后再下单',0);
        }


        if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
        if(!$num|!$tprice)ajaxReturn('积分的数量不能为空~',0);

        // if($dprice>1.1)ajaxReturn('交易币的单价不能高过当前价格10%~',0);

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //根据用户等级扣除手续费
        $vip_grade = M('user')->where(array('userid'=>$uid))->getField('vip_grade');
        $tran_fee = M('user_level')->where(array('vip_grade'=>$vip_grade))->getField('tran_fee');
        $tran_price = $tprice * $tran_fee / 100; //手续费
    

        //自己是否有足够积分      
        // $my_yue = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        // if($tprice > $my_yue){
        //     ajaxReturn('您当前账户暂无这么多金积分~',0);
        // }

        //  //冻结我的积分
        //  $payout1['djie_num'] = array('exp', 'djie_num + ' . $tprice);
        //  $payout1['total_lingshi'] = array('exp', 'total_lingshi - ' . $tprice);
        //  $res_pay3 = M('user')->where(array('userid'=>$uid))->save($payout1);


        //生成交易记录
        $deal['pay_id'] = $uid;  //挂售出单人ID
        $deal['num'] = $num;
        $deal['fee_num'] = 0;
        $deal['create_time'] = time();
        $deal['tprice'] = $tprice;       
        $deal['dprice'] = $dprice;
        $deal['type'] = 2;//2为购买订单
        $res_tran = M('deal')->add($deal);

        // $pay_n = M('store')->where(array('uid' => $uid))->getfield('cangku_num');

        //生成金积分记录
        // $changenums['pay_id'] = $uid;
        // $changenums['get_id'] = 0;
        // $changenums['now_nums'] = $pay_n;
        // $changenums['now_nums_get'] = $pay_n;
        // $changenums['is_release'] = 1;
        // $changenums['get_nums'] = $tprice;
        // $changenums['get_time'] = time();
        // $changenums['get_type'] = 3;
        // M('tranmoney')->add($changenums);

 
        ajaxReturn('发布成功',1,"/Turntable/Transreocrds");
         
 

    }


    public function Sell(){
        $uid = session('userid');
        // $fee_num = 200;
        // $users = M('user')->where(array('vip_grade'=>array('egt',2)))->field('service_charge,userid,vip_grade')->select();
        // foreach($users as $k => $v){
        //     $num = $fee_num * 20 / 100;
        //     $num = $num*$v['service_charge']/100;
        //     dump($num);
        //     // M('user')->where(array('userid'=>$v['userid']))
        // }
        // exit;

       //查询当前用户等级扣除手续费
       $tran_fee = M('user u')->join('ysk_user_level ul ON u.vip_grade=ul.vip_grade')->where(array('u.userid'=>$uid))->getField('ul.tran_fee');
       $sell_new_price = M('config')->where(array('name'=>'sell_new_price'))->getField('value');

        //当前我的资产
        $my_yue = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        $this->assign('sell_new_price',$sell_new_price);
        $this->assign('tran_fee',$tran_fee);
        $this->assign('my_yue',$my_yue);
        $this->display();
    }

    public function T_sell(){
        
        $num = (float)I('num');
        $dprice = trim(I('dprice'));
        $tprice = $num*$dprice;
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        // $tran_price = trim(I('tran_frice')); //手续费
        
        // 实名认证和支付
        $is_real_name = M('user')->where(array('userid'=>$uid))->getField('is_real_name');
        $is_pay = M('user')->where(array('userid'=>$uid))->getField('is_pay');
        if($is_real_name == 0 || $is_pay == 0){
            ajaxReturn('请先进行实名认证',1,U('User/real_name'));
        }

        //检测是否存在支付宝
        $is_default = M('ubanks')->where(array('user_id'=>$uid))->count();
        if(!$is_default){
            ajaxReturn('请先填写支付宝',1,U('Growth/Cardinfos'));
        }

        //检测是否存在别的单
        $is_deal = M('deal')->where(array('pay_id|sell_id'=>$uid,'status'=>array('in','1,2')))->count();
        if($is_deal){
            ajaxReturn('请先完成订单后再下单',0);
        }

        if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
        if(!$num|!$tprice)ajaxReturn('积分的数量不能为空~',0);

        // if($dprice>1.1)ajaxReturn('交易币的单价不能高过当前价格10%~',0);

        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //根据用户等级扣除手续费
        $vip_grade = M('user')->where(array('userid'=>$uid))->getField('vip_grade');
        $tran_fee = M('user_level')->where(array('vip_grade'=>$vip_grade))->getField('tran_fee');
        $tran_price = $num * $tran_fee / 100; //手续费
        
        // 与手续费相加
        $tprice = $tprice + $tran_price;

        // //自己是否有足够积分      
        $my_yue = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        if(($num+$tran_price+5) > $my_yue){
            ajaxReturn('暂无这么多积分,账户需保留5个~',0);
        }

        $lingshi = ($num+$tran_price);

         //冻结我的积分
         $payout1['djie_num'] = array('exp', 'djie_num + ' . $lingshi);
         $payout1['total_lingshi'] = array('exp', 'total_lingshi - ' . $lingshi);
         $res_pay3 = M('user')->where(array('userid'=>$uid))->save($payout1);

         $total_lingshi = M("user")->where(array('userid'=>$uid))->getField('total_lingshi');
         $tm['pay_id'] = $uid;
         $tm['get_id'] = 0;
         $tm['get_nums'] = $lingshi;
         $tm['get_time'] = time();
         $tm['get_type'] = 29;
         $tm['now_nums'] = $total_lingshi;
         M('tranmoney')->add($tm);


        //生成交易记录
        $deal['sell_id'] = $uid;  //挂售出单人ID
        $deal['num'] = $num;
        $deal['fee_num'] = $tran_price;
        $deal['create_time'] = time();
        $deal['tprice'] = $tprice;       
        $deal['dprice'] = $dprice;
        $deal['type'] = 1;//2为购买订单
        $res_tran = M('deal')->add($deal);

        // $pay_n = M('store')->where(array('uid' => $uid))->getfield('cangku_num');

        //生成金积分记录
        // $changenums['pay_id'] = $uid;
        // $changenums['get_id'] = 0;
        // $changenums['now_nums'] = $pay_n;
        // $changenums['now_nums_get'] = $pay_n;
        // $changenums['is_release'] = 1;
        // $changenums['get_nums'] = $tprice;
        // $changenums['get_time'] = time();
        // $changenums['get_type'] = 3;
        // M('tranmoney')->add($changenums);

 
        ajaxReturn('发布成功',1,"/Turntable/Transreocrds");
         
 
    }


    //订单
    public function Orderinfos(){

        $cid = (int)I('cid','intval',0);
   
        $step =I('step');//
        if(!$step) $step =1;
        $uid = session('userid');
        $where["sell_id"]=$uid;
        $where["status"]=0;   
        $where["cid"]=$cid;            
        if($step ==2) $where["status"]=1;
        $list = M('deal')->order('id desc')->where($where)->limit(1000)->select();

        // var_dump($list);
        $this->assign('list',$list);        
        $this->assign('step',$step);
        $this->assign('cid',$cid);
        $this->display();
    }

    //我的交易
    public function Transreocrds(){
    
        $uid = session('userid');

        //购买
        $where['status'] = 0;
        $where['pay_id'] = array('eq',$uid);
        $where["type"]=2;
        $list = M('deal')->order('id desc')->where($where)->limit(1000)->select();
        $this->assign('list',$list);
        
        //出售
        $where2['status'] = 0;
        $where2['sell_id'] = array('eq',$uid);
        $where2["type"]=1;
        $list2 = M('deal')->order('id desc')->where($where2)->limit(1000)->select();
        
        $this->assign('list2',$list2);

        //交易中
        $where3['status'] = array('in','1,2');
        $where3['sell_id|pay_id'] = array('eq',$uid);
        $list3 = M('deal')->order('id desc')->where($where3)->limit(1000)->select();
        $this->assign('list3',$list3);

        //交易完成
        $where4['status'] = 3;
        $where4['sell_id|pay_id'] = array('eq',$uid);
        $list4 = M('deal')->order('id desc')->where($where4)->limit(1000)->select();
        $this->assign('list4',$list4);

        $this->assign('uid',$uid);   
        $this->display();


    }




    //众筹
    public function Crowds(){
        $step = I('step');
        $html = 'Crowds'.$step;
        $time_n=time();

        if($step >= 1){

            if($step==1){
             $list=M('crowds')->where("open_time<=".$time_n." and status<>2")->order("create_time desc")->find();
            }else{

               $list=M('crowds')->where("open_time<=".$time_n." and status=2")->order("create_time desc")->find(); 
            }
          
            $this->assign('list',$list);
            $this->display('Turntable/'.$html);
        }else{

            $list = M('crowds')->where("status=0 and open_time>".$time_n)->order('id desc')->find();
            $this->assign('list',$list);
            $this->display();
        }
    }



    //金积分购买
  public function Crowds_goumai(){

        //防重复提交
         if(session("gou_last_time1")){
                 if((int)time()-(int)session("gou_last_time1") <10 ){           
                  ajaxReturn('对不起，10秒内不能频繁提交~',0);
                 }
         }

    
        $t = (int)time();
        session("gou_last_time1", $t);
    

        $num = (float)I('num');
        $cid = (int)I('cid','intval',0);
        $dealid = I('dealid','intval',0);
        $dprice = trim(I('dprice'));
        $tprice = trim(I('tprice'));
        $pwd = trim(I('pwd'));
        $uid = session('userid');
        

        $ss1 = 1000;
        $restn= $num-$ss1;

        if($num<0||$tprice<0||$dprice<0)ajaxReturn('非法输入~',0);
        if(!$num|!$tprice)ajaxReturn('交易币的数量不能为空~',0);
        if($restn>0)ajaxReturn('交易币的数量超过最大限制~',0);



        //验证交易密码
        $minepwd = M('user')->where(array('userid' => $uid))->Field('account,mobile,safety_pwd,safety_salt')->find();
        $user_object = D('Home/User');
        $user_info = $user_object->Trans($minepwd['account'], $pwd);

        //自己是否有足够金积分        
            $my_yue = M('store')->where(array('uid'=>$uid))->getField('cangku_num');
            if($tprice> $my_yue){
                ajaxReturn('您当前账户暂无这么多金积分~',0);
            }


        //查询该会员本期已经买了多少Ypay
        $bnums=0;    
        $benqi = M('crowds_detail')->where(array('crowds_id'=>$dealid,'uid'=>$uid))->Field('sum(num) as nums')->find();
        if($benqi) $bnums=$benqi["nums"];

        if($bnums>=$ss1){
                ajaxReturn('本期众筹您已经购买了'.$ss1.'枚，无法继续购买~',0);
            }

        //检查 store表和 coindets 表是否有记录

         $ishas_store_u = M('store')->where(array('uid'=>$uid))->count(1);
        if(!$ishas_store_u)M('store')->add(array('uid'=>$uid,'cangku_num'=>0.0000));   
  

        $issetgetu = M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->count(1);
        if($issetgetu <= 0){
            $coinone['cid'] = $cid;
            $coinone['c_nums'] =0.0000;
            $coinone['c_uid'] = $uid;
            M('ucoins')->add($coinone);
        }
        // else{
        //     M('ucoins')->where(array('c_uid'=>$uid,'cid'=>$cid))->setinc('c_nums',$num);
        // }


        //购买的在NYT的冻结字段里加币的数量、并减该会员金积分    huafei_total字段为冻结数

        $datapay['huafei_total'] = array('exp', 'huafei_total + ' . $num);
        $datapay['cangku_num'] = array('exp', 'cangku_num - ' . $tprice);
        $res1 = M('store')->where(array('uid'=>$uid))->save($datapay);

        //添加金积分记录


        $pay_n = M('store')->where(array('uid' => $uid))->getfield('cangku_num');
        $changenums['now_nums'] = $pay_n;
        $changenums['now_nums_get'] = $pay_n;
        $changenums['is_release'] = 1;
        $changenums['pay_id'] = $uid;
        $changenums['get_id'] = 0;
        $changenums['get_nums'] = $tprice;
        $changenums['get_time'] = time();
        $changenums['get_type'] = 7;
        M('tranmoney')->add($changenums);


        //添加众筹交易记录
        $dealss["crowds_id"]=$dealid;
        $dealss["uid"]=$uid;
        $dealss["create_time"]=time();
        $dealss["num"]=$num;
        $dealss["dprice"]=$dprice;
        $dealss["tprice"]=$tprice;
        $deal_ss = M('crowds_detail')->add($dealss);

        //添加NYT交易记录
        $wbaoss["crowds_id"]=$dealid;
        $wbaoss["create_time"]=time();
        $wbaoss["num"]=$num;
        $wbaoss["uid"]=$uid;
        $wbaoss["dprice"]=$dprice;
        $wbaoss["tprice"]=$tprice;
        $wbaoss["type"]=2;//转入
        $wbao_ss = M('wbao_detail')->add($wbaoss);

        $c_nums = M('ucoins')->where(array('c_uid'=>$uid))->getField('c_nums');
        $ucoins['cid'] = 1;
        $ucoins['c_nums'] =  $c_nums + $num;
        $ucoins_res = M('ucoins')->where(array('c_uid'=>$uid))->save($ucoins);


        if($res1&&$deal_ss&&$wbao_ss&&$ucoins_res){
            ajaxReturn('购买成功',1,"/Turntable/Crowds/step/1");
        }else{
            ajaxReturn('购买失败',0);
        }

    }

    //用户出售
    public function sell_this(){
        $id = (int)I('id');
        $uid = session('userid');
        
        $pay_lingshi = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        $deal = M('deal')->where(array('id'=>$id,'type'=>2,'status'=>0))->find();
        if(!$deal){
            $this->error('该记录不存在');
        }
        if($uid == $deal['pay_id']){
            $this->error('不能购买自己的订单');
        }
        if($pay_lingshi < $deal['tprice']){
            $this->error('购买积分不足');
        }
        //检测是否存在支付宝
        $is_default = M('ubanks')->where(array('user_id'=>$uid,'is_default'=>1))->count();
        if(!$is_default){
            $this->error('请先填写支付宝',U('Growth/Cardinfos'));
        }

        //冻结我的积分
        $payout1['djie_num'] = array('exp', 'djie_num + ' . $deal['tprice']);
        $payout1['total_lingshi'] = array('exp', 'total_lingshi - ' . $deal['tprice']);
        $res_pay3 = M('user')->where(array('userid'=>$uid))->save($payout1);
        
        $data['sell_id'] = $uid;
        $data['status'] = 1;
        $data['expiration_time'] = time() + 2*3600;
        $res = M('deal')->where(array('id'=>$id))->save($data);
        if($res !== false){
            $this->success('出售成功，请尽快打款',U('Turntable/Transreocrds'));
        }else{
            $this->error('出售失败，请重新尝试');
        }
        

    }

    public function purchase(){
        $id = (int)I('id');
        $uid = session('userid');
        
        $deal = M('deal')->where(array('id'=>$id,'type'=>1,'status'=>0))->find();
        if(!$deal){
            $this->error('该记录不存在');
        }
        if($uid == $deal['sell_id']){
            $this->error('不能购买自己的订单');
        }

        //检测是否存在支付宝
        $is_default = M('ubanks')->where(array('user_id'=>$uid,'is_default'=>1))->count();
        if(!$is_default){
            $this->error('请先填写支付宝',U('Growth/Cardinfos'));
        }

        $data['pay_id'] = $uid;
        $data['status'] = 1;
        $data['expiration_time'] = time() + 2*3600;
        $res = M('deal')->where(array('id'=>$id))->save($data);
        if($res !== false){
            $this->success('购买成功，请等待打款',U('Turntable/Transreocrds'));
        }else{
            $this->error('购买失败，请重新尝试');
        }
    }

    //众筹记录
    public function Crowdrecords(){

       $step = I('step');
       $uid = session('userid');
       if($step==1){
        $list=M('wbao_detail')->where("type=3 and uid=".$uid)->order("create_time desc")->select(); //释放记录
       }else{

        $list=M('crowds_detail')->where("uid=".$uid)->order("create_time desc")->select();
        }

        $this->assign('list',$list);
        $this->assign('step',$step);
        $this->display();
    }


    // public function recharge(){
    //     $id = (int)I('id');
    //     $type = (int)I('type');
    //     $uid = session('userid');
    //     //实名认证
    //     $user = M('user')->where(array('userid'=>$uid))->field('id_card,truename')->find();
    //     if(!$user['id_card']&&!$user['truename']){
    //         $this->error('请先进行实名认证');
    //     }
        
    //     if($type == 1){

            
    //         //出售
    //         $deal = M('deal')->where(array('id'=>$id,'type'=>1))->find();
    //         // dump($deal['fee_num']);
    //         if(!$deal){
    //             $this->error('该记录不存在');
    //         }
    //         if($deal['status'] == 0){
    //             if($uid == $deal['sell_id']){
    //                 $this->error('不能购买自己的订单');
    //             }
    //         }

    //         //检测是否存在支付宝
    //         $is_default = M('ubanks')->where(array('user_id'=>$uid,'is_default'=>1))->count();
    //         if(!$is_default){
    //             $this->error('请先填写支付宝',U('Growth/Cardinfos'));
    //         }
    //         if($deal['status'] == 0){
    //             $data['pay_id'] = $uid;
    //             $data['status'] = 1;
    //             $data['expiration_time'] = time() + 2*3600;
    //             $res = M('deal')->where(array('id'=>$id))->save($data);
    //         }
    //         $orders = M('deal')->where(array('id'=>$id))->find();
    //         $get_user = M('user')->where(array('userid'=>$orders['pay_id']))->find();
    //         $pay_user = M('user')->where(array('userid'=>$orders['sell_id']))->find();
    //         $alipay = M('ubanks')->where(array('user_id'=>$orders['sell_id'],'is_default'=>1))->find();
    //         $this->assign('alipay',$alipay);
    //         $this->assign('get_user',$get_user);
    //         $this->assign('pay_user',$pay_user);
    //         $this->assign('orders',$orders);


    //     }elseif($type==2){
    //         //购买
    //         $pay_lingshi = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
    //         $deal = M('deal')->where(array('id'=>$id,'type'=>2))->find();
    //         if(!$deal){
    //             $this->error('该记录不存在');
    //         }
    //         if($deal['status'] == 0){
    //             if($uid == $deal['pay_id']){
    //                 $this->error('不能购买自己的订单');
    //             }
    //         }
    //         //扣除手续费
    //         $vip_grade = M('user')->where(array('userid'=>$uid))->getField('vip_grade');
    //         $tran_fee = M('user_level')->where(array('vip_grade'=>$vip_grade))->getField('tran_fee');
    //         $tran_price = ($deal['tprice']/$deal['dprice']) * $tran_fee / 100;

    //         $deal['tprice'] = $deal['tprice'] + $tran_price;
    //         $num = $deal['num'] + $tran_price;
    //         if($uid == $deal['sell_id']&&$pay_lingshi < $num){
    //             $this->error('购买积分不足');
    //         }
    //         //检测是否存在支付宝
    //         $is_default = M('ubanks')->where(array('user_id'=>$uid,'is_default'=>1))->count();
    //         if(!$is_default){
    //             $this->error('请先填写支付宝',U('Growth/Cardinfos'));
    //         }
    //         $lingshi = ($deal['tprice']-$tran_price) / $deal['dprice'] + $tran_price;
    //         if($deal['status'] == 0){

    //             //冻结我的积分
    //             $payout1['djie_num'] = array('exp', 'djie_num + ' . $lingshi);
    //             $payout1['total_lingshi'] = array('exp', 'total_lingshi - ' . $lingshi);
    //             $res_pay3 = M('user')->where(array('userid'=>$uid))->save($payout1);
                
    //             //添加记录
    //             $total_lingshi = M("user")->where(array('userid'=>$uid))->getField('total_lingshi');
    //             $tm['pay_id'] = $uid;
    //             $tm['get_id'] = 0;
    //             $tm['get_nums'] = $lingshi;
    //             $tm['get_time'] = time();
    //             $tm['get_type'] = 31;
    //             $tm['now_nums'] = $total_lingshi;
    //             M('tranmoney')->add($tm);


    //             $data['sell_id'] = $uid;
    //             $data['status'] = 1;
    //             $data['fee_num'] = $tran_price;
    //             $data['tprice'] = $deal['tprice'];
    //             $data['expiration_time'] = time() + 1254;
    //             $res = M('deal')->where(array('id'=>$id))->save($data);
				
				// $mobile = M('user')->where(array('userid'=>$deal['pay_id']))->getField('mobile');
				// $tpl_id = 167310;
				
				// $this->sendCode($mobile,$tpl_id);
				
    //         }
    //         $orders = M('deal')->where(array('id'=>$id))->find();
    //         $get_user = M('user')->where(array('userid'=>$orders['pay_id']))->find();
    //         $pay_user = M('user')->where(array('userid'=>$orders['sell_id']))->find();
    //         $alipay = M('ubanks')->where(array('user_id'=>$orders['sell_id'],'is_default'=>1))->find();
    //         $this->assign('alipay',$alipay);
    //         $this->assign('get_user',$get_user);
    //         $this->assign('pay_user',$pay_user);
    //         $this->assign('orders',$orders);
    //     }
    //     $recharge_code = getCode();
    //     session('recharge_code',$recharge_code);
    //     $this->assign('recharge_code',$recharge_code);
    //     $this->assign('uid',$uid);
    //     $this->display();
    // }

    public function recharge(){
        $id = I('id');
        $uid = session('userid');

        $res = M('record')->where('record_id='.$id)->find();
        if($uid==$res['in_uid']){
            $userid = $res['out_uid'];
            $show = 0;
        }else{
            $userid = $res['in_uid'];
            $show = 1;
        }
        $res['userinfo'] = M('user')->where(array('userid'=>$res['in_uid']))->field('username,mobile')->find();
        $res['userinfo_out'] = M('user')->where(array('userid'=>$res['out_uid']))->field('username,mobile')->find();
        $userbank = M('ubanks')->where(array('is_default'=>1,'user_id'=>$res['out_uid'],'bank_type'=>2))->find();//bank
        $useralipay = M('ubanks')->where(array('is_default'=>1,'user_id'=>$res['out_uid'],'bank_type'=>1))->find();
        $userwx = M('ubanks')->where(array('is_default'=>1,'user_id'=>$res['out_uid'],'bank_type'=>3))->find();
        $res['userbank'] = $userbank;
        $res['useralipay'] = $useralipay;
        $res['userwx'] = $userwx;
        $res['profit_value'] = $res['profit_value']*100;
        if($res['record_status']==6){
            $res['dakuantime'] = $res['pipeitime']+2*3600;
        }elseif($res['record_status']==7){
            $res['dakuantime'] = $res['getmoney_time']+2*3600;
        }
        $this->assign('res',$res);
        $this->assign('show',$show);
        $this->display();
    }
    public function SearchTran(){
        $uinfo = I('uinfo');
        $where['mobile'] = $uinfo;
        $user = M('user')->where($where)->find();
        $where2['sell_id|pay_id'] = $user['userid'];
        $where2['status'] = 0;
        $list = M('deal')->where($where2)->order('id desc')->limit(25)->select();
        $this->assign('list',$list);
        $this->assign('uinfo',$uinfo);
        $this->display();
    }


    public function Conpay(){
        $id = (int)I('id');
        $uid = session('userid');
        if(IS_AJAX){
            $picname = $_FILES['uploadfile']['name'];
            $picsize = $_FILES['uploadfile']['size'];
            $trid = trim(I('trid'));

            if(!$picname && !$picsize){
                ajaxReturn('请上传打款截图',0);
            }

            $deal = M('record')->where(array('record_id'=>$trid))->field('generate_time,record_status,pipeitime')->find();
            if($deal['record_status']!=6){
                ajaxReturn('订单状态错误',0);
            }
            if((time()-$deal['pipeitime'])>3600*2){
                ajaxReturn('时间过期请重新购买',0);
            }
            if($trid <= 0){
                ajaxReturn('提交失败,请重新提交',0);
            }
            if($_FILES['uploadfile']['tmp_name'])
             {
                $inf=upload();
                $data['trans_img']='/Uploads/payimg/'.$inf['uploadfile']['savepath'].$inf['uploadfile']['savename'];     
             }else{              
                $data['trans_img']='';
             }
            $data['record_status'] = 7;
            $data['getmoney_time'] = time();
            $res = M('record')->where(array('record_id'=>$trid))->save($data);
            if($res){
                ajaxReturn('打款提交成功',1,U('Index/adoption'));
            }else{
                ajaxReturn('打款提交失败',0);
            }
            
        }
        $orders = M('deal')->where(array('id'=>$id))->find();
        $get_user = M('user')->where(array('userid'=>$orders['pay_id']))->find();
        $alipay = M('ubanks')->where(array('user_id'=>$uid,'is_default'=>1))->find();
        $this->assign('alipay',$alipay);
        $this->assign('get_user',$get_user);
        $this->assign('orders',$orders);
        $this->display();
    }

    //确认收款
    public function confirm_receipt(){
        $id = (int)I('id');
        $deal = M('record')->where(array('record_id'=>$id,'status'=>7))->find();
        if(!$deal){
            ajaxReturn('该交易不存在，请刷新重试');
        }
        if(IS_POST){
            $uid = session('userid');
            $id = (int)I('id');
            $deal = M('record')->where(array('record_id'=>$id))->find();
            if(time()-$deal['getmoney_time']>3600*2){
                ajaxReturn('该交易已过期,自动收款');
            }
            if($deal['record_status']!=7){
                ajaxReturn('该订单状态错误');
            }

            M('user')->where(array('userid'=>$deal['in_uid']))->setField('is_vip',2);

            //推荐奖
            $tuijian = tuiguang($deal['in_uid'],$deal['record_price']);
            //团队收益
            $steamsy = steamsy($deal['in_uid'],$deal['record_price']);
            //商城币
            $geo = geo($deal['in_uid'],$deal['record_price'],1);


            $save['complete_time'] = time();
            $save['record_status'] = 4;
            $save['dj_time'] = strtotime($deal['profit_day']."day");
            $res = M('record')->where(array('record_id'=>$id))->save($save);
            if($res !== false){
                ajaxReturn('提交成功',1,U('Index/transfer'));
            }else{
                ajaxReturn('提交失败');
            }
        }
        $this->assign('deal',$deal);
        $this->display();
    }



    //下单页面
    public function first(){
        $id = (int)I('id');
        $userid = session('userid');
        //实名认证
        $user = M('user')->where(array('userid'=>$userid))->field('id_card,truename,total_lingshi')->find();
        if($user['is_real_name'] == 1 && $user['is_pay'] == 1){
            $is_real_name = 1;
        }else{
            $is_real_name = 0;
        }
        //检测是否存在别的单
        $is_deal = M('deal')->where(array('pay_id|sell_id'=>$userid,'status'=>array('in','1,2')))->count();
        if($is_deal){
            $is_buy_sell = 1;
        }else{
            $is_buy_sell = 0;
        }
        $orders = M('deal')->where(array('id'=>$id,'status'=>0))->find();
        if($orders['type'] == 2){
            $vip_grade = M('user')->where(array('userid'=>$userid))->getField('vip_grade');
            $tran_fee = M('user_level')->where(array('vip_grade'=>$vip_grade))->getField('tran_fee');
            $tran_price = ($orders['tprice']/$orders['dprice']) * $tran_fee / 100;

            $orders['tprice'] = $orders['tprice'] + $tran_price;

            $num = $orders['num'] + $tran_price;
            $orders['fee_num'] = $tran_price;
            if($user['total_lingshi'] < $num){
                $is_excee = 1;
            }else{
                $is_excee = 0;
            }
        }else{
            $is_excee = 0;
        }
        if($orders['type'] == 1){
            $alipay_number = M('ubanks')->where(array('user_id'=>$orders['sell_id'],'is_default'=>1))->getField('alipay_number');
            $img = M('ubanks')->where(array('user_id'=>$orders['sell_id'],'is_default'=>1))->getField('img');
            $this->assign('alipay_number',$alipay_number);
            $this->assign('img',$img);
        }

        if($orders['type'] == 1){
            if($userid == $orders['sell_id']){
                $is_user = 1;
            }else{
                $is_user = 0;
            }

        }elseif($orders['type'] == 2){
            if($userid == $orders['pay_id']){
                $is_user = 1;
            }else{
                $is_user = 0;
            }
        }
        $this->assign('is_user',$is_user);
        $this->assign('is_excee',$is_excee);
        $this->assign('is_buy_sell',$is_buy_sell);
        $this->assign('is_real_name',$is_real_name);
        $this->assign('orders',$orders);
        $this->display();
    }


    // 确认收款申述
    public function confirm_represen(){
        $id = (int)I('id');
        $uid = session('userid');

        $deal = M('record')->where(array('out_uid'=>$uid,'record_id'=>$id))->count();
        if(!$deal){
            ajaxReturn('该订单不存在',0);
        }
        $data['record_status'] = 8;
        $res = M('record')->where(array('record_id'=>$id))->save($data);
        if($res){
            ajaxReturn('申诉成功，等待后台审阅',1,U('/Index/transfer'));
        }else{
            ajaxReturn('申诉失败，请重新尝试',0);
        }

    }


    public function sendCode($mobile,$tpl_id){
        /*
            ***聚合数据（JUHE.CN）短信API服务接口PHP请求示例源码
            ***DATE:2015-05-25
        */
        header('content-type:text/html;charset=utf-8');
          
        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
          
        $smsConf = array(
            'key'   => '0c188fd91f70cc0ce3bf9c0eee0cf218', //您申请的APPKEY
            'mobile'    => $mobile, //接受短信的用户手机号码
            'tpl_id'    => $tpl_id, //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'' //您设置的模板变量，根据实际情况修改
        );
         
        $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
         
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                return 0;
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                return 1;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            return 1;
        }
       
    }

   
}