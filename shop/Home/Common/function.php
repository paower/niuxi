<?php 

/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $m 模型，引用传递
 * @param $where 查询条件
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
//h后台分页
function getpage(&$m,$where,$pagesize=10){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Think\Page($count,$pagesize);
    $p->lastSuffix=false;
    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    $p->setConfig('prev','上一页');
    $p->setConfig('next','下一页');
    $p->setConfig('last','末页');
    $p->setConfig('first','首页');
    
    $p->parameter=I('get.');

    $m->limit($p->firstRow,$p->listRows);

    return $p;
}

//前台分页

function Fgetpage(&$m,$where,$pagesize=10){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Think\Page($count,$pagesize);
    $p->lastSuffix=false;
    $p->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    $p->setConfig('prev','上一页');
    $p->setConfig('next','下一页');
    $p->setConfig('last','末页');
    $p->setConfig('first','首页');

    $p->parameter=I('get.');

    $m->limit($p->firstRow,$p->listRows);

    return $p;
}

/**
 * 查询直推人数升级
 */
function pidisme($uid){
  $pidnums = M('user')->where(array('pid'=>$uid,'is_real_name'=>1))->count();//直推数
  //$users = M('user')->where(array('pid'=>$uid,'is_real_name'=>1))->select();
  
  $map['pay_id'] = $uid;
  $map['get_type'] = array('in',array('13','14','19'));
  $jifen += M('tranmoney')->where($map)->sum('get_nums');//积分消耗
 
  //$where = "pay_id={$uid} AND get_type=13 OR get_type=14";
  //$jifen = M('tranmoney')->where($where)->sum('get_nums');//积分消耗
  //$wheres = "in_uid={$uid} AND record_status=4 AND is_lin=1";
  //$orders = M('record')->where($wheres)->select();//收益
  //foreach($orders as $keys=>$values){
  	///$pricesum += $values['record_price']*$values['profit_value'];
  //}
  //var_dump($pricesum);die();
  $shouyi = M('user')->where(array('userid'=>$uid))->getField('total_tuiguang');
  $user_level = M('user_level')->order('id desc')->select();
  foreach ($user_level as $k => $v) {
    if($pidnums>=$v['push_num'] && $jifen>=$v['active_jf'] && $shouyi>=$v['active_num']){
      $save = M('user')->where(array('userid'=>$uid))->setField('vip_grade',$v['id']); 
      break;
    }
  }
  return $save;
}

/**
 * 推广收益
 */
function tuiguang($uid,$record_price,$profit_value){
  $userinfo = M('user')->where('userid='.$uid)->field('pid,gid,ggid')->find();

  $getmoney = $record_price*0.08*$profit_value;
  $pidyue =  M('user')->where(array('userid'=>$userinfo['pid']))->field('total_tuiguang,is_real_name,vip_grade')->find();
  if($pidyue['is_real_name']!=0){
    M('user')->where(array('userid'=>$userinfo['pid']))->setInc('total_tuiguang',$getmoney);
    $piddata['get_id'] = $userinfo['pid'];
    $piddata['get_nums'] = $getmoney;
    $piddata['get_time'] = time();
    $piddata['get_type'] = 18;
    $piddata['now_nums'] =  $pidyue['total_tuiguang']+$getmoney;
    $addpid = M('tranmoney')->add($piddata);
  }

  $getmoneys = $record_price*0.03*$profit_value;
  $gidyue =  M('user')->where(array('userid'=>$userinfo['pid']))->field('total_tuiguang,is_real_name,vip_grade')->find();
  if($gidyue['is_real_name']!=0){
    M('user')->where(array('userid'=>$userinfo['gid']))->setInc('total_tuiguang',$getmoney);
    $giddata['get_id'] = $userinfo['gid'];
    $giddata['get_nums'] = $getmoneys;
    $giddata['get_time'] = time();
    $giddata['get_type'] = 18;
    $giddata['now_nums'] =  $gidyue['total_tuiguang']+$getmoneys;
    $addgid = M('tranmoney')->add($giddata);
  }
    
  $getmoneyss = $record_price*0.05*$profit_value;
  $ggidyue =  M('user')->where(array('userid'=>$userinfo['pid']))->field('total_tuiguang,is_real_name,vip_grade')->find();
  if($ggidyue['is_real_name']!=0){
    M('user')->where(array('userid'=>$userinfo['ggid']))->setInc('total_tuiguang',$getmoney);
    $ggiddata['get_id'] = $userinfo['ggid'];
    $ggiddata['get_nums'] = $getmoneyss;
    $ggiddata['get_time'] = time();
    $ggiddata['get_type'] = 18;
    $ggiddata['now_nums'] =  $ggidyue['total_tuiguang']+$getmoneyss;
    $addggid = M('tranmoney')->add($ggiddata);
  }
  return $userinfo;
}

