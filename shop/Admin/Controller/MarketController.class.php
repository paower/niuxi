<?php

namespace Admin\Controller;

/**
 * 市场设置
 * @author 
 */
class MarketController extends AdminController
{
    /**
     * 市场设置列表
     * @author 
     */
    public function index()
    {
        $buy_new_price = M('config')->where(array('name'=>'buy_new_price'))->getField('value');
        $sell_new_price = M('config')->where(array('name'=>'sell_new_price'))->getField('value');
        $this->assign('buy_new_price',$buy_new_price);
        $this->assign('sell_new_price',$sell_new_price);
        $this->display();
    }

    public function save(){
        $buy_new_price = I('buy_new_price');
        $sell_new_price = I('sell_new_price');
        
        if($buy_new_price == ''){
            $this->error('求购当前价格不能为空');
        }

        if($sell_new_price == ''){
            $this->error('出售当前价格不能为空');
        }
        
        M('config')->where(array('name'=>'sell_new_price'))->setField('value',$sell_new_price);
        M('config')->where(array('name'=>'buy_new_price'))->setField('value',$buy_new_price);
        $this->success('设置成功',U('Market/index'));
        
    }

    
}
