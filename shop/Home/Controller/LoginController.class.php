<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{
    /**
     * 后台登陆
     */
    public function login()
    {
        //判断网站是否关闭
        $close=is_close_site();
        if($close['value']==0){
            $this->assign('message',$close['tip'])->display('closesite');
        }else{
            $this->display();
        }
    }

    public function msglogin()
    {
        //判断网站是否关闭
        $close=is_close_site();
        if($close['value']==0){
            $this->assign('message',$close['tip'])->display('closesite');
        }else{
            $account = session('account');
            $this->assign('account',$account);
            $this->display();
        }
    }

    public function wshm(){
        $userid = I("uid");
        session("userid",$userid);

    }



    //注册好友
    public function register(){
        if(IS_AJAX){
            //接收数据
            $user=D('User');
            $data = $user->create();
            if(!$data){
                ajaxReturn($user->getError(),0);
                return ;
            }

           //验证码
            $getsmscode = I('smscode');
            $smscode = session('smscode');
            $smstime = session('smstime');
            // if(time()-$smstime>300 || $smscode!=$getsmscode){
                // ajaxReturn('验证码错误或已过期',0);
            // }

            //判断仓库
            $store=D('Store');
            $data['account']=$data['mobile'];
            //密码加密
            $salt= substr(md5(time()),0,3);
            $data['login_pwd']=$user->pwdMd5($data['login_pwd'],$salt);
            $data['login_salt']=$salt;


            $data['safety_pwd']=$user->pwdMd5($data['safety_pwd'],$salt);
            $data['safety_salt']=$salt;

            //推荐人
            $pid=$data['pid'];
            $last['userid'] = $pid;
            $p_info=$user->where(array('userid'=>$pid))->field('userid,pid,gid,username,account,mobile,path,deep,vip_grade')->find();
            if(!$p_info){
                ajaxReturn('请输入上级推荐码',0);
            }
           $p_info=$user->field('pid,gid,username,account,mobile,path,deep')->find($pid);
            $gid=$p_info['pid'];//上上级ID
            $ggid=$p_info['gid'];//上上上级ID

            if($gid){
                $data['gid']=$gid;
            }
            if($ggid){
                $data['ggid']=$ggid;
            }

            //拼接路径
            $path=$p_info['path'];
            $deep=$p_info['deep'];
            if(empty($path)){
                $data['path']='-'.$pid.'-';
            }else{
                $data['path']=$path.$pid.'-';
            }
            $data['deep']=$deep+1;
            $data['quanxian'] = '2-5';
            $user->startTrans();//开启事务
            $data['total_lingshi'] = 20;
            $uid=$user->add($data);

            //添加记录
            $userinfoid = M('user')->where(array('account'=>$data['mobile']))->getField('userid');
            $datas['get_id'] = $userinfoid;
            $datas['get_nums'] = 20;
            $datas['get_time'] = time();
            $datas['get_type'] = 21;
            $datas['now_nums'] = 20;
            $adds = M('tranmoney')->add($datas);
            if(!$uid){
                $user->rollback();
                ajaxReturn('注册失败');
            }

            //给上级添加值推人数
            // M('user_level')->where(array('uid'=>$pid))->setInc('children_num',1);


            $jifens= D('config')->where("name='jifens'")->getField("value");
            $jifens= (float)$jifens;
            $rens= D('config')->where("name='rens'")->getField("value");
            $pid_n=M('user')->where(array('pid'=>$pid))->count(1);
            

            //if($pid_n<=$rens && $jifens>0){

              //  if($p_info['vip_grade'] != 0){
             //       $datapay22['fengmi_num'] = array('exp', 'fengmi_num + ' . $jifens);
            //        $res_pay_get = M('store')->where(array('uid' => $pid))->save($datapay22);//推荐一人增加积分

            //        $get_n = M('store')->where(array('uid' => $pid))->getfield('fengmi_num');
          //      }

           //         $datass['pay_id'] = $pid;
           //         $datass['get_id'] = $pid;
           //         $datass['get_nums'] = $jifens;
           //         $datass['now_nums_get'] = $get_n;
          //          $datass['now_nums'] = $get_n;
          //          $datass['is_release'] = 1;
         //           $datass['get_time'] = time();
          //          $datass['get_type'] = 123;
                    //$res_addrs = M('tranmoney')->add($datass);
          //  }




            //给用户添加等级
            // AddUserLevel($pid);
            if($uid){
                $user->commit();

                
                //创建钱包
                $jifen=0;
                $regjifen= D('config')->where("name='regjifen'")->getField("value");//奖励开启才送   
                
                if($regjifen==1){ 
                    $jifen=M('config')->where(array('name'=>'jifen'))->getField('value');
                    $jifen=(float)$jifen;
                }
                $startTime = strtotime(date('Y-m-d'));
                $endTime = strtotime(date('Y-m-d',strtotime('+1 day')));
                $where = 'reg_date >= '.$startTime.' and reg_date <= '.$endTime;
                $nums = M('user')->where($where)->count(1);
                // M('user')->where(array('pid' => $v))->count(1);

                $store = array();
                $store['uid'] = $uid;
                $store['cangku_num'] = 0;

                if($nums <= 500){
                    $store['fengmi_num'] = $jifen;
                }else{
                    $store['fengmi_num'] = 0;
                }

                $update_time = M('config')->where(array('name'=>'add_user'))->getField('update_time');
                $startTime = strtotime(date('Y-m-d',$update_time));
                $endTime = strtotime(date('Y-m-d',$startTime+24*60*60));
                if($update_time >= $endTime){
                    M('config')->where(array('name'=>'add_user'))->setField('value',0);
                }
                
                $store['plant_num'] = 0;
                $store['huafei_total'] = 0;
                M("store")->add($store);
                ajaxReturn('注册成功',1,U('Login/login'));
            }
            else{
                $user->rollback();
                ajaxReturn('注册失败',0);
            }
        }


        $mobile = trim(I('mobile'));
        $parent_account = session("parent_account");
        if(empty($mobile)){
            if($parent_account){
                $mobile = $parent_account;
            }
        }
        $this->assign('mobile',$mobile);
        $this->display();
    }

    //快速登录
    public function quickLogin(){
        if (IS_AJAX) {
            $account = I('account');
            $code = I('code');

            // 验证验证码是否正确
            $user_object = D('Home/User');
            if(!check_sms($code,$account)){
                ajaxReturn('验证码错误或已过期');
            }
            $user_info   = $user_object->Quicklogin($account);
            if (!$user_info) {
                ajaxReturn($user_object->getError(),0);
            }
            // 设置登录状态
            $uid = $user_object->auto_login($user_info);
            // 跳转
            if (0 < $uid && $user_info['userid'] === $uid) {
                session('in_time',time());
                ajaxReturn('登录成功',1,U('Index/index'));
            }else{
                ajaxReturn('签名错误',0);
            }
        }
    }

    public function checkLogin(){
        if (IS_AJAX) {
            $account = I('account');
            $password = I('password');
            // 验证用户名密码是否正确
            $user_object = D('Home/User');
            $user_info   = $user_object->login($account, $password);
            if (!$user_info) {
                ajaxReturn($user_object->getError(),0);
            }
            session('account',$account);



             $user_info   = $user_object->Quicklogin($account);
            if (!$user_info) {
                ajaxReturn($user_object->getError(),0);
            }
            // 设置登录状态
            $uid = $user_object->auto_login($user_info);
            // 跳转
            if (0 < $uid && $user_info['userid'] === $uid) {
                session('in_time',time());
                ajaxReturn('登录成功',1,U('Index/index'));
            }


            //ajaxReturn('请输入短信验证码',1,U('Index/index'));


//            // 设置登录状态
//            $uid = $user_object->auto_login($user_info);
//            // 跳转
//            if (0 < $uid && $user_info['userid'] === $uid) {
//                session('in_time',time());
//               ajaxReturn('登录成功',1,U('Index/index'));
//            }else{
//                ajaxReturn('签名错误',0);
//            }
        }
    }

    /**
     * 注销
     * 
     */
    public function logout()
    {   
        cookie('msg',null);
        session(null);
        $this->redirect('Login/login');
    }

    /**
     * 图片验证码生成，用于登录和注册
     * 
     */
    public function verify()
    {
        set_verify();
    }


    //找回密码
    public function getpsw(){
        
        $this->display();
    }

    public function setpsw(){
        if(!IS_AJAX)
            return ;

        $mobile=I('post.mobile');
        $code=I('post.code');
        $password=I('post.password');
        $reppassword=I('post.passwordmin');
        if(empty($mobile)){
            ajaxReturn('手机号码不能为空');
        }
        if(empty($code)){
            ajaxReturn('验证码不能为空');
        }
        if(empty($password)){
            ajaxReturn('密码不能为空');
        }
        if($password  != $reppassword){
            ajaxReturn('两次输入的密码不一致');
        }

       //验证码
        $smscode = session('smscode');
        $smstime = session('smstime');
        if(time()-$smstime>300 || $smscode!=$code){
            ajaxReturn('验证码错误或已过期',0);
        }

        $user=D('User');
        $mwhere['mobile']=$mobile;
        $userid=$user->where($mwhere)->getField('userid');
        if(empty($userid)){
            ajaxReturn('手机号码错误或不在系统中');
        }

        $where['userid']=$userid;
        //密码加密
        $salt=user_salt();
        $data['login_pwd']=$user->pwdMd5($password,$salt);
        $data['login_salt']=$salt;
        $res=$user->field('login_pwd,login_salt')->where($where)->save($data);
        if($res){
            session('sms_code',null);
            ajaxReturn('修改成功',1,U('Login/logout'));
        }
        else{
            ajaxReturn('修改失败');
        }

    }
    /*找回支付密码*/
    //找回密码
    public function getpswpay(){

        $this->display();
    }

    public function setpswpay(){
        if(!IS_AJAX)
            return ;
        $mobile=I('post.mobile');
        $code=I('post.code');
        $password=I('post.password');
        $reppassword=I('post.passwordmin');
        if(empty($mobile)){
            ajaxReturn('手机号码不能为空');
        }
        if(empty($code)){
            ajaxReturn('验证码不能为空');
        }
        if(empty($password)){
            ajaxReturn('密码不能为空');
        }
        if($password  != $reppassword){
            ajaxReturn('两次输入的密码不一致');
        }

        //验证码
        $smscode = session('smscode');
        $smstime = session('smstime');
        if(time()-$smstime>300 || $smscode!=$code){
            ajaxReturn('验证码错误或已过期',0);
        }

        $user=D('User');
        $mwhere['mobile']=$mobile;
        $userid=$user->where($mwhere)->getField('userid');
        if(empty($userid)){
            ajaxReturn('手机号码错误或不在系统中');
        }

        $where['userid']=$userid;
        //密码加密

        $salt=user_salt();
        $data['safety_pwd']=$user->pwdMd5($password,$salt);
        $data['safety_salt']=$salt;
        $res=$user->field('safety_pwd,safety_salt')->where($where)->save($data);
        if($res){
            session('sms_code',null);
            ajaxReturn('支付密码修改成功',1,U('Index/index'));
        }
        else{
            ajaxReturn('支付密码修改失败');
        }
    }

    /** 
 *  
 * 验证码生成 
 */  
public function verify_c(){  
    $Verify = new \Think\Verify();  
    $Verify->fontSize = 18;  
    $Verify->length   = 4;  
    $Verify->useNoise = false;  
    $Verify->codeSet = '0123456789';  
    $Verify->imageW = 130;  
    $Verify->imageH = 50;  
    //$Verify->expire = 600;  
    $Verify->entry();  
} 
/* 验证码校验 */
public function check_verify($code, $id = '')
{
    $verify = new \Think\Verify();
    $res = $verify->check($code, $id);
    $this->ajaxReturn($res, 'json');
}
    public function sendCodelogin(){
        $mobile=I('post.mobile');
        if(empty($mobile)){
            $mes['status']=0;
            $mes['message']='手机号码不能为空';
            $this->ajaxReturn($mes);
        }
        $where['mobile|userid'] = $mobile;
        $isset = M('user')->where($where)->count(1);
        if($isset < 1){
            $mes['status']=0;
            $mes['message']='手机号码不在系统中';
            $this->ajaxReturn($mes);
        }
        $this->ajaxReturn(Loginmsg($mobile));
    }

    //短信验证码
    public function sendCode(){
        $smstime = session('smstime');
        if(time()-$smstime<60){
            $mes['status'] = 2;
            $mes['message'] = '请勿频繁发送';
            $this->ajaxReturn($mes);
        }
        $mobile = I('mobile');
        if(empty($mobile)){
            $mes['status']=2;
            $mes['message']='手机号码不能为空';
            $this->ajaxReturn($mes);
        } 
        $randStr = str_shuffle('1234567890');  
        $code = substr($randStr,0,6);
        $msg="您的验证码为：".$code."【星座空间】";
        $result = $this->NewSms($mobile,$msg);
        if($result==000){
            session('smscode',$code);
            session('smstime',time());
            // $mes['code'] = $code;
            $mes['status'] = 1;
            $mes['message'] = '验证码发送成功';
            $this->ajaxReturn($mes);
        }
    }

    function NewSms($phone,$msg){
        // $url="http://service.winic.org:8009/sys_port/gateway/index.asp?";
        $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
        $id = '';
        $pwd = '';
        $to = $phone; 
        $content = iconv("UTF-8","GB2312",$msg);
        $rdata = sprintf($data, $id, $pwd, $to, $content);
        
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = substr($result,0,3);
        return $result;
    }


    public function adduser(){
      
        //判断是否开启交易功能
        $return=IsTrading(32);
        if($return['value']==0){
          $this->assign('content',$return['tip'])->display('Close/index');  
          exit();
        }

        $mobile=I('get.mobile');
        $this->assign('mobile',$mobile);
        $this->display();
    }

    public function saveuser(){
        if(IS_AJAX){
            //接收数据
            $user=D('User');
            $data        = $user->create();

            if(!$data){
                ajaxReturn($user->getError(),0);
                return ;
            }

            //判断仓库
            $store=D('Store');
            $data['account']=$data['mobile'];
            //密码加密
            $salt= substr(md5(time()),0,3);
            $data['login_pwd']=$user->pwdMd5($data['login_pwd'],$salt);
            $data['login_salt']=$salt;
            $data['safety_pwd']=$user->pwdMd5($data['safety_pwd'],$salt);
            $data['safety_salt']=$salt;

            //推荐人
            $pid=$data['pid'];
            $p_info=$user->field('pid,gid,username,account,mobile,path,deep')->find($pid);
            $gid=$p_info['pid'];//上上级ID
            $ggid=$p_info['gid'];//上上上级ID
            if($gid){
                $data['gid']=$gid;
            }
            if($ggid){
                $data['ggid']=$ggid;
            }

             //拼接路径
            $path=$p_info['path'];
            $deep=$p_info['deep'];
            if(empty($path)){
              $data['path']='-'.$pid.'-';
            }else{
              $data['path']=$path.$pid.'-';
            }
            $data['deep']=$deep+1;


            $user->startTrans();//开启事务
            $uid=$user->add($data);
            if(!$uid){
                $user->rollback();
                ajaxReturn('注册失败');
            }
            //为新会员创建仓库和土地
            if(!$store->CreateCangku(0,$uid)){
                $user->rollback();
                ajaxReturn('仓库创建失败，请联系管理员',0);
            }
              
            //给上级添加值推人数
            // M('user_level')->where(array('uid'=>$pid))->setInc('children_num',1);
            //给用户添加等级
            // AddUserLevel($pid);

            if($uid){
                $user->commit();
                ajaxReturn('注册成功',1,U('Login/login'));
            }
            else{
                $user->rollback();
                ajaxReturn('注册失败',0);
            }
        }
    }



 //TD每分钟增长任务
    public function Growem()
    {
     

     $config_object = D('Config');
     $growem=$config_object->where("name='growem'")->getField('value');
     $growem=(float)$growem;  
     $suiji=mt_rand()/mt_getrandmax()*$growem;//每十二分钟增长率

        $fp = fopen("open13.txt", "a+");
        fwrite($fp, date("Y-m-d H:i:s") . "增长率：".$suiji."\n");
        


        $ntime=time();
        $zerot=date("Y-m-d");
        $zerotime=strtotime($zerot);
        //获取当天第一个价格
        $TDzprice= D('coindets')->where("coin_addtime>=$zerotime")->order('coin_addtime asc')->getField("coin_price");
        $TDzpricez= $TDzprice*1.1;



        $TD= D('coindets')->where("cid=1")->order('coin_addtime desc')->find();
        $coin_price=$TD["coin_price"];
        $coin_price=$TD["max"];
        $coin_price=$TD["min"];
        $coin_price=$TD["coin_price"];  


        $nowp=$TD["coin_price"]*(1+$suiji*0.01); //现在的价格         


        //每天涨幅不超过10%
        if($nowp<$TDzpricez){
           
                $coinone['cid'] =1;
                $coinone['coin_name'] ="积分";
                $coinone['coin_price'] =$nowp;
                $coinone['max'] =$TD["max"]*(1+$suiji*0.01);
                $coinone['min'] =$TD["min"]*(1+$suiji*0.01);
                $coinone['coin_addtime'] = $ntime;
                M('coindets')->add($coinone);
                fwrite($fp, "现在价格：".$nowp."\n");

        }


             fclose($fp);
//采集


$url1="http://gateio.io/json_svr/query_push/?u=13&c=472008&type=push_main_rates&symbol=USDT_CNY";
$ch1 = curl_init();
curl_setopt($ch1,CURLOPT_URL,$url1);
curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch1,CURLOPT_HEADER,0);
$output1 = curl_exec($ch1);
if($output1 === FALSE ){
    echo "CURL Error:".curl_error($ch1);
}

curl_close($ch1);
$huilv_s=$this->get_between($output1,"sell_rate\":\"","\",\"max_rate");



  $url="http://gateio.io";
        $ch = curl_init();

// 2. 设置选项，包括URL
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
// 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        if($output === FALSE ){
            echo "CURL Error:".curl_error($ch);
        }