/**
 * 团队收益
 */
function steamsy($uid,$pay_nums,$profit_value){

  $pidpath = M('user')->where(array('userid'=>$uid))->field('path')->find();
  $pidpath = array_filter(explode('-',$pidpath['path']));
  $user_level = M('user_level')->order('id desc')->select();
  $manzu = 0;
  foreach ($pidpath as $key => $row) {
      $jl[$key] = $row[$key];
  }
  array_multisort($jl, SORT_ASC, $pidpath);
  foreach ($pidpath as $k => $v) {
    if($k==0 || $k==1 || $k==2){
      continue; 
    }
    $pidyue = M('user')->where(array('userid'=>$v))->field('total_tuiguang,vip_grade')->find();
    $pidnums = M('user')->where(array('pid'=>$v,'is_real_name'=>1))->count();//直推数
    $where = "pay_id={$v} AND get_type=13 OR get_type=14";
    $users = M('user')->where(array('pid'=>$v,'is_real_name'=>1))->select();
    foreach($users as $kuser=>$vuser){
      $map['pay_id'] = $vuser['userid'];
      $map['get_type'] = array('in',array('13','14'));
      $jifensum += M('tranmoney')->where($map)->sum('get_nums');//积分消耗

      $profit = M('user')->where(array('userid'=>$vuser))->getField('total_tuiguang');//收益

      foreach ($user_level as $ks => $vs) {
        if($jifensum>=$vs['active_jf'] && $profit>=$vs['active_num']){
          $manzu = $manzu+1;
          if($manzu>=$vs['push_num']){
            $getmoney = $vs['scroll_num']*$pay_nums/100*$profit_value;
            M('user')->where(array('userid'=>$v))->setInc('total_tuiguang',$getmoney);
            $piddata['get_id'] = $v;
            $piddata['get_nums'] = $getmoney;
            $piddata['get_time'] = time();
            $piddata['get_type'] = 17;
            $piddata['now_nums'] = $getmoney+$pidyue;
            $addpid = M('tranmoney')->add($piddata);
            break;
          }
        }
      }
    }

    // $wheres = "pay_id={$v} AND get_type=15 OR get_type=16";
    // $shouyi = M('tranmoney')->where($wheres)->sum('get_nums');//收益
    // //$vip_grade = M('user_level')->where(array('id'=>$userinfo['vip_grade']))->field('scroll_num,active_num,active_jf')->find();
    // var_dump($pidnums.'/'.$jifensum.'/'.$shouyi);
    // foreach ($user_level as $ks => $vs) {
    //   if($pidnums>=$vs['push_num'] && $jifensum>=$vs['active_jf'] && $shouyi>=$vs['active_num'] && $vs['id']!=1 && $pidyue['vip_grade']>1){
        
    //     $getmoney = $vs['scroll_num']*$pay_nums/100*$profit_value;
    //     M('user')->where(array('userid'=>$v))->setInc('total_tuiguang',$getmoney);
    //     $piddata['get_id'] = $v;
    //     $piddata['get_nums'] = $getmoney;
    //     $piddata['get_time'] = time();
    //     $piddata['get_type'] = 17;
    //     $piddata['now_nums'] = $getmoney+$pidyue;
    //     $addpid = M('tranmoney')->add($piddata);
    //     break;
    //   }
    // }
  }
  return $addpid;
}
/**
   * 上传图片方法
   * 
   */
