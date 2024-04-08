<?php
namespace Admin\Controller;

use Think\Page;


class RoborderController extends AdminController{

/**
 * 后台添加的待匹配记录
 */
 
   public function index(){
		$account = trim(I('get.keyword'));
		if($account!=''){
			if($account==1){
				$map['class'] = 1;
			}elseif($account==2){
				$map['class'] = 2;	
			}elseif($account==3){
				$map['class'] = 3;	
			}else{
				$map['price'] = $account;
			}
		}else{
			 $map = '';
		}
		
		$userobj = M('roborder');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,10);
		
		 if($account<=3){
			$list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }elseif($account>3){
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }elseif($account==''){
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'info', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();
    }
 
 
 //会员抢单意向列表
public function userrob(){
	
		
		
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['ordernum'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uaccount'] = $account;
			 }
			  $map['status'] =1;
		 }else{
			 $map['status'] =1;
		 }
		
		$userobj =M('userrob');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,10);
		
		 if($coinpx == 1){
			$list = $userobj->where ( $map )->order ( 'umoney desc' )->limit ( $p->firstRow, $p->listRows )->select ();

		 }else{
			 
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

}

//会员抢单成功记录
public function robsucc(){
			
		
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['ordernum'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uaccount'] = $account;
			 }
			  $map['status'] =2;
		 }else{
			 $map['status'] =2;
		 }
		
		$userobj =M('userrob');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,10);
		
		 if($coinpx == 1){
			$list = $userobj->where ( $map )->order ( 'umoney desc' )->limit ( $p->firstRow, $p->listRows )->select ();

		 }else{
			 
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

}


//交易等待订单
public function orderwait(){
	
	
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['ordernum'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uaccount'] = $account;
			 }
			  $map['status'] =2;
			  $map['is_hk'] =0;
		 }else{
			 $map['status'] =2;
			 $map['is_hk'] =0;
		 }
		
		$robobj =M('roborder');
		$count =$robobj->where($map)->count();
		$p = getpagee($count,10);
		
		 if($coinpx == 1){
			$list = $robobj->where ( $map )->order ( 'umoney desc' )->limit ( $p->firstRow, $p->listRows )->select ();

		 }else{
			 
			 $list = $robobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }

		 foreach ($list as $key => $value) {
		 	
		 }

        $config = M('system')->where(array('id'=>1))->find();

		$this->assign('config',$config);
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();
	
}


//交易成功订单
public function ordersucc(){
	
	
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['ordernum'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uaccount'] = $account;
			 }
			  $map['status'] =3;
//			  $map['is_hk'] =2;
		 }else{
			 $map['status'] =3;
//			 $map['is_hk'] =2;
		 }
		$robobj =M('roborder');
		$count =$robobj->where($map)->count();
		$p = getpagee($count,10);
		
		 if($coinpx == 1){
			$list = $robobj->where ( $map )->order ( 'umoney desc' )->limit ( $p->firstRow, $p->listRows )->select ();

		 }else{
			 
			 $list = $robobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }

		 foreach ($list as $key => $value) {
		 	
		 }

        $config = M('system')->where(array('id'=>1))->find();

        $this->assign('config',$config);
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();
	
}






//
public function delnullorder(){
	$id = trim(I('get.id'));
	$re = M('userrob')->where(array('id'=>$id))->delete();
	if($re){
		$this->success('操作成功');exit;
	}else{
		$this->success('操作失败');exit;
	}
}