// 4. 释放curl句柄
        curl_close($ch);

//var_dump(time());die;
//$content=$this->get_between($output,">ETH</span>","day-updn");
$content1=$this->get_between($output,"list_tbody","ody>");


$content_eth=$this->get_between($content1,">ETH</span>","</tb");
$eth_m=$this->get_between($content_eth,"$","</td><td>$");
$eth_m=$huilv_s*$eth_m;


$content_btc=$this->get_between($content1,">BTC</span>","</tb");
$btc_m=$this->get_between($content_btc,"$","</td><td>$");
$btc_m=$huilv_s*$btc_m;

$content_ltc=file_get_contents("https://gateio.io/trade/LTC_USDT");
$ltc_m=$this->get_between($content_ltc,"<title>$"," LTC/USDT");
$ltc_m=$huilv_s*$ltc_m;

$content_dog=file_get_contents("https://gateio.io/trade/DOGE_USDT");
$dog_m=$this->get_between($content_dog,"<title>$"," DOGE/USDT");
$dog_m=$huilv_s*$dog_m;


 if($btc_m>0){           
                $coinone['cid'] =2;
                $coinone['coin_name'] ="比特币";
                $coinone['coin_price'] =$btc_m;
                $coinone['max'] =$btc_m*1.1;
                $coinone['min'] =$btc_m*0.9;
                $coinone['coin_addtime'] = $ntime;
                M('coindets')->add($coinone);               

        }
 if($ltc_m>0){           
                $coinone['cid'] =3;
                $coinone['coin_name'] ="莱特币";
                $coinone['coin_price'] =$ltc_m;
                $coinone['max'] =$ltc_m*1.1;
                $coinone['min'] =$ltc_m*0.9;
                $coinone['coin_addtime'] = $ntime;
                M('coindets')->add($coinone);               

        }

 if($eth_m>0){           
                $coinone['cid'] =4;
                $coinone['coin_name'] ="以太坊";
                $coinone['coin_price'] =$eth_m;
                $coinone['max'] =$eth_m*1.1;
                $coinone['min'] =$eth_m*0.9;
                $coinone['coin_addtime'] = $ntime;
                M('coindets')->add($coinone);               

        }

 if($dog_m>0){           
                $coinone['cid'] =5;
                $coinone['coin_name'] ="狗狗币";
                $coinone['coin_price'] =$dog_m;
                $coinone['max'] =$dog_m*1.1;
                $coinone['min'] =$dog_m*0.9;
                $coinone['coin_addtime'] = $ntime;
                M('coindets')->add($coinone);               

        }

