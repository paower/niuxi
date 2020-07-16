<?php
namespace Admin\Controller;

use Think\Page;

/**
 * 用户控制器
 * 
 */
class UserController extends AdminController
{


    /**
     * 用户列表
     * 
     */
     public function index()
    {


         // 搜索
        $keyword    = I('keyword', '', 'string');
        $querytype  = I('querytype','userid','string');
        $status     = I('status');
        if($keyword){
            $condition = $keyword ;
            $map[$querytype] = $condition;
        }


         //按日期搜索
        $date=date_query('reg_date');
        if($date){
            $where=$date;
            if(isset($map))
                $map=array_merge($map,$where);
            else
                $map=$where;
        }

        if($level!=''){
            $map['a.level']=$level;
        }

        // 获取所有用户
        $user   = M('user a');
        if(!isset($map)){
            $map=true;
        }


        // //按日期搜索
        // $date=date_query('reg_date');
        // if($date){
        //     $where=$date;
        //     if($map)
        //         $map=array_merge($map,$where).' and sex==0';
        //     else
        //         $map=$where.' and sex==0';
        // }

        // if($status=='0' || $status=='1'){
        //      $map['a.status']=$status;
        // }
        //  //$map=$map.' sex=0';
        // // 获取所有用户
        // $user   = M('user a');

        //========排序=========
        $order_str='a.userid desc';

        //========排序=========
 
        //分页
        $table=$user->join('ysk_store b on a.userid=b.uid','left');
        $p=getpage($table,$map,15);
        $page=$p->show();

        $data_list     = $table
            ->field('a.userid,a.username,a.email,a.yinbi,a.account,a.mobile,a.reg_date,a.status,a.pid,a.total_lingshi,a.total_active,a.total_tuiguang')
            ->where($map)
            ->order($order_str)
            ->select();
       		$yue_sum = 0;
          	$jifen_sum = 0;
       		$count = 0;
       $store =  M('store');
       $count = $user->count();
       $yue_sum = $store->sum('cangku_num');
       $jifen_sum = $store->sum('fengmi_num');
         //取管理员会员列表的权限
        $uids= is_login();
        $hylbs="1,2,3,4,5";
        $auth_id    = M('admin')->where(array('id'=>$uids))->getField('auth_id');
        if($auth_id<>1){
        $auth_id    = M('admin')->where(array('id'=>$uids))->getField('auth_id');
        $hylbs    = M('group')->where(array('auth_id'=>$auth_id))->getField('hylb');

        }
        $hylb=explode(",",$hylbs);
        $this->assign('hylb',$hylb);
        $this->assign('list',$data_list);
        $this->assign('yue_sum',$yue_sum);
       $this->assign('count',$count);
        $this->assign('jifen_sum',$jifen_sum);
        $this->assign('table_data_page',$page);
        $this->display();
    }