public function stoporder(){
	$id = trim(intval(I('get.id')));
	if($id > 0){

		$robres = M('userrob')->where(array('id'=>$id))->find();
		$userres = M('user')->where(array('userid'=>$robres['uid']))->find();

		$handlemoney = M('user')->where(array('userid'=>$robres['uid']))->save(array("money"=>$userres["money"] + $userres["d_money"],"d_money" =>0.00));

		$re = M('userrob')->where(array('id'=>$id))->delete();
		if($re && $handlemoney){
			$this->success('操作成功');exit;
		}else{
			$this->success('操作失败');exit;
		}

	}

}

 
 
 

 
 
 
 
 
 
 //添加订单
 public function add(){
	 if($_POST){
		 
		 $date['class'] = trim(I('post.class'));
		 $date['price'] = trim(I('post.price'));
		 $num = trim(I('post.num'));
		 $date['addtime'] = time();
		 $date['status'] = 1;
		 $date['ordernum'] = getordernum();
		 if($num == ''){
			 $num = 1;
		 }
		 
		 if($date['price'] == ''){
			 
			  $this->error('金额不能为空');
		 }

		 
		 for($i = 1; $i <= $num; $i++){
             $date['uname']= $this->generateName();
			 $re = M('roborder')->add($date);
		 }
		 
		 if($re){
			 $this->success('添加成功', U('index')); 
		 }else{
			 $this->error('添加失败');
		 }
		 
		 
	 }else{
		 
		 
		 
		 
		 $this->display(); 
	 }
	
 }
 
 //编辑待匹配订单
 public function edit(){
	 if($_GET){
		 $id = trim(I('get.id'));
		 $olist = M('roborder')->where(array('id'=>$id))->find();
		 if(empty($olist)){
			 $this->error('该订单不存在');
		 }
		 if($olist['status'] != 1){
			 $this->error('该订单已被匹配');
		 }
		 $this->assign('olist',$olist);
		 $this->display();
		 
	 }else{
		$this->error('未知错误'); 
	 }
 }
 
  //删除订单
 public function delorder(){
	 if($_GET){
		 $id = trim(I('get.id'));
		 $olist = M('roborder')->where(array('id'=>$id))->find();
		 if(empty($olist)){
			 $this->error('该订单不存在');
		 }
		 if($olist['status'] != 1){
			 //$this->error('该订单已被匹配');
		 }
		 $re = M('roborder')->where(array('id'=>$id))->delete();
		 if($re){
			 $this->success('删除成功'); 
		 }else{
			 $this->error('删除失败'); 
		 }

	 }else{
		$this->error('未知错误'); 
	 }
 }
  //取消订单
 public function cancel(){
	 if($_GET){
		 $id = trim(I('get.id'));
		 $olist = M('userrob')->where(array('id'=>$id))->find();
		 if(empty($olist)){
			 $this->error('该订单不存在');
		 }

		 $re = M('userrob')->where(array('id'=>$id))->save(array('status'=>4));
		 if($re){
			 $this->success('取消成功'); 
		 }else{
			 $this->error('取消失败'); 
		 }

	 }else{
		$this->error('未知错误'); 
	 }
 }
  //删除订单
 public function delsuccess(){
	 if($_GET){
		 $id = trim(I('get.id'));
		 $olist = M('roborder')->where(array('id'=>$id))->find();
		 if(empty($olist)){
			 $this->error('该订单不存在');
		 }
		 if($olist['status'] != 1){
			 //$this->error('该订单已被匹配');
		 }
		 $re = M('roborder')->where(array('id'=>$id))->delete();
		 if($re){
			 $this->success('删除成功'); 
		 }else{
			 $this->error('删除失败'); 
		 }

	 }else{
		$this->error('未知错误'); 
	 }
 }
 
 public function editup(){
	 
	 if($_POST){
		 
		 $id = trim(I('post.id'));
		 $date['class'] = trim(I('post.class'));
		 $date['price'] = trim(I('post.price'));

		
		 
		 if($date['price'] == ''){
			  $this->error('金额不能为空');
		 }


			 $re = M('roborder')->where(array('id'=>$id))->save($date);

		 if($re){
			 $this->success('修改成功', U('index')); 
		 }else{
			 $this->error('修改失败');
		 }
		 
		 
	 }else{
		 
		 
		$this->error('未知错误'); 
	 }
 }
 
 


//匹配会员发布的空匹配订单
public function putorder(){
	if($_GET){
		$id = trim(I('get.id'));
		$olist = M('userrob')->where(array('id'=>$id))->find();
		$ulist = M('user')->where(array('userid'=>$olist['uid']))->find();
		$clist = M('system')->where(array('id'=>1))->find();
		/********匹配的金额是该会员上传的对应的最小收款金额***********/
		if($ulist['money'] > 0){
			$max_pipeinone = $ulist['money'] * ($clist['qd_cf']  / 100);
		}else{
			$max_pipeinone = 0;
		}
			
		
		$uewm = M('ewm')->where(array('uid'=>$olist['uid'],'ewm_class'=>$olist['class'],'ewm_price'=>array('elt',$max_pipeinone)))->order('ewm_price asc')->select();		
		if(!$uewm){
			$this->error('匹配订单生成成功');exit;
		}
		
		
		$price = $uewm[array_rand($uewm)]['ewm_price'];

		
		$data['class'] = $olist['class'];
		$data['price'] = $price;
		$data['addtime'] = time();
		$data['status'] = 2;
		$data['uid'] = $olist['uid'];
		$data['uname'] = $olist['uname'];
		$data['umoney'] = $olist['umoney'];
		$data['pipeitime'] = time();
		$data['ordernum'] = $olist['ordernum'];
		
		$reid = M('roborder')->add($data);
		if($reid){
			
			$save['price'] = $price;
			$save['ppid'] = $reid;
			$save['status'] = 2;
			$save['price'] = $price;
			$save['pipeitime'] = time();
			$save['yjjc'] = $clist['yjjc'];
			$re = M('userrob')->where(array('id'=>$id))->save($save);
			
			if($re){
				
				$this->success('匹配订单生成成功');exit;
				
			}else{
				$this->error('匹配订单生成失败');exit;
			}
		}else{
			$this->error('匹配订单生成失败');exit;
		}

	}else{
		$this->error('非法操作');exit;
	}
}