file_put_contents("1.txt", $content1);
file_put_contents("2.txt", date("Y-m-d H:i:s") ." B:".$btc_m." L:".$ltc_m." E:".$eth_m." D:".$dog_m." 汇率:".$huilv_s);


       
             
    }


public function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start)+strpos($input, $start),(strlen($input) - strpos($input, $end))*(-1));
    return $substr;

}

    //积分释放
    public function Relase()
    {

		$fp = fopen("open12.txt", "a+");
		fwrite($fp, date("Y-m-d H:i:s") . " 当前时间可开奖！\n");
		fclose($fp);

        //基础释放率
        $uinfp = M('user');
        $time = date('Y-m-d');
        $todaystime = strtotime($time);
        $where['releas_rate'] = array('gt', 0);
        $where['is_reward'] = 1;
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $map['releas_time'] = array('elt', $todaystime);

        //今日基础积分释放率
//        $basi = M('config')->where(array('name' => 'sell_fee'))->getField('value');
        $perinfo = $uinfp->where($map)->order('userid desc')->limit(2000)->field('userid,releas_rate,releas_time,is_reward')->select();
        
        if (!empty($perinfo)) {
            foreach ($perinfo as $k => $v) {
                $treauid = $v['userid'];
                $data['releas_rate'] = 0.00;
                $data['releas_time'] = time();
                $data['is_reward'] = 0;
                $data['today_releas'] = $v['releas_rate'];

                $res_get = M('user')->where(array('userid' => $treauid))->save($data);//资产转入积分
            }
        } else {
            echo '今日已经执行完';
        }
    }

    public function Appload(){
        $this->display();
    }
    public function Anzhorload(){
        //判断是否在微信端

            $url='http://www.TDss.com/Public/home/zp/TD.apk';
            //是否为安卓
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                ajaxReturn('IOS请下载苹果版',0);
            }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                    ajaxReturn('安卓端请在浏览器打开下载',0);
                }else{
                    ajaxReturn($url,1);
                }
            }else{
                ajaxReturn($url,1);
            }
