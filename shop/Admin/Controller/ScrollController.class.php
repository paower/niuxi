<?php

namespace Admin\Controller;

/**
 * 星座
 * @author 
 */
class ScrollController extends AdminController
{
    /**
     * 星座列表
     * @author 
     */
    public function index()
    {
        $list = M('scroll')->order('id asc')->select();
        foreach ($list as $k => $v) {
            $id = $v['id'];
            $num = M('yuyue')->where(array('scroll_id'=>$id))->count();
            $list[$k]['yuyue_num'] = $num;
            $num2 = M('user_scroll')->where(array('scroll_id'=>$id,'status'=>0))->count();
            $list[$k]['finish'] = $num2;
        }
        $this->assign('list',$list);
        $this->display();
    }


    public function add(){
        if(IS_POST){
            $title = trim(I('title'));
            $value_region = trim(I('value_region'));
			$yuyue_time_region = trim(I('yuyue_time_region'));
            $time_region = trim(I('time_region'));
            $book_consume = (float)I('book_consume');
            $rush_consume = (float)I('rush_consume');
            $profit_day = (int)I('profit_day');
            $profit_value = (float)I('profit_value') / 100;
            $feed_consume = (float)I('feed_consume');
            $max_size = (int)I('max_size');
            if($title == ''){
                $this->error('请输入星座名称');
            }
            if($value_region == ''){
                $this->error('请输入价值');
            }
			if($yuyue_time_region == ''){
			    $this->error('请输入预约时间');
			}
            if($time_region == ''){
                $this->error('请输入收藏时间');
            }
            if($book_consume == ''){
                $this->error('请输入预约消耗积分');
            }
            if($rush_consume == ''){
                $this->error('请输入收藏消耗积分');
            }
            if($profit_day == ''){
                $this->error('请输入收益时间');
            }
            if($profit_value == ''){
                $this->error('请输入收益百分比');
            }
            if($feed_consume == ''){
                $this->error('请输入收藏消耗积分');
            }
            if($max_size == ''){
                $this->error('请输入最多使用数量');
            }
            $time_region = explode('-',$time_region);
			$yuyue_time_region = explode('-',$yuyue_time_region);
			
			if($_FILES['scroll_image']['tmp_name']){
			   $inf=$this->upload();
			   $data['scroll_image']=$inf['scroll_image']['savepath'].$inf['scroll_image']['savename'];
			}else{
			   $data['scroll_image']='';
			}
			$pricequjian = explode('-',$value_region);
            $data['start_price'] = $pricequjian[0];
            $data['end_price'] = $pricequjian[1];
			$data['title'] = $title;
            $data['value_region'] = $value_region;
			$data['yuyue_start_time'] = $yuyue_time_region[0];
			$data['yuyue_end_time'] = $yuyue_time_region[1];
			$data['start_time'] = $time_region[0];
			$data['end_time'] = $time_region[1];
            $data['book_consume'] = $book_consume;
            $data['rush_consume'] = $rush_consume;
            $data['profit_day'] = $profit_day;
			$data['profit_value'] = $profit_value;
			$data['feed_consume'] = $feed_consume;
            $data['max_size'] = $max_size;
            
            $res = M('scroll')->add($data);
            if($res){
                $this->success('添加星座成功',U('scroll/index'));
            }else{
                $this->error('添加星座失败');
            }


        }
        $this->display();
    }