function upload(){
      if(empty($_FILES)){
          $this->error("请选择上传文件！");
      }else{
          $upload = new \Think\Upload();// 实例化上传类
          $upload->maxSize   = 3145728 ;// 设置附件上传大小
          $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
          $upload->rootPath  = './Uploads/payimg/'; // 设置附件上传根目录
          $upload->savePath  = ''; // 设置附件上传（子）目录
          // 上传文件
          $inf  =   $upload->upload();
          if(!$inf) {// 上传错误提示错误信息
              $this->error($upload->getError());
          }else{// 上传成功 获取上传文件信息
              return $inf;
          }
      }
  }
//生成唯一订单
function build_order_no()
{
    $no = 'PD' . date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    //检测是否存在
    $db = M('record', 'ysk_');
    $count = $db->where(array('record_no' => $no))->count(1);
    ($count > 0) && $no = build_order_no();
    return $no;
}

//生成唯一订单
function build_wallet_add()
{
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmuvwxyzABCDNOPQRSTUVWXYZ0123456';
    $password = "";
    for ( $i = 0; $i < 34; $i++ )
    {
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    //检测是否存在
    $db = M('user', 'ysk_');
    $count = $db->where(array('wallet_add' => $password))->count(1);
    ($count > 0) && $no = build_wallet_add();
    return $password;
}

/**
* 验证手机号是否正确
* @author 陶
* @param $mobile
*/
function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^1[34578]\d{9}$#', $mobile) ? true : false;
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author jry <##>
 */
function user_login()
{
    return D('Home/user')->user_login();
}

function get_userid(){
	$userid =session('userid');
	return $userid;
}

//交易状态
function SellStatus($value,$id){
	$arr=array(
      0=>"交易中...<a href='javascript:' onclick='quitsell(this)' data='".$id."'   url='".U('Trading/QuitSell')."' style='color:#de1414;'>取消交易</a>",
      1=>"<a href='javascript:' onclick='suresell(this)' data='".$id."'   url='".U('Trading/SureSell')."' style='color:#0000aa;'>确认收款</a>",
      2=>'交易成功',
      3=>'已取消交易',
    );
	return $arr[$value];
}

function BuyStauts($value,$id){
   //0-出售成功 1-买家确认  2-买家确认 3-取消交易
   $arr=array(
      0=>"<a href='javascript:' onclick='surebuy(this)' data='".$id."'   url='".U('Trading/SureBuy')."' style='color:#0000aa'>确认购买</a> ",
      1=>'等待卖家确认收款',
      2=>'交易成功',
      3=>'已取消交易',
    );
  return $arr[$value];
}

/**
 * [caimin_state 判断能否采矿]
 * @param  [type] $fid  [好友ID]
 * @param  [type] $type [description]
 * @return [type]       [description]
 */
function caimin_state($fid,$type=null){
      if(empty($fid)){
        return false;
      }

      $level=I('type');//二代
      if($level=='two'){
        $count=D('User')->where(array('pid'=>get_userid()))->count(1);
        if($count<10){
          $type!=null? $str='<span>不可采矿</span>' : $str=false;
          return $str; 
        }
      }

      $store=M('store');
      $where['uid']=$fid;
      $where['sign_time']=date('Ymd');
      $userid=get_userid();
      $where["caimi_fids"]=array('NOTLIKE','%,'.$userid.',%');
      $count=$store->where($where)->count(1);
      if($count==1){
        $type!=null? $str='<span class="red" data="'.$fid.'"  >采矿</span>' : $str=true;
      }else{
        $type!=null? $str='<span>不可采矿</span>' : $str=false;
      }
      return $str;               
}

//用户等级
function user_level($level){
    $arr=array( 
      0 => '普通用户',
      1 => '青铜农主', 
      2 => '白金农主', 
      3 => '水晶农主', 
      4 => '宝石农主',
      5 => '钻石农主',
      6 => '皇冠农主',
      7 => '金牌代理',
      8 => '平台站长',
      9 => '领袖站长',
      );
    return $arr[$level];
}

function AddUserLevel($uid){
  $where['uid']=$uid;
  //直推人数
  $table=M('user_level');
  $info=$table->where($where)->field('children_num,land_num,user_level')->find();
  $children_count=$info['children_num'];
  $land_count=$info['land_num'];

  if($land_count>=1){
    $level=1;
  }
  if($land_count>=10 && $children_count>=10){
    $level=2;
  }
  if($land_count>=15 && $children_count>=20){
    $level=3;
  }
  if($land_count>=15 && $children_count>=30){
    $level=4;
  }
  if($land_count>=15 && $children_count>=40){
    $level=5;
  }
  if($land_count>=15 && $children_count>=60){
    $level=5;
  }
  //低等级才修改
  if($level && $info['user_level']<$level){
    $table->where($where)->setField('user_level',$level);
  }

}


/**
 * [SearchDate 获取上周的还是时间和结束时间]
 */
function SearchDate(){
        $date=date('Y-m-d');  //当前日期
        $first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $last_start=strtotime("$now_start - 7 days");  //上周开始时间
        $last_end=strtotime("$now_start - 1 days");  //上周结束时间
        //获取上周起始日期
        $arr['week_start'] = $last_start;
        $arr['week_end'] = strtotime($now_start);//本周开始时间,即上周最后时间
        return $arr;
}

function img_uploading($pic,$path_old=null)
{    
    $images_path='./Uploads/';   
    if (!is_dir($images_path)) {
        mkdir($images_path);
    }

    $upload             = new \Think\Upload();// 实例化上传类    
    $upload->maxSize    =     0 ;// 设置附件上传大小    
    $upload->exts       =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
    $upload->saveName   =     'msectime';
    $upload->rootPath   =      $images_path; // 设置上传根目录    // 上传文件     
    $upload->savePath   =      ''; // 设置上传子目录    // 上传文件     
    $info               =   $upload->uploadOne($pic);
    if(!$info)
    {// 上传错误提示错误信息
        $res['status']=0;        
        $res['res']=$upload->getError();
    }
    else
    {   // 上传成功 
        $img_path = $info['savepath'].$info['savename'];
        //上传成功后删除原来的图片
        if($path_old && $img_path)
        {
            unlink('.'.$path_old);
        }
        $res['status']=1;
        $res['res']='/Uploads/'.$img_path;
    }
    return $res;
}

//返回当前的毫秒时间戳和随机数合并的字符串
function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000).randomkeys(3);
    return $msectime;
}