    /**
     *
     */
    public function recharge(){
        // 获取所有用户
        $tranmoney   = M('tranmoney t');
        // 搜索
        $querytype  = I('querytype','','string');
        $keyword    = I('keyword', '', 'string');
        if($querytype){
            if($querytype == 1){
                $map['t.get_type'] = array('eq', 11);
            }else{
                $map['t.get_type'] = array('eq', 12);
            }
        }else{
            $map['t.get_type'] = array('in', '11,12');
        }
        if($keyword){
            $map['t.get_id'] = array('eq', $keyword);
        }
        $order_str='t.id desc';
        //分页
        $table=$tranmoney->join('ysk_user u on t.get_id = u.userid','left');
        $p=getpage($table,$map,15);
        $page=$p->show();
        $data_list     = $table
            ->field('u.userid,u.username,u.account,u.mobile,t.get_nums,t.get_time,t.get_type')
            ->where($map)
            ->order($order_str)
            ->select();
      	$yue_add = 0;
      	$yue_red = 0;
      	$jifen_add = 0;
      	$jifen_red = 0;
      	$yue_data = $tranmoney->where(array('get_type'=>11))->select();
      	if(!empty($yue_data)){
        	foreach($yue_data as $k=>$v){
            	if($v['get_nums'] < 0){
                	$yue_red += $v['get_nums'];
                }elseif($v['get_nums'] > 0){
                	$yue_add += $v['get_nums'];
                }
            }
        }
        $jifen_data = $tranmoney->where(array('get_type'=>12))->select();
      	if(!empty($jifen_data)){
        	foreach($jifen_data as $k=>$v){
            	if($v['get_nums'] < 0){
                	$jifen_red += $v['get_nums'];
                }elseif($v['get_nums'] > 0){
                	$jifen_add += $v['get_nums'];
                }
            }
        }
        if(!empty($data_list)){
            foreach ($data_list as $k=>$v){
                if($v['get_type'] == 11){
                    $data_list[$k]['name'] = '余额';
                }else if($v['get_type'] == 12){
                    $data_list[$k]['name'] = '积分';
                }
                if($v['get_nums'] < 0 ){
                    $data_list[$k]['type'] = '减少';
                }else{
                    $data_list[$k]['type'] = '增加';
                }
            }
        }
        $this->assign('yue_add',$yue_add);
      	$this->assign('yue_red',$yue_red);
      	$this->assign('jifen_add',$jifen_add);
      	$this->assign('jifen_red',$jifen_red);
      	$this->assign('list',$data_list);
        $this->assign('table_data_page',$page);
        $this->display();
    }
    public function chongzhi(){
      $id = I('id');
      $res = M('record')->where('record_id='.$id)->find();
      if($res['record_status']==8||$res['record_status']==9){
        $data['complete_time'] = '';
        $data['trans_img'] = null;
        $data['getmoney_time'] = null;
        $data['record_status'] = 2;
        $data['in_uid'] = null;
        $save = M('record')->where('record_id='.$id)->save($data);
        if($save){
          $this->success('重置成功',1);
        }else{
          $this->error('重置失败');
        }
      }else{
        $this->error('订单状态错误');
      }
    }
    /**
     * 新增用户
     * 
     */
    public function add()
    {
        if (IS_POST) {

           $admin_kucun=M('admin_kucun');//平台仓库表
            #查询平台总充值了多少水果
           $kucun_info=$admin_kucun->order('id')->find();
           $less_num=$kucun_info['less_num'];
           $kucun_id=$kucun_info['id'];
           if ($less_num < 300) {
                $this->error('平台库存不足'); 
           }


            // 提交数据
            $user_object = D('User');

            $data        = $user_object->create();
            if(!$data){
                $this->error($user_object->getError());
            }
            $parent=I('post.paccount');
            if(empty($parent)){
                $this->error('上级不能为空');
            }
            $where['account']=$parent;
            $p_info=$user_object->where($where)->field('userid,pid,username,mobile')->find();
            if(empty($p_info)){
                $this->error('上级账号错误或不存在');
            }

            $pid=$p_info['userid']; //上级ID

            $data['pid']=$p_info['userid'];
            $gid=$p_info['pid'];//上上级ID
            if($gid){
                $data['gid']=$gid;
            }

            //登录密码加密
            $salt= substr(md5(time()),0,3);
            $data['login_pwd']=$user_object->pwdMd5($data['login_pwd'],$salt);
            $data['login_salt']=$salt;
            //交易密码加密
            $data['safety_pwd']=$user_object->pwdMd5($data['safety_pwd'],$salt);
            $data['safety_salt']=$salt;

            $user_object->startTrans();
            if ($data) {
                $result = $user_object->add($data);
                if ($result) {
                    $uid=$result;
                    //为新会员创建仓库和土地
                    if(!D('Home/Store')->CreateCangku(300,$result)){
                        $user_object->rollback();
                        $this->error('仓库创建失败');
                    }

                    //判断他直推的人是多少奖励稻草人
                    $count=$user_object->where(array('pid'=>$pid))->count(1); 
                    if($count>=10){

                        if($count>=10 && $count<20){
                          $ren=1;
                        }
                        if($count>=20 && $count<30){
                          $ren=2;
                        }
                        if($count>=30 && $count<40){
                          $ren=3;
                        }
                        if($count>=40){
                          $ren=4;
                        }
                        if($ren){
                          M('user_level')->where(array('uid'=>$pid))->setField('dcr_num',$ren);
                        }
                    }

                    //给推荐人奖励20个种子
                    $table=M('user_seed');
                    $seed_where['uid']=$pid;
                    $count=$table->where($seed_where)->count(1);
                    if($count==0){
                      $data['uid']=$pid;
                      $data['zhongzi_num']=20;
                      $table->where($seed_where)->add($data);
                    }else{
                      $table->where($where)->setInc('zhongzi_num',20);
                    }


                    
                    //添加种子明细
                    $zz['uid']=$pid;
                    $zz['recommond_id']=$uid;
                    $zz['recommond_account']=$data['account'];
                    $zz['recommond_name']=$data['username'].'(后台注册)';
                    $zz['seed_num']=20;
                    $zz['time']=time();
                    $hdzz=M('zhongzijiangli')->data($zz)->add();



                    //减少系统总库存
                    if(!$admin_kucun->where(array('id'=>$kucun_id))->setDec('less_num',300)){
                        $user_object->rollback();
                        $this->error('操作失败');
                    }

                    //把数据记录到流水明细
                     $m_info=session('user_auth');
                     $manage_id=$m_info['uid'];
                     $data['manage_id']=$manage_id;//管理者ID
                     $data['manage_name']=$m_info['username'];
                     $data['uid']=$result; //用户ID
                     $data['guozi_num']=300; //转账数量
                     $data['create_time']=time();
                     $data['before_cangku_num']=0; //转账前仓库数量
                     $data['after_cangku_num']=300; //转账后仓库数量
                     $data['ip']=get_client_ip();
                     $data['type']=1;
                     $data['content']='后台注册会员:'.$data['account'];
                     $data['username']=$data['username'];
                     $data['account']=$data['account'];
                     $jl=M('admin_zhuangz')->data($data)->add();



                    $user_object->commit();
                    $this->success('操作成功', U('index'));
                } else {
                    $user_object->rollback();
                    $this->error('操作失败', $user_object->getError());
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {
               
                $this->display();
        }
    }

    /**
     * 编辑用户
     * 
     */
    public function edit($id)
    {
        if (IS_POST) {
            if(empty($_POST['login_pwd'])){
                unset($_POST['relogin_pwd']);
            }
            if(empty($_POST['safety_pwd'])){
                unset($_POST['resafety_pwd']);
            }


            // 提交数据
            $user_object = D('User');
            $data        = $user_object->create();

            //如果没有密码，去掉密码字段
            if(empty($data['login_pwd']) || trim($data['login_pwd'])==''){
                unset($data['login_pwd']);
            }
            else{
              $salt= substr(md5(time()),0,3);
               $data['login_pwd']=$user_object->pwdMd5($data['login_pwd'],$salt);
               $data['login_salt']=$salt;
            }
            if(empty($data['safety_pwd']) || trim($data['safety_pwd'])==''){
                unset($data['safety_pwd']);
            }
            else{
              $salt= substr(md5(time()),0,3);
               $data['safety_pwd']=$user_object->pwdMd5($data['safety_pwd'],$salt);
               $data['safety_salt']=$salt;
            }

            if(empty($data['quanxian']) ){
                $data['quanxian'] = '';
            }
            else{

              $quanxian= join("-",$data['quanxian']);
               
               $data['quanxian']=$quanxian;
            }


            if ($data) {
             // var_dump($data);die;
                $result = $user_object
                    ->field('userid,account,quanxian,username,mobile,email,safety_pwd,safety_salt,login_pwd,login_salt,sex')
                    ->save($data);
                if ($result) {
                    $this->success('更新成功', U('index'));
                } else {
                    $this->error('更新失败', $user_object->getError());
                }
            } else {
                $this->error($user_object->getError());
            }
        } else {

            // 获取账号信息
            $info = D('User')->find($id);
            unset($info['password']);
            $parent=D('User')->where(array('userid'=>$info['pid']))->getField('account');
            $info['parent']=$parent ? $parent :'无';
            $quanxian=explode("-",$info['quanxian']);
            $this->assign('info',$info);
            $this->assign('quanxian',$quanxian);
            //var_dump($quanxian);die;
            $this->display();
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * 
     */
    public function setStatus($model = CONTROLLER_NAME)
    {
        $ids = I('request.ids');
        if (is_array($ids)) {
            if (in_array('1', $ids)) {
                $this->error('超级管理员不允许操作');
            }
        } else {
            if ($ids === '1') {
                $this->error('超级管理员不允许操作');
            }
        }
        parent::setStatus($model);
    }


 /**
     * 设置会员隐蔽的状态
     * 
     */
    public function setStatus1($model = CONTROLLER_NAME)
    {
        $id =(int)I('request.id');    
        $userid =(int)I('request.userid');    
        
         $user_object = D('User');    
        $result=D('User')->where(array('userid'=>$userid))->setField('yinbi',$id);
        if ($result) {
                    $this->success('更新成功', U('index'));
         }else {
                    $this->error('更新失败', $user_object->getError());
                }
    }



     /**
     * 编辑用户
     * 
     */
    public function AddFruits($id)
    {
        if (IS_POST) {
            $user = M('user'); 
           $dbst=M('store');
           
           $admin_kucun=M('admin_kucun');//平台仓库表
           $uid=I('post.userid',0,'intval');
           $cangku_num=I('post.cangku_num');
           if(empty($cangku_num)){
                $this->error('数量不能为空');
           }
            $opetype=I('post.opetype');

            if($opetype < 1){
                $this->error('请选择操作类型');
            }
            if($opetype == 1){
                $sqlname='total_lingshi';
            }elseif($opetype == 2){
                $sqlname='total_active';
            }elseif($opetype == 3){
				$sqlname='total_tuiguang';
			}
           M()->startTrans();

           $type = (int)I('type');
           if($type == 1){
                //增加
                $res = M('user')->where(array('userid'=>$uid))->setInc($sqlname,$cangku_num);
                if($res !== false){
                    M()->commit();
                    $this->success('增加成功');
                }else{
                    M()->rollback();
                    $this->error('增加失败');
                }
           }elseif($type == 2){
                //减少
                $res = M('user')->where(array('userid'=>$uid))->setDec($sqlname,$cangku_num);
                if($res !== false){
                    M()->commit();
                    $this->success('减少成功');
                }else{
                    M()->rollback();
                    $this->error('减少失败');
                }
           }


        } else {

            // 获取账号信息
            $info = D('User')->field('userid,username,account,total_lingshi,total_active,total_tuiguang')->find($id);
            $this->assign('info',$info);
            $this->display();
        }
    }







    //用户登录
    public function userlogin(){
        $userid=I('userid',0,'intval');
        $user=D('Home/User');
        $info=$user->find($userid);
        if(empty($info)){
            return false;
        }

        $login_id=$user->auto_login($info);
        if($login_id){
            session('in_time',time());
            session('login_from_admin','admin',10800);
            $this->redirect('Home/Index/index');
        }
    }


    //用户与等级
    public function user_level(){
        $list = M('user_level')->order('id asc')->select();
        foreach ($list as $k => $v) {
          $list[$k]['level_title'] = M('user_level')->where(array('id'=>$v['level_id']))->getField('title');
          $list[$k]['scroll_title'] = M('scroll')->where(array('id'=>$v['scroll_id']))->getField('title');
        }
        $this->assign('list',$list);
        $this->display();
    }


    public function user_level_add(){
        if(IS_POST){
            $title = trim(I('title'));
            $is_real_name = (int)trim(I('is_real_name'));
            $push_num = (int)trim(I('push_num'));
            $tran_fee = trim(I('tran_fee'));
            if($title == ''){
                $this->error('等级名称不能为空');
            }
            if($is_real_name != 1 && $is_real_name != 0){
                $this->error('状态错误，请刷新重试');
            }
            if($push_num === ''){
                $this->error('直推人数不能为空');
            }
            // if($tran_fee === ''){
            //     $this->error('手续费不能为空');
            // }
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
            // 上传单个文件 
            $info   =   $upload->uploadOne($_FILES['pic']);
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功 获取上传文件信息
                $img = '/Uploads'.'/'.$info['savepath'].$info['savename'];
            }
            $data['title'] = $title;
            $data['is_real_name'] = $is_real_name;
            $data['push_num'] = $push_num;
            $data['tran_fee'] = $tran_fee;
            $data['img'] = $img;
            $res = M('user_level')->add($data);
            if($res){
                $this->success('用户等级添加成功',U('User/user_level'));
            }else{
                $this->error('用户等级添加失败');
            }
            exit;
        }
        $this->display();
    }

    public function user_level_edit(){
        if(IS_POST){
            $id = (int)I('id');
            $title = trim(I('title'));
            $is_real_name = (int)trim(I('is_real_name'));
            $push_num = (int)trim(I('push_num'));
            // $level_id = (int)trim(I('level_id')); //直推等级
            // $tran_fee = trim(I('tran_fee')); //交易手续费
            // $service_charge = (int)trim(I('service_charge'));
            // $scroll_id = (int)trim(I('scroll_id'));
            // $scroll_num = (int)trim(I('scroll_num'));
            $active_num = (int)trim(I('active_num'));
            $active_jf = (int)trim(I('active_jf'));
            if($title == ''){
                $this->error('等级名称不能为空');
            }
            if($is_real_name != 1 && $is_real_name != 0){
                $this->error('状态错误，请刷新重试');
            }
            if($push_num === ''){
                $this->error('直推人数不能为空');
            }

            // if($tran_fee === ''){
            //     $this->error('手续费不能为空');
            // }
            // $last_img = trim(I('last_img'));
            if($_FILES['pic']['tmp_name'] && $_FILES['pic']['size']){
                
                $path = $_SERVER['DOCUMENT_ROOT'].$last_img;
                if(file_exists($path)){
                    @unlink($path);
                }
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize   =     3145728 ;// 设置附件上传大小
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
                // 上传单个文件 
                $info   =   $upload->uploadOne($_FILES['pic']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                }else{// 上传成功 获取上传文件信息
                    $img = '/Uploads'.'/'.$info['savepath'].$info['savename'];
                }
            }else{
                $img = $last_img;
            }
            $data['title'] = $title;
            $data['is_real_name'] = $is_real_name;
            $data['push_num'] = $push_num;
            $data['tran_fee'] = $tran_fee;
            $data['img'] = $img;
            $data['service_charge'] = $service_charge;
            $data['scroll_id'] = $scroll_id;
            $data['scroll_num'] = I('scroll_num');
            $data['active_num'] = $active_num;
            $data['active_jf'] = $active_jf;
            $data['level_id'] = $level_id;
            $res = M('user_level')->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->success('用户等级修改成功',U('User/user_level'));
            }else{
                $this->error('用户等级修改失败');
            }
            exit;
        }else{
          $id = I('id');
          $user_level = M('user_level')->where(array('id'=>$id))->find();
          $level = M('user_level')->order('id asc')->select();
          $scroll = M('scroll')->where(array('status'=>1))->select();
          $this->assign('level',$level);
          $this->assign('scroll',$scroll);
          $this->assign('user_level',$user_level);
          $this->display();
        }
    }


    public function user_level_del(){
        $id = (int)I('ids');
        $is_user_level = M('user_level')->where(array('id'=>$id))->count();
        if(!$is_user_level){
            $this->error('该参数不存在，请重新尝试');
        }

        $res = M('user_level')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function user_star(){
        $list = M('user_star')->select();
        foreach($list as $k => $v){
            if($v['scroll_id']){
                $list[$k]['scroll_title'] = M('scroll')->where(array('id'=>$v['scroll_id']))->getField('title');
            }else{
                $list[$k]['scroll_title'] = '无奖励';
            }
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function user_star_add(){
        if(IS_POST){
            $title = trim(I('title'));
            $push_num = (int)trim(I('push_num'));
            $team_active = (int)trim(I('team_active'));
            $user_active = (int)trim(I('user_active'));
            $get_fee = (int)trim(I('get_fee'));
            $scroll_id = (int)trim(I('scroll_id'));

            if($title == ''){
                $this->error('星级名称不能为空');
            }
            if($push_num === ''){
                $this->error('有效直推人数不能为空');
            }
            if($team_active === ''){
                $this->error('团队活跃度不能为空');
            }
            if($user_active === ''){
                $this->error('本人活跃度不能为空');
            }
            if($get_fee === ''){
                $this->error('共享全球手续费');
            }

            $data['title'] = $title;
            $data['push_num'] = $push_num;
            $data['team_active'] = $team_active;
            $data['user_active'] = $user_active;
            $data['get_fee'] = $get_fee;
            $data['scroll_id'] = $scroll_id;
            
            $res = M('user_star')->add($data);

            if($res){
                $this->success('添加星级达人成功',U('User/user_star'));
            }else{
                $this->error('添加星级达人失败');
            }
        }
        $scroll = M('scroll')->where(array('status'=>1))->field('id,title')->select();
        $this->assign('scroll',$scroll);
        $this->display();
    }

    public function user_star_edit(){
        if(IS_POST){
            $id = (int)I('id');
            $title = trim(I('title'));
            $push_num = (int)trim(I('push_num'));
            $team_active = (int)trim(I('team_active'));
            $user_active = (int)trim(I('user_active'));
            $get_fee = (int)trim(I('get_fee'));
            $scroll_id = (int)trim(I('scroll_id'));

            if($title == ''){
                $this->error('星级名称不能为空');
            }
            if($push_num === ''){
                $this->error('有效直推人数不能为空');
            }
            if($team_active === ''){
                $this->error('团队活跃度不能为空');
            }
            if($user_active === ''){
                $this->error('本人活跃度不能为空');
            }
            if($get_fee === ''){
                $this->error('共享全球手续费');
            }
            $is_exis = M('user_star')->where(array('id'=>$id))->count();
            if(!$is_exis){
                $this->error('该星级达人不存在');
            }

            $data['title'] = $title;
            $data['push_num'] = $push_num;
            $data['team_active'] = $team_active;
            $data['user_active'] = $user_active;
            $data['get_fee'] = $get_fee;
            $data['scroll_id'] = $scroll_id;
            
            $res = M('user_star')->where(array('id'=>$id))->save($data);

            if($res){
                $this->success('添加星级达人成功',U('User/user_star'));
            }else{
                $this->error('添加星级达人失败');
            }
        }
        $id = (int)I('id');
        $is_exis = M('user_star')->where(array('id'=>$id))->count();
        if(!$is_exis){
            $this->error('该星级达人不存在');
        }
        $star = M('user_star')->where(array('id'=>$id))->find();
        $this->assign('star',$star);
        $scroll = M('scroll')->where(array('status'=>1))->field('id,title')->select();
        $this->assign('scroll',$scroll);
        $this->display();
    }

    // 交易列表
    public function deal(){
      $type = I('querytype');
      $uid = I('keyword');
      if($type){
        $map['record_status'] = $type;
      }
      if($uid){
        $map['out_uid'] = $uid;
      }

      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      if($type || $uid){
        $deal = M('record'); // 实例化User对象
        $count      = $deal->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list = $deal->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('record_id desc')->select();
      }else{
        $deal = M('record'); // 实例化User对象
        $count      = $deal->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $list = $deal->limit($Page->firstRow.','.$Page->listRows)->order('record_id desc')->select();
      }
      $this->assign('show',$show);
      $this->assign('list',$list);
		
  		//各状态数量
  		$status1 = $deal->where(array('record_status'=>1))->count();//待审核
  		$status2 = $deal->where(array('record_status'=>2))->count();//审核通过,待确认转入方
  		$status3 = $deal->where(array('record_status'=>4))->count();//交易完成
  		$status4 = $deal->where(array('record_status'=>array('in','5,6,7')))->count();//交易中
  		$status5 = $deal->where(array('record_status'=>4,'dj_time'=>array('GT',time())))->count();//待解冻
  		$status6 = $deal->where(array('record_status'=>4,'dj_time'=>array('ELT',time())))->count();//已解冻
  		$this->assign(array(
  			'status1' => $status1,
  			'status2' => $status2,
  			'status3' => $status3,
  			'status4' => $status4,
  			'status5' => $status5,
  			'status6' => $status6,
  		));
		
      $this->display();
    }
	
	//解冻
	public function thaw(){
		$id = I('id');
		$data['dj_time'] = time();
		$update = M('record')->where('record_id='.$id)->save($data);
		if($update){
			$this->success('操作成功',1);
		}else{
			$this->error('操作失败');
		}
	}

  //取消
  public function quxiao(){
    $id = I('id');
    $info = M('record')->where("record_id = $id")->find();
    $uid = $info['out_uid'];
    $type = $info['record_type'];
    $zichang = $info['record_price'];
    if($type == 2){
      $is_enough = M('user')->where(array('userid'=>$uid))->getField('total_active');
      $data['get_type'] = 23;
    }elseif($type == 3){
      $is_enough = M('user')->where(array('userid'=>$uid))->getField('total_tuiguang');
      $data['get_type'] = 24;
    }

    //添加退回记录
    $data['get_nums'] = $zichang;
    $data['get_time'] = time();
    $data['now_nums'] = $is_enough+$zichang;
    $data['get_id'] = $uid;
    $res = M('tranmoney')->add($data);
    if($res){
      if($type == 2){
          $res1 = M('user')->where(array('userid'=>$uid))->setInc('total_active',$zichang);
        }else if($type == 3){
          $res1 = M('user')->where(array('userid'=>$uid))->setInc('total_tuiguang',$zichang);
        }
    }
    $res2 = M('record')->where("record_id = $id")->delete();
    if($res && $res1 && $res2){
      $this->success('操作成功',1);
    }else{
      $this->error('操作失败');
    }
  }
	
	//预约列表
	public function book(){
	    $book = M('tranmoney'); // 实例化User对象
	    $count      = $book->where(array('get_type'=>13))->count();// 查询满足要求的总记录数
	    $Page       = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	    $show       = $Page->show();// 分页显示输出
	    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	    $list = $book->where(array('get_type'=>13))->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
	    $this->assign('show',$show);
	    $this->assign('list',$list);
	    $this->display();
	}
	
	
    //交易订单审核通过/不通过

    public function up_record_status(){
      $id = I('id');
      $type['record_status'] = I('type');//2=>通过 3=>不通过
      if($type['record_status']==3){
        $res = M('record')->where('record_id='.$id)->field('record_type,out_uid,record_price')->find();

        if($res['record_type']==2){
          $qianbao = 'total_active';
          $get_type = 23;
        }else{
          $qianbao = 'total_tuiguang';
          $get_type = 24;
        }
        $yue = M('user')->where(array('userid'=>$res['out_uid']))->getField($qianbao);
        $inc = M('user')->where(array('userid'=>$res['out_uid']))->setInc($qianbao,$res['record_price']);
        $datas['get_id'] = $res['out_uid'];
        $datas['get_nums'] = $res['record_price'];
        $datas['get_time'] = time();
        $datas['get_type'] = $get_type;
        $datas['now_nums'] = $yue+$res['record_price'];
        $addtrans = M('tranmoney')->add($datas);

        $update = M('record')->where('record_id='.$id)->delete();
      }else{
        $update = M('record')->where('record_id='.$id)->save($type);
      }
      if($update){
        $this->success('操作成功',1);
      }else{
        $this->error('操作失败');
      }
    }
}
