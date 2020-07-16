<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController
{

    public function _initialize(){
        define("FAST_APPKEY", C('appkey'));//你的appkey
        define("SECRET_KEY", C('secret_key'));//你的秘钥

    }
   public function Personal()
    {
        $uid = session('userid');
        $uinfo = M('user')->where(array('userid' => $uid))->field('username,is_dailishang,userid,img_head,use_grade,vip_grade,total_lingshi,total_active,mobile,total_tuiguang')->find();

        //获取用户直推活跃度
        $where['pid'] = $uid;
        $where['vip_grade'] = array('egt',1);
        $total_child_active = M('user')->where($where)->sum('total_active');
        $push_active = 0;

 

        //团队活跃度
        // $team_list = $this->getChild($uid);
		$team_list = M('user')->where(array('pid'=>$uid))->count();

        //判断当前语言
        $lang = LANG_SET;
        if (preg_match("/zh-C/i", $lang))
            $lantype = 1;//简体中文
        if (preg_match("/en/i", $lang))
            $lantype = 2;//English
        $this->assign('team_count',$team_list);		
        $this->assign('uid', $uid);
        $this->assign('uinfo', $uinfo);
        $this->assign('lantype', $lantype);
        $this->assign('push_active',$push_active);
        $this->display();
    }
	public function  setting(){
		$uid = session('userid');
        $settuser = M('user')->where(array('userid' => $uid))->field('mobile')->find();
        $settuname = M('user')->where(array('userid' => $uid))->field('username')->find();
       
        $this->assign('settuname', $settuname);
        $this->assign('settuser', $settuser);
		 $this->display();
	}
    //话费记录
    public function phone_record(){
        $userid = session('userid');
        $list = M('phone_recharge')->where(array('uid'=>$userid))->select();
        $this->assign('list',$list);
        $this->display();
    } 

    public function Imgup()
    {
        $uid = session('userid');
        $picname = $_FILES['uploadfile']['name'];
        $picsize = $_FILES['uploadfile']['size'];
        if ($uid != "") {
            if ($picsize > 2014000) { //限制上传大小
                ajaxReturn('图片大小不能超过2M', 0);
            }
            $type = strstr($picname, '.'); //限制上传格式
            if ($type != ".gif" && $type != ".jpg" && $type != ".png" && $type != ".jpeg") {
                ajaxReturn('图片格式不对', 0);
            }
            $rand = rand(100, 999);
            $pics = uniqid() . $type; //命名图片名称
            //上传路径
            $pic_path = "./Public/home/wap/heads/" . $pics;
            move_uploaded_file($_FILES['uploadfile']['tmp_name'], $pic_path);
        }
        $size = round($picsize / 1024, 2); //转换成kb
        $pic_path = trim($pic_path, '.');
        if ($size) {
            $res = M('user')->where(array('userid' => $uid))->setField('img_head', $pics);
            ajaxReturn($pic_path, 1);
        }
    }

    //实名认证
    public function real_name(){
        $userid = session('userid');
        $user_info = M('user')->where(array('userid'=>$userid))->field('truename,id_card,pid,vip_grade,is_verify')->find();
        $is_exis = M('user_verify')->where(array('uid'=>$userid))->field('is_verify')->order('id desc')->find();
        if($is_exis){
            $this->assign('is_verify',$is_exis['is_verify']);
        }else{
            $this->assign('is_verify',1);
        }
        if(!$user_info['truename'] && !$user_info['id_card'] && $user_info['vip_grade'] == 0){
            $this->assign('is_exis',0);
        }else{
            $this->assign('is_exis',1);
        }
        
        $token_code = getCode();
        session('token_code',$token_code);
        $this->assign('token_code',$token_code);
        $this->assign('user',$user_info);
        $this->display();
    }


    public function user_verify(){
        $uid = session('userid');
        M('user')->where(array('userid'=>$uid))->setField('is_verify',0);
        $this->redirect('/Home/User/real_name');
    }

    public function real_name_form(){
        $userid = session('userid');
        $id_card = trim(I('id_card'));
        $truename = trim(I('truename'));
        $phone = trim(I('phone'));
        $token_code = trim(I('token_code'));
        
        $alipay_number = trim(I('alipay_number'));
        if($id_card == ''){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '身份证号码不能为空';
            exit(json_encode($ajax_arr));
        }
        if(!is_idcard($id_card)){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '身份证号码格式错误';
            exit(json_encode($ajax_arr));
        }


        $is_idcard = M('user')->where(array('id_card'=>$id_card))->count();
        // if($is_idcard){
            // $ajax_arr['code'] = 0;
            // $ajax_arr['msg'] = '该身份证已存在';
            // exit(json_encode($ajax_arr));
        // }
        if($truename == ''){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '真实姓名不能为空';
            exit(json_encode($ajax_arr));
        }

        $is_idcard = M('user')->where(array('truename'=>$truename))->count();
        // if($is_idcard){
            // $ajax_arr['code'] = 0;
            // $ajax_arr['msg'] = '真实姓名已存在';
            // exit(json_encode($ajax_arr));
        // }

        if($phone == ''){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '手机号码不能为空';
            exit(json_encode($ajax_arr));
        }
        if(!validateMobile($phone)){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '手机号码格式错误';
            exit(json_encode($ajax_arr));
        }
        $is_mobile = M('user')->where(array('userid'=>array('neq',$userid),'mobile'=>$phone))->count();
        if($is_mobile){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '手机号码已存在';
            exit(json_encode($ajax_arr));
        }

        // if($alipay_number == ''){
        //     $ajax_arr['code'] = 0;
        //     $ajax_arr['msg'] = '支付宝账号不能为空';
        //     exit(json_encode($ajax_arr));
        // }
        if($token_code&&$token_code != session('token_code')){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = '请勿重复提交';
            exit(json_encode($ajax_arr));
        }
        session('token_code',getCode());
        $pic1 = $_FILES['pic1'];
        $path1 = img_uploading($pic1);
        if(!$path1['status']){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = $path1['res'];
            exit(json_encode($ajax_arr));
        }
        $pic2 = $_FILES['pic2'];
        $path2 = img_uploading($pic2);
        if(!$path2['status']){
            $ajax_arr['code'] = 0;
            $ajax_arr['msg'] = $path2['res'];
            exit(json_encode($ajax_arr));
        }
        // $pic3 = $_FILES['pic3'];
        // $path3 = img_uploading($pic3);
        // if(!$path3['status']){
        //     $ajax_arr['code'] = 0;
        //     $ajax_arr['msg'] = $path3['res'];
        //     exit(json_encode($ajax_arr));
        // }
        $data['uid'] = session('userid');
        $data['id_card'] = $id_card;
        $data['truename'] = $truename;
        $data['phone'] = $phone;
        // $data['alipay_number'] = $alipay_number;
        $data['pic1'] = $path1['res'];
        $data['pic2'] = $path2['res'];
        // $data['pic3'] = $path3['res'];
        $data['is_verify'] = 0;
        $res = M('user_verify')->add($data);

        M('user')->where(array('userid'=>$userid))->setField('is_real_name',1);
        // $arr['id_card'] = $id_card;
        // $arr['truename'] = $truename;
        // $arr['vip_grade'] = 1;
        // $res = M('user')->where(array('userid'=>$userid))->save($arr);

        //为上级添加等级
        // $user_level = M('user_level')->where(array('is_real_name'=>1))->field('push_num,vip_grade')->select();
        // $vip_grade = M('user')->where(array('userid'=>$user_info['pid']))->getField('vip_grade');
        // $child_count = M('user')->where(array('pid'=>$user_info['pid'],'vip_grade'=>array('egt',1)))->count();
        
        // foreach($user_level as $v){
        //     if($child_count >= $v['push_num']){
        //         M('user')->where(array('userid'=>$user_info['pid']))->setField('vip_grade',$v['vip_grade']);
        //     }
        // }
        if($res){
            $ajax_arr['code'] = 1;
            $ajax_arr['msg'] = '提交实名认证成功';
            $is_pay = M('user')->where(array('userid'=>$userid))->getField('is_pay');
        
            // if($is_pay==0){
                // $user_pay = M('user_pay')->where(array('uid'=>$userid,'overdue_time'=>array('gt',time())))->order('id desc')->find();
                // $paydata=array();
                // if(!isset($user_pay)){
                    // $paydata['uid'] = $userid;//支付用户id
                    // $paydata['order_no'] = date('YmdHis',time()).getCode();//订单号
                    // $paydata['total_fee'] = 1;//金额
                    // $paydata['param'] = "";//其他参数
                    // $paydata['me_back_url'] = C("return_url");//支付成功后跳转
                    // $paydata['notify_url'] = C('notify_url');//支付成功后异步回调
                    // $paydata['overdue_time'] = time() + 4 * 60;
                    // M('user_pay')->add($paydata);
                // }else{
                    // $paydata['uid'] = $user_pay['uid'];//支付用户id
                    // $paydata['order_no'] = $user_pay['order_no'];//订单号
                    // $paydata['total_fee'] = $user_pay['total_fee'];//金额
                    // $paydata['param'] = "";//其他参数
                    // $paydata['me_back_url'] = C("return_url");//支付成功后跳转
                    // $paydata['notify_url'] = C('notify_url');//支付成功后异步回调
                // }
               
                
    
                // $geturl=fastpay_order($paydata);//获取支付链接
    
                // // exit("<meta http-equiv='Refresh' content='0;URL={$geturl}'>");
            // }
            // $ajax_arr['data'] = $geturl;
            $ajax_arr['url'] = U('User/Personal');
            exit(json_encode($ajax_arr));
        }else{
            $ajax_arr['code'] = 1;
            $ajax_arr['msg'] = '提交实名认证失败';
            exit(json_encode($ajax_arr));
        }
    }



    //用户等级
    public function userlevel(){
        $userid = session('userid');
        $tran_fee = M('user u')->join('ysk_user_level ul ON u.vip_grade=ul.vip_grade')->where(array('u.userid'=>$userid))->getField('ul.tran_fee');
        $list = M('user_level')->select();
        $this->assign('tran_fee',$tran_fee);
        $this->assign('list',$list);
        $this->display();
    }


    // 用户星级达人
    public function startalent(){
        $uid = session('userid');
        $list = M('user_star')->select();
        foreach($list as $k => $v){
            if($v['scroll_id']){
                $list[$k]['scroll_title'] = M('scroll')->where(array('id'=>$v['scroll_id']))->getField('title');
            }else{
                $list[$k]['scroll_title'] = '无奖励';
            }
        }
        $user_star = M('user u')->join('ysk_user_star us ON u.user_star_id=us.id')->where(array('u.userid'=>$uid))->field('us.title,us.get_fee')->find();
        $last_star_rewrad = M('tranmoney')->where(array('get_id'=>$uid,'get_type'=>37))->order('id desc')->getField('get_nums');
        if(!$last_star_rewrad){
            $last_star_rewrad = '--';
        }
        if($user_star['title']){
            $this->assign('user_star_title',$user_star['title']);
        }else{
            $this->assign('user_star_title','--');
        }
        if($user_star['get_fee']){
            $this->assign('user_star_fee',$user_star['get_fee']);
        }else{
            $this->assign('user_star_fee','0');
        }
        $this->assign('last_star_rewrad',$last_star_rewrad);
        $this->assign('list',$list);
        $this->display();
    }

    public function imgUps()
    {
        if (IS_AJAX) {
            $uid = session('userid');
            $dataflow = trim(I('dataflow'));
            $base64 = str_replace('data:image/jpeg;base64,', '', $dataflow);
            $img = base64_decode($base64);
            //保存地址
            $imgDir = './Public/home/wap/heads/';
            //要生成的图片名字
            $filename = md5(time() . mt_rand(10, 99)) . ".png"; //新图片名称
            $newFilePath = $imgDir . $filename;
            $res = file_put_contents($newFilePath, $img);//返回的是字节数
            if ($res > 1000) {
                //修改头像
                $res_change = M('user')->where(array('userid' => $uid))->setField('img_head', $filename);
                if ($res_change) {
                    ajaxReturn('头像修改成功', 1);
                } else {
                    ajaxReturn('头像修改失败', 0);
                }
            } else {
                ajaxReturn('头像修改失败', 0);
            }
        }
    }


    public function Setuname()
    {
        $uid = session('userid');
        $uname = M('user')->where(array('userid' => $uid))->getField('username');
        if (IS_AJAX) {
            $uname = trim(I('uname'));
            if ($uname == '') {
                ajaxReturn('请填写姓名', 0);
            } else {
                $res_Save = M('user')->where(array('userid' => $uid))->setField('username', $uname);
                if ($res_Save) {
                    ajaxReturn('昵称修改成功', 1, '/User/Personal');
                } else {
                    ajaxReturn('昵称修改失败', 0, '/User/Personal');
                }
            }
        }
        $this->assign('uname', $uname);
        $this->display();
    }

   public function Mobile()
    {
        $uid = session('userid');
        $uname = M('user')->where(array('userid' => $uid))->getField('mobile');
        // if (IS_AJAX) {
        //     $uname = trim(I('uname'));
        //     if ($uname == '') {
        //         ajaxReturn('请填写姓名', 0);
        //     } else {
        //         $res_Save = M('user')->where(array('userid' => $uid))->setField('username', $uname);
        //         if ($res_Save) {
        //             ajaxReturn('昵称修改成功', 1, '/User/Personal');
        //         } else {
        //             ajaxReturn('昵称修改失败', 0, '/User/Personal');
        //         }
        //     }
        // }
        $this->assign('uname', $uname);
        $this->display();
    }
       

    public function Setpwd()
    {
        $type = trim(I('type'));

        if ($type == 1) {
            $title = '登录密码修改';
        } else {
            $title = '支付密码修改';
        }
        if (IS_AJAX) {
            $user = D('Home/User');
            $user_object = D('Home/User');
            $uid = session('userid');
            $pwd = trim(I('pwd'));
            $pwdrpt = trim(I('pwdrpt'));
            $type = trim(I('pwdtype'));
            if ($pwdrpt == '') {
                ajaxReturn('新密码不能为空哦', 0);
            }
            $account = M('user')->where(array('userid' => $uid))->Field('account,mobile,login_pwd')->find();
            //验证初始密码
            $user_info = $user_object->Savepwd($account['mobile'], $pwd, $type);
            $salt = substr(md5(time()), 0, 3);
            if ($type == 1) {
                //密码加密
                $data['login_pwd'] = $user->pwdMd5($pwdrpt, $salt);
                $data['login_salt'] = $salt;
            } else {
                $data['safety_pwd'] = $user->pwdMd5($pwdrpt, $salt);
                $data['safety_salt'] = $salt;
            }
            $res_Sapwd = M('user')->where(array('userid' => $uid))->save($data);
            if ($res_Sapwd) {
                ajaxReturn('密码修改成功', 1, '/User/Personal');
            } else {
                ajaxReturn('密码修改失败', 0);
            }
        }
        $this->assign('title', $title);
        $this->assign('type', $type);
        $this->display();
    }

    public function News()
    {
        $type = (int)I('type')?(int)I('type'):1;
        $where['type'] = $type;
        $newinfo = M('news')->where($where)->order('id desc')->limit(8)->select();
        $this->assign('newinfo', $newinfo);
        $this->assign('type',$type);
        $this->display();
    }

    public function Newsdetail()
    {
        $nid = I('nid', 'intval', 0);
        $newdets = M('news')->where(array('id' => $nid))->find();
        $this->assign('newdets', $newdets);
        $this->display();
    }

    //个人二维码
    public function Sharecode()
    {
        $time = time();
        $userid = session('userid');

//        $u_ID = M('user')->where(array('userid'=>$userid))->getField('mobile');
        $u_ID = $userid;
        $drpath = './Uploads/Scode';
        $imgma = 'codes' . $userid . '.png1';
        $urel = './Uploads/Scode/' . $imgma;
       if (!file_exists($drpath . '/' . $imgma)) {
            sp_dir_create($drpath);
            vendor("phpqrcode.phpqrcode");
            $phpqrcode = new \QRcode();
            $hurl ="http://".$_SERVER['SERVER_NAME']. U('Login/register/mobile/' . $u_ID);
            $size = "7";
            //$size = "10.10";
            $errorLevel = "L";
            $phpqrcode->png($hurl, $drpath . '/' . $imgma, $errorLevel, $size);

            
            $phpqrcode->scerweima1($hurl,$urel,$hurl);
         
       }
        $aurl = "http://".$_SERVER['SERVER_NAME']. U('Login/register/mobile/' . $u_ID);

        $this->urel = ltrim($urel,".");
        $this->aurl = $aurl;
        $this->display();
    }

    public function Teamdets()
    {
        //查询我的会员
        $uid = session('userid');
        if (IS_POST) {
            $uinfo = trim(I('uinfo'));
            if (!empty($uinfo) && $uinfo != '') {
                $where['userid|mobile'] = array('like', '%' . $uinfo . '%');
                $this->assign('uinfo',$uinfo);
            }
        }
        // $where['pid'] = $uid;
		$where['pid|gid|ggid'] = $uid;
        // $where['vip_grade'] = array('egt',1);
        
        //直推活跃度
        $total_child_active = M('user')->where($where)->sum('total_active');
        $push_active = $total_child_active * 0.07;
		
		// $data = M('user')->where(array('status'=>1))->field('userid,pid')->select();
        //团队活跃度
        // $team_list = $this->getTeamChild($uid,$data);
        
        // foreach($team_list as $v){
            // // $total_team_active += M('user')->where(array('userid'=>$v['userid']))->getField('total_active');
            // if($uid != $v['userid']){
                // $muinfo[] = M('user')->where(array('userid'=>$v['userid']))->field('username,vip_grade,userid,mobile,total_active,reg_date,img_head')->find();
            // }
        // }
		// ->field('username,vip_grade,userid,mobile,total_active,reg_date')
        // $total_team_active = 0;
        // foreach($muinfo as $k => $v){
            // $team_list = $this->getTeamChild($v['userid'],$data);
            // $team_active = 0;
            // foreach($team_list as $val){
                // $team_active += M('user')->where(array('userid'=>$val['userid']))->getField('total_active');
            // }
            // $total_team_active +=$team_active; 
            // $muinfo[$k]['team_active'] = $team_active;
        // }
		
        $muinfo = M('user')->where($where)->order('userid desc')->field('username,vip_grade,userid,mobile,total_active,reg_date,img_head,is_real_name')->select();
		foreach($muinfo as $k => $v){
            $team_list = $this->getTeamChild($v['userid'],$data);
            $team_active = 0;
            foreach($team_list as $val){
                $team_active += M('user')->where(array('userid'=>$val['userid']))->getField('total_active');
            }
            $total_team_active +=$team_active; 
            $muinfo[$k]['team_active'] = $team_active;

            //UserController.class.php
            //收藏中 
            $map['pay_id'] = $v['userid'];
            $map['get_type'] = array('in',array('13','14'));
            $jifen += M('tranmoney')->where($map)->sum('get_nums');//积分消耗
        }

        $this->assign('jifen',$jifen);
		$total_team_active = $total_team_active + $total_child_active;
		$this->assign('total_child_active',$total_child_active);
        $this->assign('total_team_active',$total_team_active);
        $this->assign('push_active',$push_active);
        $this->assign('muinfo', $muinfo);
        $this->display();
    }


    /**
     * [Friends 我的好友]
     */
    public function FriendsData()
    {
        $userid = session('userid');
        $where['pid'] = $userid;
        $where['gid'] = $userid;
        $where['ggid'] = $userid;
        $where['_logic'] = 'or';
        if (IS_AJAX) {
            $p = I('p', '0', 'intval');
            $page = $p * 10;
            $u_info = M('user a')->join('ysk_user_huafei b ON a.userid=b.uid')->field('username as u_name,account as u_zh,pid as u_fuji,gid as u_yeji,ggid as u_yyj,pid_caimi,gid_caimi,ggid_caimi,datestr,uid')->where($where)->limit($page, 10)->order('userid')->select();


            if (empty($u_info)) {
                $u_info = null;
            }

            $this->ajaxReturn($u_info);
        }
    }

    //判断是否自己好友
    private function isfriend($uid, $fid)
    {
        $user = M('user');
        $c_info = $user->where(array('userid' => $fid))->field('pid,gid,ggid')->find();
        $pid = $c_info['pid'];
        $gid = $c_info['gid'];
        $ggid = $c_info['ggid'];

        if ($pid == $uid) { //一级
            $lv = M('config')->where(array('id' => 24))->getField('value');
            $lv = $lv / 100;
            $data['lever'] = 1;
            $data['lv'] = $lv;
            return $data;
        } elseif ($pid == $gid) { //二级
            $lv = M('config')->where(array('id' => 25))->getField('value');
            $lv = $lv / 100;
            $data['lever'] = 2;
            $data['lv'] = $lv;
            return $data;
        } elseif ($pid == $gid) { //三级
            $lv = M('config')->where(array('id' => 35))->getField('value');
            $lv = $lv / 100;
            $data['lever'] = 3;
            $data['lv'] = $lv;
            return $data;
        } else {
            return false;
        }
    }

    //我的身份
    public function identity(){
        $userid = session('userid');
        $star_name = M('user u')->join('ysk_user_star us ON u.user_star_id=us.id')->where(array('u.userid'=>$userid))->getField('us.title');
        if($star_name){
            $this->assign('star_name',$star_name);
        }else{
            $this->assign('star_name','无');
        }
        $this->display();
    }

    //话费充值
    public function prepaidrefill(){
        $uid = session('userid');
        $mobile = M('user')->where(array('userid'=>$uid))->getField('mobile');
        $sell_new_price = M('config')->where(array('name'=>'sell_new_price'))->getField('value');
        $this->assign('sell_new_price',$sell_new_price);
        $this->assign('mobile',$mobile);
        $this->display();
    }

    public function phone_recharge(){
        $uid = session('userid');
        $price_num = (int)I('price_num');
        $mobile_number = trim(I('mobile_number'));
        $total_lingshi = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        if($total_lingshi < $price_num){
            ajaxReturn('您的积分不足',0);
        }
        if($mobile_number == ''){
            ajaxReturn('请输入手机号',0);
        }

        M('user')->where(array('userid'=>$uid))->setDec('total_lingshi',$price_num);

        //添加记录
        $total_lingshi = M('user')->where(array('userid'=>$uid))->getField('total_lingshi');
        $tm['pay_id'] = $uid;
        $tm['get_id'] = 0;
        $tm['get_nums'] = $price_num;
        $tm['get_time'] = time();
        $tm['get_type'] = 28;
        $tm['now_nums'] = $total_lingshi;
        M('tranmoney')->add($tm);

        $phone_arr['uid'] = $uid;
        $phone_arr['phone'] = $mobile_number;
        $phone_arr['price_num'] = $price_num;
        $phone_arr['status'] = 0;
        $phone_arr['time'] = time();
        $res = M('phone_recharge')->add($phone_arr);
        if($res){
            ajaxReturn('提交成功,等待后台审核',1,U('user/Personal'));
        }else{
            ajaxReturn('提交失败,请重新提交',0);
        }
        
    }

    /**
     * 修改密码
     */
    public function updatepassword()
    {
        if (!IS_AJAX)
            return;

        $password_old = I('post.old_pwdt');
        $password = I('post.new_pwd');
        $passwordr = I('post.rep_pwd');
        $two_password = I('post.new_pwdt');
        $two_passwordr = I('post.rep_pwdt');
        if (empty($password_old)) {
            ajaxReturn('请输入登录密码');
            return;
        }
        if ($password != $passwordr) {
            ajaxReturn('两次输入登录密码不一致');
            return;
        }

        if ($two_password != $two_passwordr) {
            ajaxReturn('两次输入交易密码不一致');
        }

        $user = D('User');
        $user->startTrans();
        //验证旧密码
        if (!$user->check_pwd_one($password_old)) {
            ajaxReturn('旧登录密码错误');
        }

        //=============登录密码加密==============
        if ($password) {
            $salt = substr(md5(time()), 0, 3);
            $data['login_salt'] = $salt;
            $data['login_pwd'] = md5(md5(trim($password)) . $salt);
        }

        //=============安全密码加密==============
        if ($two_password) {
            $two_salt = substr(md5(time()), 0, 3);
            $data['safety_salt'] = $two_salt;
            $data['safety_pwd'] = $two_password = md5(md5(trim($two_passwordr)) . $two_salt);
        }
        if (empty($data)) {
            ajaxReturn("请输入要修改的密码");
        }
        $userid = session('userid');
        $where['userid'] = $userid;
        $res = $user->where($where)->save($data);

        if ($res) {
            $user->commit();
            ajaxReturn("修改成功", 1);
        } else {
            $user->rollback();
            ajaxReturn("修改失败");
        }

    }
    //投诉建议
    public function Complaint()
    {
        $uid = session('userid');
        if (IS_POST) {
            $content = I('post.content');
            $data['content'] = $content;
            $data['user_id'] = $uid;
            $data['create_time'] = time();
            $Complaint = M('complaint');
            $result = $Complaint->add($data);
            if($result){
                ajaxReturn("提交成功", 1,'/User/Personal');
            }else{
                ajaxReturn("提交失败");
            }
            exit;
        }
        $this->display();
    }

    //关于我们
    public function Aboutus()
    {
        $this->display();
    }

    //退出登录
    public function Loginout()
    {
        session_destroy();
        $this->redirect('Login/login');
    }
}