function getCode() {
    return  rand(100000,999999);
}

function randomkeys($length) {
    return  substr(rand(100000,999999),0,$length);
}

function check_code($value,$send_email){
    $time=session('set_time');
    $email=session('user_email');
    $code=session('sms_code');
    if(time() - $time > 600 ||  $code !=  $value  || $code == '' || $email != $send_email ){
       return false;
    }
    return true;
}




 #+++++++判断是否开满地++++++#
 function is_all_land($uid){
    if(empty($uid))
        $uid=session('userid');
    
    $nzusfarm=M('nzusfarm');
    $where['uid']=$uid;
    $where['status']=0;
    $count=$nzusfarm->where($where)->count(1);
    // 已开满
    if($count == 0){
       return true;
    }
    else{ // 如果未开满地
       return false;
    }
 }

#++++++判断是否已经开打+++++++
function no_land(){
      $uid=session('userid');
      $nzusfarm=M('nzusfarm');
      $where['uid']=$uid;
      $where['farm_type']=array('neq',4);
      $where['status']=array('neq',0);
      $count=$nzusfarm->where($where)->count(1);
      // 未开地
      if($count == 0){
         return true;
      }
      else{ //已开地
         return false;
      }
  }


 function get_huafei(){
    $userid=session('userid');
    $where['uid']=$userid;
    $huafei_num=M('user_huafei')->where($where)->getField('huafei_num');
    return $huafei_num;
 }


 function Loginmsg($mobile){
     $mobile = safe_replace($mobile);
     if (empty($mobile)) {
         $mes['status'] = 0;
         $mes['message'] = '手机号码不能为空';
     }

     if (time() > session('set_time') + 60 || session('set_time') == '') {
         session('set_time', time());
         $code = getCode();
         $sms_code = sha1(md5(trim($code) . trim($mobile)));
         session('sms_code', $sms_code);
         //发送短信
//        $content="您本次的验证码为".$code."，请在5分钟内完成验证，验证码打死也不要告诉别人哦！";//要发送的短信内容
         $where['mobile|userid'] = $mobile;
         $user_mobile = M('user')->where($where)->getField('mobile');
         $res = newMsg($user_mobile,$code);
         if ($res == 0) {
             $mes['status'] = 1;
             $mes['message'] = '短信发送成功.(349)';
             return $mes;
         } else {
             $mes['status'] = 0;
             $mes['message'] = '短信发送失败.(352)';
             return $mes;
         }
     } else {
         $msgtime = session('set_time') + 60 - time();
         $data = $msgtime . '秒之后再试';
         $mes['status'] = 0;
         $mes['message'] = $data;
         return $mes;
     }
 }