//
    }

    // 分发团队会员奖励
    public function getTeamProfit(){
        $form = trim(I('form'));
        if($form != '6*c+WjE'){
            exit();
        }
        $users = M('user')->field('userid,pid,vip_grade')->select();
        
        foreach($users as $v){
            if($v['vip_grade'] >= 2){
                $list[$v['userid']] = $this->getTeamChild($users,$v['userid']);
            }
        }
        foreach($list as $k => $v){

            $get_ids = '';
            foreach($v as $val){
                $get_ids.=$val['userid'].',';
            }
            $get_ids = rtrim($get_ids,',');
            $start_time = strtotime(date('Y-m-d').'-1 day');
            $end_time = strtotime(date('Y-m-d 23:59:59').'-1 day');
            $map['expiration_time'] = array(
                array('egt',$start_time),
                array('elt',$end_time),
            );
            $map['status'] = 3;
            $map['sell_id'] = array('in',$get_ids);
            $deals = M('deal')->where($map)->field('num')->select();
            $total_fee_num = 0;
            foreach($deals as $val){
                $total_fee_num+=$val['num'] * 0.2;
            }
            if($total_fee_num > 0){
                
                $service_charge = M('user')->where(array('userid'=>$k))->getField('service_charge');
                $num = $total_fee_num * $service_charge/100;
                if($num > 0){

                    M('user')->where(array('userid'=>$k))->setInc('total_lingshi',$num);
                    $total_lingshi = M('user')->where(array('userid'=>$k))->getField('total_lingshi');
                    $tm['pay_id'] = 0;
                    $tm['get_id'] = $k;
                    $tm['get_nums'] = $num;
                    $tm['get_time'] = time();
                    $tm['get_type'] = 37;
                    $tm['now_nums'] = $total_lingshi;
                    M('tranmoney')->add($tm);
                }
            }
        }
        
        
    }

    public function pay_notify_url(){
        define("FAST_APPKEY", C('appkey'));//你的appkey
        define("SECRET_KEY", C('secret_key'));//你的秘钥

        if (!function_exists('get_openid')) {
            require $_SERVER['DOCUMENT_ROOT'].'/fastpay/Fast_Cofig.php';
        }
            
        $sign=$_POST['sign_notify'];//获取签名2.07版,2.07以下请使用$sign=$_POST['sign'];
        $check_sign=notify_sign($_POST);
        if($sign!=$check_sign){
            exit("签名失效");
        //签名计算请查看怎么计算签名,或者下载我们的SDK查看
        }
        $uid         = $_POST['uid'];//支付用户
        $total_fee   = $_POST['total_fee'];//实际支付金额（可能会带增加0.01等）
        $pay_title   = $_POST['pay_title'];//标题
        $sign        = $_POST['sign'];//签名
        $order_no    = $_POST['order_no'];//订单号
        $me_pri      = $_POST['me_pri'];//订单的金额,参与签名
        $me_param      = $_POST['me_param'];//其他参数
        //更新数据库
        $arr = array('sign'=>$sign,'param'=>$me_param);
        M('user_pay')->where(array('order_no'=>$order_no,'uid'=>$uid))->save($arr);
        M('user')->where(array('userid'=>$uid))->setField('is_pay',1);
        echo "SUCCESS";
    }

    public function pay_return_url(){
        $this->success('恭喜，支付成功!',U('index/index'));
    }

    private function getTeamChild($data,$pid){
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
}