//游戏参数设置页面
public function asystem(){
	if($_POST){
		$data['user_first_num'] = json_encode(I('post.user_first_num')); // 直推总数
		$data['user_num'] = json_encode(I('post.user_num')); // 伞下总数
		$data['user_money'] = json_encode(I('post.user_money')); // 等级的佣金加成
		$data['qd_time'] = trim(I('post.qd_time'));
		$data['qd_num'] = trim(I('post.qd_num'));
		$data['user_profit'] = json_encode(I('post.user_profit/a'));;
		$data['total_profit'] = json_encode(I('post.total_profit/a'));
		$data['qd_cf'] = trim(I('post.qd_cf'));
		$data['qd_nd'] = trim(I('post.qd_nd'));
		$data['qd_wxyj'] = trim(I('post.qd_wxyj'));
		$data['qd_zfbyj'] = trim(I('post.qd_zfbyj'));
		$data['qd_bkyj'] = trim(I('post.qd_bkyj'));
		$data['qd_ndtime'] = trim(I('post.qd_ndtime'));
		$data['qd_yjjc'] = trim(I('post.qd_yjjc'));
		$data['qd_minmoney'] = trim(I('post.qd_minmoney'));
		$data['min_recharge'] = trim(I('post.min_recharge'));
		$data['mix_withdraw'] = trim(I('post.mix_withdraw'));
		$data['max_withdraw'] = trim(I('post.max_withdraw'));
		$data['sjjz_kefu'] = trim(I('post.sjjz_kefu'));
		$data['tx_yeb'] = trim(I('post.tx_yeb'));
		// $data['team_onecount'] = trim(I('post.team_onecount'));
		$data['team_oneyj'] = trim(I('post.team_oneyj'));
		$data['team_twocount'] = trim(I('post.team_twocount'));
		$data['team_twoprice'] = trim(I('post.team_twoprice'));
		$data['team_twoyj'] = trim(I('post.team_twoyj'));
		$data['team_threeyj'] = trim(I('post.team_threeyj'));
		$data['wechat_qr'] = trim(I('post.icon'));
		$data['ali_qr'] = trim(I('post.icon1'));
		$data['kf_qr'] = trim(I('post.icon2'));
		$data['notice'] = trim(I('post.notice'));
		$data['switch'] = trim(I('post.switch'));
		$data['activation'] = trim(I('post.activation')); //激活扣除USDT
		$data['time'] = trim(I('post.time')); //未接单时长

		$data['usdt_money'] = trim(I('post.usdt_money'));
		$data['conversion'] = trim(I('post.conversion'));

		$re = M('system')->where(array('id'=>1))->save($data);
		
		if($re){
			$this->success('修改成功');exit;
		}else{
			
			$this->error('修改失败');exit;
		}
		
		
	}else{
		$list = M('system')->where(array('id'=>1))->find();
        $list['total_profit'] = json_decode($list['total_profit']);
        $list['user_profit'] = json_decode($list['user_profit']);
        $list['user_first_num'] = json_decode($list['user_first_num']);
        $list['user_num'] = json_decode($list['user_num']);
        $list['user_money'] = json_decode($list['user_money']);
		$this->assign('info',$list);
		$this->display();
	}
	
}



//支付金额页面
public function paypage(){
	$id = trim(I('get.id'));
	$list = M('userrob')->where(array('id'=>$id))->find();
	$this->assign('info',$list);
	$this->display();
}

//支付成功处理
/********业务分析************/
/*
*产生佣金，上三代分享佣金
*扣除会员账户额度
*更改定单状态（两张表）
*生成资金日志
*/
public function payup(){
	if($_POST){
		
		$id = trim(I('post.id'));
		$list = M('userrob')->where(array('id'=>$id))->find();//操作的订单
		$pipeilist = M('roborder')->where(array('id'=>$list['ppid']))->find();//被 匹配的订单
		$ulist =  M('user')->where(array('userid'=>$list['uid']))->find();
		$clist = M('system')->where(array('id'=>1))->find();

		$yjbl = 0; //支付类型佣金比例 
		$yjjc = $list['yjjc']; //当前佣金加成
		if($list['class'] ==1){
			$yjbl = $clist['qd_wxyj'];
			$str = '微信抢单';
		}elseif($list['class'] ==2){
			$yjbl = $clist['qd_zfbyj'];
			$str = '支付宝抢单';
		}elseif($list['class'] ==3){
			$yjbl = $clist['qd_bkyj'];
			$str = '银行卡抢单';
		}
		$yjbl = $yjbl + $yjjc;//实际佣金比例
	
		$dec_price = $list['price'] - $list['price'] * $yjbl; //实际需扣除会员的金额。
		
		$yj_money = $list['price'] * $yjbl; //实际的佣金金额
		
		$udec_re = M('user')->where(array('userid'=>$list['uid']))->setDec('money',$dec_price); //减去金额
		$zsy_re = M('user')->where(array('userid'=>$list['uid']))->setInc('zsy',($list['price']+$yj_money)); //记录匹配收款和佣金
		
		if($udec_re && $zsy_re){
			
			$mdst_re = M('userrob')->where(array('id'=>$id))->save(array('status'=>3,'finishtime'=>time())); //修改定单状态
			
			$rob_mdst = M('roborder')->where(array('id'=>$list['ppid']))->save(array('status'=>3,'finishtime'=>time())); //修改后台发布的订单状态
			
			if($mdst_re && $rob_mdst){
				
				$billdec['uid'] = $ulist['userid'];
				$billdec['jl_class'] = 5; //抢单
				$billdec['info'] = $str.'本金'; 
				$billdec['addtime'] = time(); 
				$billdec['jc_class'] = '-'; 
				$billdec['num'] = $list['price'];
				
				$billdec_re = M('somebill')->add($billdec);
				
				$billinc['uid'] = $ulist['userid'];
				$billinc['jl_class'] = 1; //佣金类型
				$billinc['info'] = $str.'佣金'; 
				$billinc['addtime'] = time(); 
				$billinc['jc_class'] = '+'; 
				$billinc['num'] = $yj_money;
				
				$billinc_re = M('somebill')->add($billinc);
				
				if($billdec_re && $billinc_re){
					
					$oneuser = M('user')->where(array('userid'=>$ulist['pid']))->find();//上一代
					
					//一代佣金奖励
					if(!empty($oneuser)){
						
						$oneyj_money = $yj_money * $clist['team_oneyj']; //上一代佣金
						
						$puser_inc_re = M('user')->where(array('userid'=>$ulist['pid']))->setInc('money',$oneyj_money);
						
						if($puser_inc_re){							
							$puser_bill['uid'] = $oneuser['userid'];
							$puser_bill['jl_class'] = 1; //佣金类型
							$puser_bill['info'] = '直推抢单成功佣金'; 
							$puser_bill['addtime'] = time(); 
							$puser_bill['jc_class'] = '+'; 
							$puser_bill['num'] = $oneyj_money;
							M('somebill')->add($puser_bill);
						}
						
						$twouser = M('user')->where(array('userid'=>$oneuser['pid']))->find();//上二代
						
						if(!empty($twouser)){
							
							$twoyj_money = $yj_money * $clist['team_twoyj']; //二代佣金
							$twouser_inc_re = M('user')->where(array('userid'=>$oneuser['pid']))->setInc('money',$twoyj_money);
							if($twouser_inc_re){
								$twouser_bill['uid'] = $twouser['userid'];
								$twouser_bill['jl_class'] = 1; //佣金类型
								$twouser_bill['info'] = '二代抢单成功佣金'; 
								$twouser_bill['addtime'] = time(); 
								$twouser_bill['jc_class'] = '+'; 
								$twouser_bill['num'] = $twoyj_money;
								M('somebill')->add($twouser_bill);
							}
							
							$threeuser = M('user')->where(array('userid'=>$twouser['pid']))->find();//上三代
							if(!empty($threeuser)){
								$threeyj_money = $yj_money * $clist['team_threeyj']; //三代佣金
								$threeuser_inc_re =  M('user')->where(array('userid'=>$twouser['pid']))->setInc('money',$threeyj_money);
								
								if($threeuser_inc_re){
									$threeuser_bill['uid'] = $threeuser['userid'];
									$threeuser_bill['jl_class'] = 1; //佣金类型
									$threeuser_bill['info'] = '三代抢单成功佣金'; 
									$threeuser_bill['addtime'] = time(); 
									$threeuser_bill['jc_class'] = '+'; 
									$threeuser_bill['num'] = $threeyj_money;
									M('somebill')->add($threeuser_bill);
								}
								
							}
							
							
						}

						
					}

					
					/*********************这里添加打款成功短信提示***********************/
					
					$this->success('支付成功',U('Roborder/robsucc'));exit;
					
				}else{
					$this->error('支付失败',U('Roborder/robsucc'));exit;
				}
				
				
			}
			
		}else{
			$this->error('支付失败',U('Roborder/robsucc'));exit;
		}

		
	}else{
		$this->error('支付失败',U('Roborder/robsucc'));exit;
	}
	
	
	
}