    public function edit(){
        if(IS_POST){
            $id = (int)I('id');
            $title = trim(I('title'));
            $value_region =trim(I('value_region'));
			$yuyue_time_region = trim(I('yuyue_time_region'));
            $time_region = trim(I('time_region'));
            $book_consume = (float)I('book_consume');
            $rush_consume = (float)I('rush_consume');
            $profit_day = (int)I('profit_day');
            $profit_value = (float)I('profit_value') / 100;
			$feed_consume = (float)I('feed_consume');
			$max_size = (int)I('max_size');
            if($title == ''){
                $this->error('请输入星座名称');
            }
            if($value_region == ''){
                $this->error('请输入价值');
            }
			if($yuyue_time_region == ''){
			    $this->error('请输入预约时间');
			}
            if($time_region === ''){
                $this->error('请输入收藏时间');
            }
            if($book_consume === ''){
                $this->error('请输入预约消耗积分');
            }
			if($rush_consume === ''){
			    $this->error('请输入收藏消耗积分');
			}
            if($profit_day == ''){
                $this->error('请输入收益时间');
            }
			if($profit_value == ''){
			    $this->error('请输入收益百分比');
			}
			if($feed_consume == ''){
			    $this->error('请输入收藏消耗积分');
			}
            if($max_size == ''){
                $this->error('请输入最多使用数量');
            }
			$time_region = explode('-',$time_region);
			$yuyue_time_region = explode('-',$yuyue_time_region);
			// dump($_FILES);die;
			if($_FILES['scroll_image']['tmp_name']){
			   $inf=$this->upload();
			   $data['scroll_image']=$inf['scroll_image']['savepath'].$inf['scroll_image']['savename'];
			}
            $pricequjian = explode('-',$value_region);
            $data['start_price'] = $pricequjian[0];
            $data['end_price'] = $pricequjian[1];
            $data['title'] = $title;
            $data['value_region'] = $value_region;
			$data['yuyue_start_time'] = $yuyue_time_region[0];
			$data['yuyue_end_time'] = $yuyue_time_region[1];
			$data['start_time'] = $time_region[0];
			$data['end_time'] = $time_region[1];
            $data['book_consume'] = $book_consume;
            $data['rush_consume'] = $rush_consume;
            $data['profit_day'] = $profit_day;
			$data['profit_value'] = $profit_value;
			$data['feed_consume'] = $feed_consume;
            $data['max_size'] = $max_size;
            
            $res = M('scroll')->where(array('id'=>$id))->save($data);
            if($res){
                // $this->success('修改星座成功');
                // echo 'header("Content-type: text/html; charset=utf-8");';
                echo '<script>alert("修改星座成功")</script>';
            }else{
                echo '<script>alert("修改星座失败")</script>';
            }
        }
        $id = (int)I('get.id');
        $scroll_exis = M('scroll')->where(array('id'=>$id))->count();
        if(!$scroll_exis){
            $this->error('该参数不存在，请重试');
        }
        $scroll = M('scroll')->where(array('id'=>$id))->find();
        $this->assign('scroll',$scroll);
        $this->display();
    }

    public function setStatus(){
        $id = (int)I('ids');
        $status = I('status');
        if($status != 'resume' && $status != 'forbid'){
            $this->error('状态错误，请刷新重试');
        }
        $scroll_exis = M('scroll')->where(array('id'=>$id))->count();
        if(!$scroll_exis){
            $this->error('该参数不存在，请重试');
        }
        
        if($status == 'resume'){
            // 锁定
            $res = M('scroll')->where(array('id'=>$id))->setField('status',1);
            if($res !== false){
                $this->success('解锁成功',U('scroll/index'));
            }else{
                $this->error('解锁失败，请重新尝试');
            }
        }elseif($status == 'forbid'){
            //解锁
            $res = M('scroll')->where(array('id'=>$id))->setField('status',0);
            if($res !== false){
                $this->success('锁定成功',U('scroll/index'));
            }else{
                $this->error('锁定失败，请重新尝试');
            }
        }
        
    }


    public function del(){
        $id = (int)I('ids');
        $scroll_exis = M('scroll')->where(array('id'=>$id))->count();
        if(!$scroll_exis){
            $this->error('该参数不存在，请重试');
        }

        $res = M('scroll')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }
    
	/**
	 * 
	 * 
	 * TP3.2 封装图片上传方法
	 * 
	 */
	public function upload(){
	    if(empty($_FILES)){
	        $this->error("请选择上传文件！");
	    }else{
	        $upload = new \Think\Upload();// 实例化上传类
	        $upload->maxSize   = 3145728 ;// 设置附件上传大小
	        $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	        $upload->rootPath  = './Uploads/'; // 设置附件上传根目录
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
}