// 发送短信验证
function sendMsg($mobile)
{
    $mobile = safe_replace($mobile);
    if (empty($mobile)) {
        $mes['status'] = 0;
        $mes['message'] = '手机号码不能为空';
    }

    if (time() > session('set_time') + 60 || session('set_time') == '') {
        session('set_time', time());
        $user_mobile = $mobile;
        $code = getCode();
        $sms_code = sha1(md5(trim($code) . trim($mobile)));
        session('sms_code', $sms_code);
        //发送短信
        //$content="您本次的验证码为".$code."，请在5分钟内完成验证，验证码打死也不要告诉别人哦！";//要发送的短信内容
 //asam sms
        $time_stamp = date('m-d H:i:s');
        $log = "D:\wwwroot\www.0007k.cn\log.txt";
        $fp = fopen($log, "a+");
        fwrite($fp, "function.php->user_mobile->".$time_stamp . "=>" . $user_mobile . "\n\n__");
        fclose($fp);
//asam-end	
        $res = newMsg($user_mobile,$code);
	
		if ($res == 0) {
            $mes['status'] = 1;
            $mes['message'] = '短信发送成功.(386)';
            return $mes;
        } else {
            $mes['status'] = 0;
            $mes['message'] = '短信发送失败.(390)';
            return $mes;
        }
    } else {
        $msgtime = session('set_time') + 60 - time();
        $data = $msgtime . '秒之后再试';
        $mes['status'] = 0;
        $mes['message'] = $data;
        return $mes;
    }
}

// 短信发送接口
function newMsg($mobile,$code) {
    /*
        ***聚合数据（JUHE.CN）短信API服务接口PHP请求示例源码
        ***DATE:2015-05-25
    */
    header('content-type:text/html;charset=utf-8');
      
    $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
      
    $smsConf = array(
        'key'   => '0c188fd91f70cc0ce3bf9c0eee0cf218', //您申请的APPKEY
        'mobile'    => $mobile, //接受短信的用户手机号码
        'tpl_id'    => '167308', //您申请的短信模板ID，根据实际情况修改
        'tpl_value' =>'#code#='.$code //您设置的模板变量，根据实际情况修改
    );
     
    $content = juhecurl($sendUrl,$smsConf,1); //请求发送短信
     
    if($content){
        $result = json_decode($content,true);
        $error_code = $result['error_code'];
        if($error_code == 0){
            //状态为0，说明短信发送成功
            // echo "短信发送成功,短信ID：".$result['result']['sid'];
            return 0;
        }else{
            //状态非0，说明失败
            // $msg = $result['reason'];
            // echo "短信发送失败(".$error_code.")：".$msg;
            return 1;
        }
    }else{
        //返回内容异常，以下可根据业务逻辑自行修改
        // echo "请求发送短信失败";
        return 1;
    }
    
    if($result == 000){
        $mes = 0;
    }else{
        $mes = 1;
    }
	
    return $mes;
}