//收款二给码管理
public function skewm(){
	
	if($_FILES && $_POST){
		
		

			
			if(!empty($_FILES['wxewm']['name'])){
				$file = setUpload($_FILES['wxewm']);
				$data['wxewm'] = $file['savepath'].$file['savename'];
			}
			
			if(!empty($_FILES['zfbewm']['name'])){
				$file = setUpload($_FILES['zfbewm']);
				$data['zfbewm'] = $file['savepath'].$file['savename'];
			}
			if(!empty($_FILES['bankewm']['name'])){
				$file = setUpload($_FILES['bankewm']);
				$data['bankewm'] = $file['savepath'].$file['savename'];
			}
			
			$re = M('skm')->where(array('id'=>1))->save($data);
			
			if($re){
				$this->success('修改成功');exit;
			}else{
				$this->error('修改失败');exit;
			}
			

	}else{
		
		$skmlist = M('skm')->where(array('id'=>1))->find();
		$this->assign('skmlist',$skmlist);
		$this->display();
	}
	
}

 
 
 
 
 public function pipei(){
	if(IS_POST){
		
		$id = I("post.id");
		$price = floatval(I("post.price"));

		if($price <= 0){
			$this->error('匹配金额最低一元!');exit;
		}

		$urobres = M("userrob")->where(array("id"=>$id,"status"=>1))->find();
		if($urobres){

			if($price > $urobres["price"]){
				$this->error('匹配金额大于当前订单可用匹配金额');exit;
			}else{
				$clist = M('system')->where(array('id'=>1))->find();
				$ordernum = a_order_rand();
				$data['class'] = $urobres['class'];
				$data['price'] = $price;
				$data['addtime'] = time();
				$data['status'] = 2;
				$data['uid'] = $urobres['uid'];
				$data['uname'] = $urobres['uname'];
				$data['umoney'] = $urobres['umoney'];
				$data['pipeitime'] = time();
				$data['ordernum'] = $ordernum;
				$data['yongjin'] = commission($price,$urobres['class']);
				$data['surplustime'] = time() + intval($clist["s_time"])*60;
				// $data['finishtime'] = time();

				$reid = M('roborder')->add($data);
				$ueid = M('userrob')->where(array("id"=>$id))->setDec("price",$price);

				if($reid && $ueid){

					$list = M('userrob')->where(array('id'=>$id,"status"=>1))->find();//工作订单

					$pipeilist = M('roborder')->where(array('ordernum'=>$ordernum))->order("id desc")->find();//匹配的订单

					$ulist =  M('user')->where(array('userid'=>$list['uid']))->find();
					

					$yjbl = 0; //支付类型佣金比例 
					$yjjc = $list['yjjc']; //当前佣金加成
					if($list['class'] ==1){
						$yjbl = $clist['qd_wxyj'];
						$str = '微信抢单';
					}elseif($list['class'] ==2){
						$yjbl = $clist['qd_zfbyj'];
						$str = '支付宝抢单';
					}elseif($list['class'] ==3){
						$yjbl = $clist['qd_bkyj'];
						$str = '银行卡抢单';
					}

					$yjbl = $yjbl + $yjjc;//实际佣金比例
	
					$dec_price = round($pipeilist['price'] - $pipeilist['price'] * $yjbl,2); //实际需扣除会员的金额。
					
					$yj_money = round($pipeilist['price'] * $yjbl); //实际的佣金金额

					// $upData = [];
					// $upData["money"] = $ulist["money"] + $yj_money;
					$upData["d_money"] = $ulist["d_money"] - $pipeilist['price'];
					$upData["zsy"] = $ulist["money"] + $pipeilist['price'] + $yj_money;

					$upStatus = M('user')->where(array('userid'=>$pipeilist['uid']))->save($upData);


					// $addyj_user = M('user')->where(array('userid'=>$pipeilist['uid']))->setInc('money',);
					
					// $udec_re = M('user')->where(array('userid'=>$pipeilist['uid']))->setDec('d_money',$pipeilist['price']); //减去金额

					// $zsy_re = M('user')->where(array('userid'=>$pipeilist['uid']))->setInc('zsy',$pipeilist['price']+$yj_money); //记录匹配收款和佣金


					if($upStatus){

						// $duser = M('user')->where(array('userid'=>$urobres['uid']))->find();

						// if($duser["d_money"] == 0.00){
				
						// 	M('userrob')->where(array('id'=>$id))->save(array("status"=>2));

						// }
						
						//$mdst_re = M('userrob')->where(array('id'=>$id))->save(array('status'=>3,'finishtime'=>time())); //修改定单状态
						
						// $rob_mdst = M('roborder')->where(array('id'=>$list['ppid']))->save(array('status'=>3,'finishtime'=>time())); //修改后台发布的订单状态
						
						// if($mdst_re && $rob_mdst){
							
						$billdec['uid'] = $ulist['userid'];
						$billdec['jl_class'] = 5; //抢单
						$billdec['info'] = $str.'本金'; 
						$billdec['addtime'] = time(); 
						$billdec['jc_class'] = '-'; 
						$billdec['num'] = $pipeilist['price'];
						
						$billdec_re = M('somebill')->add($billdec);
						
						$billinc['uid'] = $ulist['userid'];
						$billinc['jl_class'] = 1; //佣金类型
						$billinc['info'] = $str.'佣金'; 
						$billinc['addtime'] = time(); 
						$billinc['jc_class'] = '+'; 
						$billinc['num'] = $yj_money;
						
						$billinc_re = M('somebill')->add($billinc);
							
						if($billdec_re && $billinc_re){
							
							$oneuser = M('user')->where(array('userid'=>$ulist['pid']))->find();//上一代
							
							//一代佣金奖励
							if(!empty($oneuser)){

								// $onecount = M('user')->where(array('pid'=>$ulist['pid']))->count();//上一代

								// if($oneuser['d_money'] > 0){

									$oneyj_money = $yj_money * $clist['team_oneyj']; //上一代佣金

									$one_data = array(
										'money'=>array('exp','money+'.$oneyj_money),
										'yongjin'=>array('exp','yongjin+'.$oneyj_money),
									);
									$puser_inc_re = M('user')->where(array('userid'=>$ulist['pid']))->save($one_data);
								
									// $puser_inc_re = M('user')->where(array('userid'=>$ulist['pid']))->setInc('money',$oneyj_money);
									
									if($puser_inc_re){							
										$puser_bill['uid'] = $oneuser['userid'];
										$puser_bill['jl_class'] = 2; //佣金类型
										$puser_bill['info'] = '直推抢单成功佣金'; 
										$puser_bill['addtime'] = time(); 
										$puser_bill['jc_class'] = '+'; 
										$puser_bill['num'] = $oneyj_money;
										M('somebill')->add($puser_bill);
									}

								// }

								

								
								$twouser = M('user')->where(array('userid'=>$oneuser['pid']))->find();//上二代
								
								if(!empty($twouser)){

									// $twopricecount = M('user')->where(array('pid'=>$oneuser['pid']))->sum("d_money");//上二代

									$jj_count = $this->jj_sxj($ulist["userid"]);
									$dj_money = $this->djMoneys($ulist["userid"]);

									if($jj_count >= intval($clist["team_twocount"]) && $dj_money > floatval($clist["team_twoprice"])){

										$twoyj_money = $yj_money * $clist['team_twoyj']; //二代佣金


										$two_data = array(
											'money'=>array('exp','money+'.$twoyj_money),
											'yongjin'=>array('exp','yongjin+'.$twoyj_money),
										);
										$twouser_inc_re = M('user')->where(array('userid'=>$oneuser['pid']))->save($one_data);

										// $twouser_inc_re = M('user')->where(array('userid'=>$oneuser['pid']))->setInc('money',$twoyj_money);

										if($twouser_inc_re){
											$twouser_bill['uid'] = $twouser['userid'];
											$twouser_bill['jl_class'] = 2; //佣金类型
											$twouser_bill['info'] = '二代抢单成功佣金'; 
											$twouser_bill['addtime'] = time(); 
											$twouser_bill['jc_class'] = '+'; 
											$twouser_bill['num'] = $twoyj_money;
											M('somebill')->add($twouser_bill);
										}

									}
									

									
									// $threeuser = M('user')->where(array('userid'=>$twouser['pid']))->find();//上三代
									// if(!empty($threeuser)){
									// 	$threeyj_money = $yj_money * $clist['team_threeyj']; //三代佣金
									// 	$threeuser_inc_re =  M('user')->where(array('userid'=>$twouser['pid']))->setInc('money',$threeyj_money);
										
									// 	if($threeuser_inc_re){
									// 		$threeuser_bill['uid'] = $threeuser['userid'];
									// 		$threeuser_bill['jl_class'] = 1; //佣金类型
									// 		$threeuser_bill['info'] = '三代抢单成功佣金'; 
									// 		$threeuser_bill['addtime'] = time();
									// 		$threeuser_bill['jc_class'] = '+';
									// 		$threeuser_bill['num'] = $threeyj_money;
									// 		M('somebill')->add($threeuser_bill);
									// 	}
										
									// }
								}

								
							}

						}

						$sms_res = do_send_mobile_code(getuserinfo($urobres["uid"],2),"您有新的订单，请及时处理。");

						// if($res==1){//发送成功，写入数据
						// 	$code=1;
						// 	$msg="验证码发送成功";
						// }else{
						// 	$code=0;
						// 	$msg="验证码发送失败";
						// }
						// dump($sms_res);die;

						$this->success('匹配成功');exit;
								
						// }else{
						// 	$this->error('支付失败',U('Roborder/robsucc'));exit;
						// }
						
					}else{
						$this->error('匹配失败');exit;
					}



				}



				// if($reid && $ueid){
				// 	$this->success('匹配成功');exit;
				// }else{
				// 	$this->error('匹配失败');exit;
				// }

			}

		}




	}else{

		// dump(do_send_mobile_code("","test"));

		$id = I("get.id");

		$urobres = M("userrob")->where(array("id"=>$id))->find();
		$userres = M("user")->where(array("userid"=>$urobres["uid"]))->find();

		$wx_ewm = M("ewm")->where(array("uid"=>$urobres["uid"],"ewm_class"=>1))->find();
		$al_ewm = M("ewm")->where(array("uid"=>$urobres["uid"],"ewm_class"=>2))->find();


		if(!$wx_ewm){
			$wx_ewm["ewm_acc"] = "用户未添加";
		}

		if(!$al_ewm){
			$al_ewm["ewm_acc"] = "用户未添加";
		}



		$bank = M("bankcard")->where(array("uid"=>$urobres["uid"]))->find();

		if(!$bank){
			$bank["bankname"] = "用户未添加";
			$bank["name"] = "用户未添加";
			$bank["banknum"] = "用户未添加";
		}

		$this->assign("v",$urobres);
		$this->assign("userres",$userres);

		$this->assign("bank",$bank);

		$this->assign("wx",$wx_ewm);
		$this->assign("al",$al_ewm);
		$this->display();
	}
}
 
 
 
 
 
