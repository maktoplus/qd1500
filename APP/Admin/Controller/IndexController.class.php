<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {

    public function index(){
		
		
		$this->getUserCount();
		$this->getmoneyCount();
		$this->getorderCount();
		$this->getDayCount();

        $this->assign('meta_title', "首页");
        $this->display();
    }

	
	    //获取会员数据统计
    public function getUserCount(){
        $user=D('User');
		
        $user_total=$user->count();
		
        $start=strtotime(date('Y-m-d'));
		
        $end=$start+86400;

        $where="reg_date BETWEEN {$start} AND {$end}";
		
        $user_count=$user->where($where)->count();
			$countmoney = $user->sum('money');
        $this->assign('countmoney', $countmoney);
        $this->assign('user_total', $user_total);
		
        $this->assign('user_count', $user_count);
		
		
    }

    //获取会员数据统计
    public function getDayCount(){
        $user=D('recharge');
        $withdraw=D('withdraw');
        $roborder=D('roborder');
        $somebill=D('somebill');
//        $user_total=$user->count();
        $start=strtotime(date('Y-m-d'));
        $end=$start+86400;
        $where="addtime BETWEEN {$start} AND {$end}";
        $user_count=$user->where("status = 3 AND ".$where)->sum('price'); //充值
        $withdraw_num=$withdraw->where($where)->sum('price'); //提现
        $roborder_num=$roborder->where($where)->sum('price'); //流水
        $running_water=$somebill->where("jl_class = 1 AND ".$where)->sum('num'); //接单奖励
        $total=$somebill->where("jl_class = 2 AND ".$where)->sum('num'); //团队佣金
//        $countmoney = $user->sum('money');
//        $this->assign('countmoney', $countmoney);
//        $this->assign('user_total', $user_total);
        if(empty($user_count)){
            $user_count = 0;
        }
        if(empty($withdraw_num)){
            $withdraw_num = 0;
        }
        if(empty($running_water)){
            $running_water = 0;
        }
        if(empty($total)){
            $total = 0;
        }
        if(empty($roborder_num)){
            $roborder_num = 0;
        }
        $this->assign('running_water', $running_water);
        $this->assign('total', $total);
        $this->assign('day_recharge', $user_count);
        $this->assign('roborder_num', $roborder_num);
        $this->assign('day_withdraw', $withdraw_num);
    }
	
	public function getmoneyCount(){
		$resum = M('recharge')->sum('price');
		$wisum = M('withdraw')->sum('price');
		 $this->assign('wisum', $wisum);
		 $this->assign('resum', $resum);
	}
	
	public function getorderCount(){
		$sucorder_count = M('userrob')->where(array('status'=>2))->count();
		$nollorder_count = M('userrob')->where(array('status'=>1))->count();
		
		$finishorder_count = M('userrob')->where(array('status'=>3))->count();
		$finishorder_money = M('userrob')->where(array('status'=>3))->sum('price');
		
		$sucorder_money = M('userrob')->where(array('status'=>2))->sum('price');
		$dd_ordern_admin = M('roborder')->where(array('status'=>1))->sum('price');
		$dd_orderm_admin = M('roborder')->where(array('status'=>1))->count();
		
		$sumyj = M('somebill')->where(array('jl_class'=>1))->sum('num');
		
		 $this->assign('sumyj', $sumyj);
		 $this->assign('finishorder_count', $finishorder_count);
		 $this->assign('finishorder_money', $finishorder_money);
		 $this->assign('dd_ordern_admin', $dd_ordern_admin);
		 $this->assign('dd_orderm_admin', $dd_orderm_admin);
		 $this->assign('sucorder_money', $sucorder_money);
		 $this->assign('sucorder_count', $sucorder_count);
		 $this->assign('nollorder_count', $nollorder_count);
		

	}




    /**
     * 删除缓存
     */
    public function removeRuntime()
    {
        $file   = new \Util\File();
        $result = $file->del_dir(RUNTIME_PATH);
        if ($result) {
            $this->success("缓存清理成功1");
        } else {
            $this->error("缓存清理失败1");
        }
    }
}