<?php

namespace Admin\Controller;

/**
 * 皮肤
 * @author 
 */
class SkinController extends AdminController
{
    /**
     * 皮肤列表
     * @author 
     */
    public function index()
    {
        $list = M('skin')->select();
        $this->assign('list',$list);
        $this->display();
    }


    public function add(){
        if(IS_POST){
            $title = trim(I('title'));
            $sell_num = (float)I('sell_num');
            $lingshi_plus = (int)I('lingshi_plus');
            if($title == ''){
                $this->error('请输入皮肤名称');
            }
            if($sell_num === ''){
                $this->error('请输入购买的积分数量');
            }
            if($lingshi_plus === ''){
                $this->error('请输入用户积分加成');
            }

            $data['title'] = $title;
            $data['sell_num'] = $sell_num;
            $data['lingshi_plus'] = $lingshi_plus;
            $res = M('skin')->add($data);
            if($res){
                $this->success('添加皮肤成功',U('skin/index'));
            }else{
                $this->error('添加皮肤失败');
            }


        }
        $this->display();
    }

    public function edit(){
        if(IS_POST){
            $id = (int)I('id');
            $title = trim(I('title'));
            $sell_num = (float)I('sell_num');
            $lingshi_plus = (int)I('lingshi_plus');
            if($title == ''){
                $this->error('请输入皮肤名称');
            }
            if($sell_num === ''){
                $this->error('请输入购买的积分数量');
            }
            if($lingshi_plus === ''){
                $this->error('请输入用户积分加成');
            }
            $skin_exis = M('skin')->where(array('id'=>$id))->count();
            if(!$skin_exis){
                $this->error('该参数不存在，请重试');
            }
            $data['title'] = $title;
            $data['sell_num'] = $sell_num;
            $data['lingshi_plus'] = $lingshi_plus;
            
            $res = M('skin')->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->success('修改皮肤成功',U('skin/index'));
            }else{
                $this->error('修改皮肤失败');
            }
        }
        $id = (int)I('get.id');
        $skin_exis = M('skin')->where(array('id'=>$id))->count();
        if(!$skin_exis){
            $this->error('该参数不存在，请重试');
        }
        $skin = M('skin')->where(array('id'=>$id))->find();
        $this->assign('skin',$skin);
        $this->display();
    }

    public function setStatus(){
        $id = (int)I('ids');
        $status = I('status');
        if($status != 'resume' && $status != 'forbid'){
            $this->error('状态错误，请刷新重试');
        }
        $skin_exis = M('skin')->where(array('id'=>$id))->count();
        if(!$skin_exis){
            $this->error('该参数不存在，请重试');
        }
        
        if($status == 'resume'){
            // 锁定
            $res = M('skin')->where(array('id'=>$id))->setField('status',1);
            if($res !== false){
                $this->success('解锁成功',U('skin/index'));
            }else{
                $this->error('解锁失败，请重新尝试');
            }
        }elseif($status == 'forbid'){
            //解锁
            $res = M('skin')->where(array('id'=>$id))->setField('status',0);
            if($res !== false){
                $this->success('锁定成功',U('skin/index'));
            }else{
                $this->error('锁定失败，请重新尝试');
            }
        }
        
    }


    public function del(){
        $id = (int)I('ids');
        $skin_exis = M('skin')->where(array('id'=>$id))->count();
        if(!$skin_exis){
            $this->error('该参数不存在，请重试');
        }

        $res = M('skin')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }

    }
    
}