public function returned(){

	$id = I("get.id",0,"intval");
	$type = I("get.type",3,"intval");
	$status = I("get.status",0,"intval");
//    echo "<pre>";
//    print_r($status);exit;
	$res = M('roborder')->where(array('id'=>$id))->find();

	$re = M('roborder')->where(array('id'=>$id))->save(array("is_hk"=>$type));

	
	
	if($re){
        if($status){
            $price = $res['umoney'];
            M("user")->where("userid = {$res['uid']}")->setInc('money',$price);
            $user = M("user")->where("userid = {$res['uid']}")->find();
            $billdec_re = M('roborder')->where("id = {$res['id']}")->save(['status'=>3,'yongjin'=>0,'finishtime'=>time()]);
//            if($user['use_grade'] == 0){
//                //升级成不同会员
//                M('user')->where("userid = {$res['uid']}")->save(['use_grade'=>1]);
//            }
            if($billdec_re){
                $this->success('处理成功');exit;
            }else{
                $this->error('处理失败');exit;
            }
        }
		if($type == 2){
            $config = M('system')->where(array('id'=>1))->find();
            $user_money = json_decode($config['user_money']);
            $user = M("user")->where("userid = {$res['uid']}")->find();
            if($user){
                if($user['use_grade'] == 0){
                    $yjjc = $config['qd_yjjc'];
                }else{
                    $yjjc =  $user_money[$user['use_grade']-1];
                }
            }
            if($res['umoney'] == '0.00'){
                $res['umoney'] = $res['price'];
            }
            $money = $res['umoney']*$yjjc;
            if($money < 0.01){
                $this->error('数据错误');exit;
            }else{
                $price = $money+$res['umoney'];
                M("user")->where("userid = {$res['uid']}")->setInc('money',$money);
                M("user")->where("userid = {$res['uid']}")->setInc('zsy',$money);
                $billdec_re = M('roborder')->where("id = {$res['id']}")->save(['status'=>3,'yongjin'=>$money,'finishtime'=>time()]);
                M("user")->where("userid = {$res['uid']}")->setInc('static_profit',$money);

                //日志
                $billdec['uid'] = $user['userid'];
                $billdec['jl_class'] = 1; //抢单
                $billdec['info'] = '接单利息';
                $billdec['addtime'] = time();
                $billdec['jc_class'] = '+';
                $billdec['num'] = $money;
                $billdec['before'] = $user['money']-$money;
                $billdec['after'] = $money;

                $billdec_re = M('somebill')->add($billdec);
                //            $profit = new \Util\Profit();
                //            if(!empty($user['pid']) && $billdec_re){
                //                $profit->second_profit($user['pid'],array($money,$res['umoney']),$config); //返推荐人
                //                if(!empty($user['gid'])){
                //                    $profit->total_profit($user['gid'],$res['umoney'],$config); //返团队
                //                }
                //            }
                M('roborder')->where("id = {$res['id']}")->save(['status'=>3,'yongjin'=>$money,'finishtime'=>time()]);
                if(!empty($user['pid'])){
                	$user_money['qd_yjjc'] = $config['qd_yjjc'];
                    $this->levle_profit($user['pid'],$user_money,$user['use_grade'],$res['umoney']);
                }else{
                    $i = 1;
                }
            }
//            if($user['use_grade'] == 0){
//                //升级成不同会员
//                M('user')->where("userid = {$res['uid']}")->save(['use_grade'=>1]);
//            }


			if($billdec_re){
				$this->success('处理成功');exit;
			}else{
				$this->error('处理失败');exit;
			}
		}else{
			$this->success('处理成功');exit;
		}

	}else{
		$this->error('处理回款失败');exit;
	}
		

}
 
 






    public function jj_sxj($id)
    {   
         // 搜索
        $pid = $id;
        $tree = $this->getTree1($pid);
        $tree = rtrim($tree,"###");
        // dump($tree);

        $tree = explode("###",$tree);
        // dump($tree);
        return intval(count($tree));
    }


    public  function getTree1($pid='0')
    {
        $t=M('user');
        $wherea = array("pid"=>$pid);
        $list=$t->where($wherea)->order('userid asc')->select();

        if(is_array($list)){
            $html = array();
            $i++;
            foreach($list as $k => $v)
            {
                $map['pid']=$v['userid'];
                $count=$t->where($map)->count(1);
                $class=$count==0 ? 'fa-user':'fa-sitemap';

               if($v['pid'] == $pid)
               {
                    $html .= $v['account']."###";
                    $html .= $this->getTree1($v['userid']);
               }
            }
            return $html;
        }
    }



     public function djMoneys($id)
    {   
         // 搜索
        $pid        =   $id;       
        $tree = $this->djGetTree($pid);
        $tree = rtrim($tree,"###");
        // dump($tree);

        $tree = explode("###",$tree);
        // dump($tree);
        foreach ($tree as $key => $value) {
            
            $djmoney += floatval($value);

        }
        return $djmoney;
    }


    public  function djGetTree($pid='0')
    {
        $t = M('user');
        $wherea = array("pid"=>$pid);
        $list = $t->where($wherea)->order('userid asc')->select();

        if(is_array($list)){
            $i++;
            foreach($list as $k => $v)
            {
                $map['pid']=$v['userid'];
                $count=$t->where($map)->count(1);
                $class=$count==0 ? 'fa-user':'fa-sitemap';

               if($v['pid'] == $pid)
               {
                    $data .= $v['d_money']."###";
                    $data .= $this->djGetTree($v['userid']);
               }
            }
            return $data;
        }
    }

    /**
     * 级差奖
     * 上级id 佣金配置 等级 已返数量 金额
     */
    public function levle_profit($id,$config,$level,$money)
    {
        $user = M("user")->where("userid = $id")->find();
        if($level >= $user['use_grade'] || $user['activates'] == 0){
            if(!empty($user['pid'])){
                return $this->levle_profit($user['pid'],$config,$level,$money);
            }else{
                return true;
            }
        }
        if($level != 0){
            $yjjc =  $config[$level-1]; //之前的
        }else{
            $yjjc = $config['qd_yjjc'];
        }
        $yjjcs =  $config[$user['use_grade']-1]; //当前的
        $price = $yjjcs -$yjjc;
        if($price >0){
            $num = $money*$price; //可以获得的金额
            if($num < 0.0001){
                return true;
            }
            M("user")->where("userid = {$user['userid']}")->setInc('money',$num);
            $billdec['uid'] = $user['userid'];
            $billdec['jl_class'] = 19; //抢单
            $billdec['info'] = '级差奖';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '+';
            $billdec['num'] = $num;
            $billdec['before'] = $user['money'];
            $billdec['after'] = $user['money'] + $num;
            $billdec_re = M('somebill')->add($billdec);
            $level = $user['use_grade'];
        }
        if($user['use_grade'] == 10){
            return true;
        }
        if(!empty($user['pid'])){
            return $this->levle_profit($user['pid'],$config,$level,$money);
        }else{
            return true;
        }
    }

    /**
     * 跑单详情
     */
    public function robor_info()
    {
        $id = I('id');
        $roborder = M('roborder')->where("id = $id")->find(); //交易
        if(empty($roborder)){
            $this->error('不存在订单');exit;
        }
        if($roborder['class'] == 3){
            $bank = M('bankcard')->where(array('uid'=>$roborder['uid'],'type'=>0))->order('id desc')->select();
        }else{
            $ewm = M('ewm')->where(array('uid'=>$roborder['uid'],"ewm_class"=>$roborder['class']))->select();
        }
        if(!empty($roborder['umoney'])){
                $prices = json_decode($roborder['prices'], true);
                $data = array();
                for ($i = 0; $i < count($prices); $i++) {
                    $us = $i % 8;
//            $data['us_name'] = $name[$us];
                    $data['price'] = $prices[$i + 1]['num'];
                    $data['yongjin'] = $prices[$i + 1]['yongjin'];
                    $roborder['first'][$i] = $data;
                }
//            $this->assign('arr',$roborder);
        }
        $this->assign("ewm",$ewm);
        $this->assign("bank",$bank);
        $this->assign("info",$roborder);
        return $this->display();
    }

    //获取姓名
    public function generateName(){
        $arrXing = $this->getXingList();
        $numbXing = count($arrXing);
        $arrMing = $this->getMingList();
        $numbMing =  count($arrMing);

        $Xing = $arrXing[mt_rand(0,$numbXing-1)];
        $Ming = $arrMing[mt_rand(0,$numbMing-1)].$arrMing[mt_rand(0,$numbMing-1)];

        $name = $Xing.$Ming;

        return $name;

    }

    //获取姓氏
    public function getXingList(){
        $arrXing=array('赵','钱','孙','李','周','吴','郑','王','冯','陈','褚','卫','蒋','沈','韩','杨','朱','秦','尤','许','何','吕','施','张','孔','曹','严','华','金','魏','陶','姜','戚','谢','邹',
            '喻','柏','水','窦','章','云','苏','潘','葛','奚','范','彭','郎','鲁','韦','昌','马','苗','凤','花','方','任','袁','柳','鲍','史','唐','费','薛','雷','贺','倪','汤','滕','殷','罗',
            '毕','郝','安','常','傅','卞','齐','元','顾','孟','平','黄','穆','萧','尹','姚','邵','湛','汪','祁','毛','狄','米','伏','成','戴','谈','宋','茅','庞','熊','纪','舒','屈','项','祝',
            '董','梁','杜','阮','蓝','闵','季','贾','路','娄','江','童','颜','郭','梅','盛','林','钟','徐','邱','骆','高','夏','蔡','田','樊','胡','凌','霍','虞','万','支','柯','管','卢','莫',
            '柯','房','裘','缪','解','应','宗','丁','宣','邓','单','杭','洪','包','诸','左','石','崔','吉','龚','程','嵇','邢','裴','陆','荣','翁','荀','于','惠','甄','曲','封','储','仲','伊',
            '宁','仇','甘','武','符','刘','景','詹','龙','叶','幸','司','黎','溥','印','怀','蒲','邰','从','索','赖','卓','屠','池','乔','胥','闻','莘','党','翟','谭','贡','劳','逄','姬','申',
            '扶','堵','冉','宰','雍','桑','寿','通','燕','浦','尚','农','温','别','庄','晏','柴','瞿','阎','连','习','容','向','古','易','廖','庾','终','步','都','耿','满','弘','匡','国','文',
            '寇','广','禄','阙','东','欧','利','师','巩','聂','关','荆','司马','上官','欧阳','夏侯','诸葛','闻人','东方','赫连','皇甫','尉迟','公羊','澹台','公冶','宗政','濮阳','淳于','单于','太叔',
            '申屠','公孙','仲孙','轩辕','令狐','徐离','宇文','长孙','慕容','司徒','司空');
        return $arrXing;

    }
    //获取名字
    public function getMingList(){
        $arrMing=array('伟','刚','勇','毅','俊','峰','强','军','平','保','东','文','辉','力','明','永','健','世','广','志','义','兴','良','海','山','仁','波','宁','贵','福','生','龙','元','全'
        ,'国','胜','学','祥','才','发','武','新','利','清','飞','彬','富','顺','信','子','杰','涛','昌','成','康','星','光','天','达','安','岩','中','茂','进','林','有','坚','和','彪','博','诚'
        ,'先','敬','震','振','壮','会','思','群','豪','心','邦','承','乐','绍','功','松','善','厚','庆','磊','民','友','裕','河','哲','江','超','浩','亮','政','谦','亨','奇','固','之','轮','翰'
        ,'朗','伯','宏','言','若','鸣','朋','斌','梁','栋','维','启','克','伦','翔','旭','鹏','泽','晨','辰','士','以','建','家','致','树','炎','德','行','时','泰','盛','雄','琛','钧','冠','策'
        ,'腾','楠','榕','风','航','弘','秀','娟','英','华','慧','巧','美','娜','静','淑','惠','珠','翠','雅','芝','玉','萍','红','娥','玲','芬','芳','燕','彩','春','菊','兰','凤','洁','梅','琳'
        ,'素','云','莲','真','环','雪','荣','爱','妹','霞','香','月','莺','媛','艳','瑞','凡','佳','嘉','琼','勤','珍','贞','莉','桂','娣','叶','璧','璐','娅','琦','晶','妍','茜','秋','珊','莎'
        ,'锦','黛','青','倩','婷','姣','婉','娴','瑾','颖','露','瑶','怡','婵','雁','蓓','纨','仪','荷','丹','蓉','眉','君','琴','蕊','薇','菁','梦','岚','苑','婕','馨','瑗','琰','韵','融','园'
        ,'艺','咏','卿','聪','澜','纯','毓','悦','昭','冰','爽','琬','茗','羽','希','欣','飘','育','滢','馥','筠','柔','竹','霭','凝','晓','欢','霄','枫','芸','菲','寒','伊','亚','宜','可','姬'
        ,'舒','影','荔','枝','丽','阳','妮','宝','贝','初','程','梵','罡','恒','鸿','桦','骅','剑','娇','纪','宽','苛','灵','玛','媚','琪','晴','容','睿','烁','堂','唯','威','韦','雯','苇','萱'
        ,'阅','彦','宇','雨','洋','忠','宗','曼','紫','逸','贤','蝶','菡','绿','蓝','儿','翠','烟');
        return $arrMing;
    }
}