/**
 * 聚合请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
      return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}


function setmyCode($mobile, $msg)
{
    $url = "http://service.winic.org:8009/sys_port/gateway/index.asp?";
    $data = "id=%s&pwd=%s&to=%s&content=%s&time=";
    $id = 'yxnongchang';
    $pwd = '123456web';
    $to = $mobile;
    $content = iconv("UTF-8", "GB2312", $msg);
    $rdata = sprintf($data, $id, $pwd, $to, $content);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rdata);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = substr($result, 0, 3);
    if ($result == '000') {
        return true;
    } else {
        return false;
    }
}


//验证短信验证码
function check_sms($code, $mobile)
{
    $md5_code = sha1(md5(trim($code) . trim($mobile)));
    $set_time = session('set_time');
    $sms_code = session('sms_code');
    if (time() - $set_time <= 300 && $code != '' && $md5_code == $sms_code) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}


function curlPost($url,$postFields){
    $postFields = json_encode($postFields);
    $ch = curl_init ();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'
        )
    );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt( $ch, CURLOPT_TIMEOUT,10);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec ( $ch );
    if (false == $ret) {
        $result = curl_error(  $ch);
    } else {
        $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
        if (200 != $rsp) {
            $result = "请求状态 ". $rsp . " " . curl_error($ch);
        } else {
            $result = $ret;
        }
    }
    curl_close ( $ch );
    return $result;
}


//是否开启交易
 function IsTrading($id){
    return D('config')->getById($id);
}

function add_seed($num,$uid){

   $table=M('user_seed');
   $where['uid']=$uid;
   $count=$table->where($where)->count(1);
   if($count==0){
      $data['uid']=$uid;
      $data['zhongzi_num']=$num;
      return $table->where($where)->add($data);
   }

  return $table->where($where)->setInc('zhongzi_num',$num);
}

//获取当前用户的父级
function parent_account(){
    $userid=session('userid');
    $user=D('User');
    $pid=$user->where(array('userid'=>$userid))->getField('pid');
    $account=$user->where(array('userid'=>$pid))->getField('account');
    if($account)
        return $account;
    else
        return '无';
}

//数字只显示两位
function Showtwo($nums){
    $nums = floor($nums*100)/100;
    return $nums;
}


function validateMobile($phone){
    if(preg_match("/^1[345678]{1}\d{9}$/",$phone)){
        return true;
    }else{
        echo false;
    }
}


function is_idcard( $id ) 
{ 
  $id = strtoupper($id); 
  $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/"; 
  $arr_split = array(); 
  if(!preg_match($regx, $id)) 
  { 
    return FALSE; 
  } 
  if(15==strlen($id)) //检查15位 
  { 
    $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";
    @preg_match($regx, $id, $arr_split); 
    //检查生日日期是否正确 
    $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4]; 
    if(!strtotime($dtm_birth)) 
    { 
      return FALSE; 
    } else { 
      return TRUE; 
    } 
  }else{ 
    //检查18位 
    $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/"; 
    @preg_match($regx, $id, $arr_split); 
    $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4]; 
    if(!strtotime($dtm_birth)) //检查生日日期是否正确 
    { 
        return FALSE; 
    } 
    else 
    {
        return TRUE; 
    } 
  } 
 
}


// $price = 1;
// $type = 2;
// $orderuid = $userid;       
// $goodsname = "";
// $orderid = date('YmdHis',time()).getCode();
// $token = "KGXGD075C4UJ817S5DV2HW962A30FBZ6";
// $identification = "PSGISOIY6Y5HRUAV";
// $return_url = "http://www.yourdomain.com/return_url.php";
// $notify_url = "http://www.yourdomain.com/notify_url.php";
// $price = $price*100;    //注意：020支付需要的参数单元为分; 
// $key = md5($goodsname. $identification. $notify_url. $orderid. $orderuid. $price. $return_url. $token. $type  );
// $returndata['price'] = $price;     
// $returndata['type'] = $type;
// $returndata['orderuid'] =$orderuid;
// $returndata['goodsname'] = $goodsname;
// $returndata['orderid'] = $orderid;
// $returndata['identification'] = $identification;
// $returndata['notify_url'] = $notify_url;
// $returndata['return_url'] = $return_url;
// $returndata['key'] = $key;

// $formHtml = "<form style='display:none;' id='formpay' name='formpay' method='post' action='https://pay.020zf.com/'>";
// foreach($returndata as $k => $v){
//     $formHtml.="<input name='{$k}' id='goodsname' type='text' value='{$v}' />";
// }
// $formHtml.="<input type='submit' id='submitdemo'></form><script type='text/javascript'>form = document.getElementById('formpay');form.submit();</script>";
// exit($formHtml);