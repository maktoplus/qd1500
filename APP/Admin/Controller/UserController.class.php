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
     public function index(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['account'] = $account;
			 }elseif($querytype=='userid'){
				  $map['userid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('user');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,50);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'money desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'userid desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }

		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);

//         activation
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();
    }
	
	//流水
	public function bill(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['account'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		

		$userobj = M('somebill');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,15);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'money desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();
    }
	
	
	
	public function delbill(){
		$id=trim(I('get.id'));
		$re = M('somebill')->where(array('id'=>$id))->delete();
		if($re){
			$this->success('删除成功');exit;
		}else{
			$this->error('删除失败');exit;
		}
	}
	
	//提现列表
	public function recharge(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['account'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('recharge');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,50);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'price desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }else{
				 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		$conf = M('system')->where(array('id'=>1))->find();
		$this->assign('conf',$conf);
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

	}
	
	//充值处理
	public function reedit(){
		$id = trim(I('get.id'));
		$st = trim(I('get.st'));
		$relist  = M('recharge')->where(array('id'=>$id))->find();
		$ulist = M('user')->where(array('userid'=>$relist['uid']))->find();
		if($st ==1){
			if($relist['status'] == 1){
				$re = M('recharge')->where(array('id'=>$id))->save(array('status'=>3));
				$ure = M('user')->where(array('userid'=>$relist['uid']))->setInc('money',$relist['price']);
				// if($ulist['use_grade'] == 0){
    //                 M('user')->where(array('userid'=>$relist['uid']))->setInc('use_grade');
    //             }
                $arrid =explode('-',$ulist['path']);
                $key = count($arrid);
                unset($arrid[$key-1]);
                unset($arrid[0]);
                unset($arrid[1]);
				if(empty($arrid)){
				    $arrid = $ulist['userid'];
                }else{
                    $arrid = implode(',',$arrid);
                    $arrid = $ulist['userid'].','.$arrid;
                }
                $user_id = $arrid;
				if(!empty($user_id)){
                    $ure = M('user')->where("userid in ($user_id)")->setInc('total_recharge',$relist['price']);
                }
                $billdec['uid'] = $relist['uid'];
                $billdec['jl_class'] = 3; //抢单
                $billdec['info'] = '前台充值';
                $billdec['addtime'] = time();
                $billdec['jc_class'] = '+';
                $billdec['num'] = $relist['price'];
                $billdec['before'] = $ulist['money'];
                $billdec['after'] = $ulist['money']+$relist['price'];
                $billdec_re = M('somebill')->add($billdec);
//                update_level($relist['uid']); //升级成组长
			}else{
				$re = 0;
				$ure =0;
			}
			
			
			
		}elseif($st ==2){
			if($relist['status'] == 1){
				$re = M('recharge')->where(array('id'=>$id))->save(array('status'=>2));
				$ure = 1;
			}else{
				$re = 0;
				$ure =0;
			}
			
			
		}elseif($st ==3){
			if($relist['status'] == 3){
				$re = M('recharge')->where(array('id'=>$id))->delete();
				$ure = 1;
			}else{
				$re = 0;
				$ure =0;
			}
		}
		
		if($re && $ure){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
		
		
	}
	
	//充值处理
	public function save_czset(){
		if($_GET){
			$data['cz_yh'] = trim(I('get.cz_yh'));
			$data['cz_xm'] = trim(I('get.cz_xm'));
			$data['cz_kh'] = trim(I('get.cz_kh'));

			$re = M('system')->where(array('id'=>1))->save($data);
			
			if($re){
				$this->success('修改成功');exit;
			}else{
				
				$this->error('修改失败');exit;
			}
		}
		
	}
	
	
	//提现列表
	public function withdraw(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));

		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['account'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('withdraw');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,50);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'price desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }else{
				 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

	}
	
	
	//提现处理
	public function wiedit(){
		$id = trim(I('get.id'));
		$st = trim(I('get.st'));
		$relist  = M('withdraw')->where(array('id'=>$id))->find();
	
		if($st ==1){
			$re = M('withdraw')->where(array('id'=>$id))->save(array('status'=>3));
			
			
		}elseif($st ==2){
			$re = M('withdraw')->where(array('id'=>$id))->save(array('status'=>2));
            $user_id = $relist['uid'];
            $users = M('user')->where("userid in ($user_id)")->find();
            if(!empty($user_id)){
                $ure = M('user')->where("userid in ($user_id)")->setInc('money',$relist['price']);
            }
            $billdec['uid'] = $relist['uid'];
            $billdec['jl_class'] = 20; //抢单
            $billdec['info'] = '提现驳回';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '+';
            $billdec['num'] = $relist['price'];
            $billdec['before'] = $users['money'];
            $billdec['after'] =$users['money']+$relist['price'];
            $billdec_re = M('somebill')->add($billdec);
		}elseif($st ==3){
			$re = M('withdraw')->where(array('id'=>$id))->save(array('status'=>3));
	
		}
		
		if($re){
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
		
		
	}
	
	
	//提现列表
	public function ewm(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));

		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['uaccount'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('ewm');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,50);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'ewm_price desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }else{
				 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

	}
	
	
	
	//二维码详情
	public function ewminfo(){		
		$id= trim(I('get.id'));
		$ewminfo = M('ewm')->where(array('id'=>$id))->find();
		$this->assign('info',$ewminfo);
		$this->display();
	}
	
	//删除二维码
	public function delewm(){
		$id= trim(I('get.id'));
		$re = M('ewm')->where(array('id'=>$id))->delete();
		if($re){
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
		
	}
	
	
	//银行卡列表
	public function bankcard(){
		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 $coinpx = trim(I('get.coinpx'));

		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['name'] = $account;
			 }elseif($querytype=='userid'){
				  $map['uid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('bankcard');
		$count =$userobj->where($map)->count();
		$p = getpagee($count,50);
		
		 if($coinpx){
			 if($coinpx == 1){
				  $list = $userobj->where ( $map )->order ( 'addtime desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }else{
				 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
			 }
		 }else{
			 $list = $userobj->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		 }
    	
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->display();

	}
	
	
	
	
	
	
	//冻结会员
	public function set_status(){
		if($_GET){
			$userid = trim(I('get.userid'));
			$st = trim(I('get.st'));
			$list = M('user')->where(array('userid'=>$userid))->find();
			if(empty($list)){
				$this->error('该会员不存在');
			}
			if($st == 1){
				$re = M('user')->where(array('userid'=>$userid))->save(array('status'=>0));
				if($re){
					$this->error('该会员已被冻结');
				}else{
					$this->error('网络错误！');
				}
				
			}elseif($st == 2){
				$system = M('system')->where(array('id'=>1))->find();
				$unfreeze = strtotime('+1 day');
				$re = M('user')->where(array('userid'=>$userid))->save(array('status'=>1,"unfreeze_expire"=>$unfreeze));

				$rolist = M("roborder")->where(array("uid"=>$userid,"status"=>2,"is_hk"=>0))->select();


				$pipeitime = time();
				$surplustime = time() + intval($system["s_time"])*60;
				foreach ($rolist as $key => $value) {
					M("roborder")->where(array("id"=>$value["id"]))->save(array("pipeitime"=>$pipeitime,"surplustime"=>$surplustime));
				}

				if($re){
					$this->error('该会员已被解冻');
				}else{
					$this->error('网络错误！');
				}
				
			}else{
				$this->error('网络错误！');
			}
			
			
			
			
		}else{
			$this->error('网络错误！');
		}
		
		
	}





    /**
     * 编辑用户
     * 
     */
    public function edit(){
		$userid = trim(I('get.userid'));
		$ulist = M('user')->where(array('userid'=>$userid))->find();
	
		if($_POST){
			$data['username'] = trim(I('post.username'));
			$data['mobile'] = trim(I('post.mobile'));
			$data['truename'] = trim(I('post.truename'));
			$data['wx_no'] = trim(I('post.wx_no'));
			$data['alipay'] = trim(I('post.alipay'));
			$data['nsc_money'] = trim(I('post.nsc_money'));
			$data['eth_money'] = trim(I('post.eth_money'));
			$data['eos_money'] = trim(I('post.eos_money'));
			$data['btc_money'] = trim(I('post.btc_money'));
			$data['money'] = trim(I('post.money'));
			$data['use_grade'] = trim(I('post.use_grade'));
//			dump(I('post.'));exit;
			if($data['money'] > $ulist['money']){
			    $num = $data['money'] - $ulist['money'];
                $arrid =explode('-',$ulist['path']);
                $key = count($arrid);
                unset($arrid[$key-1]);
                unset($arrid[0]);
                unset($arrid[1]);
                if(empty($arrid)){
                    $arrid = $ulist['userid'];
                }else{
                    $arrid = implode(',',$arrid);
                    $arrid = $ulist['userid'].','.$arrid;
                }
                $user_id = $arrid;
                $ure = M('user')->where("userid in ($user_id)")->setInc('total_recharge',$num);
                if(!$ure){
                    $this->error('资金修改失败');
                }
                $billdec['uid'] = $ulist['userid'];
                $billdec['jl_class'] = 3; //抢单
                $billdec['info'] = '平台充值';
                $billdec['addtime'] = time();
                $billdec['jc_class'] = '+';
                $billdec['num'] = $num;
                $billdec['before'] = $ulist['money'];
                $billdec['after'] = $ulist['money']+$num;
                $billdec_re = M('somebill')->add($billdec);
//                update_level($userid); //升级成组长
            }
			$login_pwd = trim(I('post.login_pwd'));
			
			if($login_pwd != ''){
				$data['login_pwd'] = pwd_md5($login_pwd,$ulist['login_salt']);
			}
			
			$safety_pwd = trim(I('post.safety_pwd'));
			
			if($safety_pwd != ''){
				$data['paypass'] = pwd_md5($safety_pwd,$ulist['login_salt']);
			}
			if(empty($userid)){
			$data['account'] = trim(I('post.account'));
                $data['u_yqm'] = $this->strrand();
                $re = M('user')->where(array('userid'=>$userid))->add($data);
            }else{
                $re = M('user')->where(array('userid'=>$userid))->save($data);
            }
			if($re){
				
				$this->success('资料修改成功');
			}else{
				$this->error('资料修改失败');
				
			}
			
			
			
		}else{
			
			$this->assign('info',$ulist);
			$this->display();
		}
		
    }

    function strrand($length = 12, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        if(!is_int($length) || $length < 0) {
            return false;
        }
        $string = '';
        for($i = $length; $i > 0; $i--) {
            $string .= $char[mt_rand(0, strlen($char) - 1)];
        }
        return $string;
    }

    /**
     * 编辑用户
     *
     */
    public function day_log(){
        $userid = trim(I('get.userid'));
        if($_POST){
            $arr_id = for_user($userid);
            if(empty($arr_id)){
                 $data = array('running_water'=>0,'total'=>0,'day_recharge'=>0,'roborder_num'=>0,'day_withdraw'=>0);
            }else{
                $data = $this->day_count($arr_id);
            }
            $this->ajaxReturn($data,'JSON');
        }else{
            $ulist = M('user')->where(array('userid'=>$userid))->find();
           $data = $this->day_count($userid);
            $this->assign('info',$ulist);
            $this->assign('data',$data);
            $this->display();
        }
    }

    /**
     * 当日统计
     */
    public function day_count($userid)
    {
        $user=D('recharge'); //充值
        $withdraw=D('withdraw'); // 提现
        $roborder=D('roborder');// 接单流水
        $somebill=D('somebill');//接单奖金 团队佣金
//        $user_total=$user->count();
        $start=strtotime(date('Y-m-d'));
        $end=$start+86400;
        $where="addtime BETWEEN {$start} AND {$end}";
        $wheres = "uid in($userid) AND ";
        $user_count=$user->where($wheres."status = 3 AND ".$where)->sum('price'); //充值
        $withdraw_num=$withdraw->where($wheres.$where)->sum('price'); //提现
        $roborder_num=$roborder->where($wheres.$where)->sum('price'); //流水
        $running_water=$somebill->where($wheres."jl_class = 1 AND ".$where)->sum('num'); //接单奖励
        $total=$somebill->where($wheres."jl_class = 2 AND ".$where)->sum('num'); //团队佣金
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
        return array('running_water'=>$running_water,'total'=>$total,'day_recharge'=>$user_count,'roborder_num'=>$roborder_num,'day_withdraw'=>$withdraw_num);
//        $this->assign('running_water', $running_water);
//        $this->assign('total', $total);
//        $this->assign('day_recharge', $user_count);
//        $this->assign('roborder_num', $roborder_num);
//        $this->assign('day_withdraw', $withdraw_num);
    }
	
    /**
     * 编辑用户
     * 
     */
    public function del(){
		$userid = trim(I('get.userid'));
		M('user')->where(array('userid'=>$userid))->delete();
		$this->success('会员删除成功');
    }
	
	
	//限制出售币和提币
	public function restrict(){
		$userid = trim(I('get.userid'));
		$ulist = M('user')->where(array('userid'=>$userid))->find();
		if($_POST){
			
			$sell_status = trim(I('post.sell_status'));
			
			$tx_status = trim(I('post.tx_status'));
			
			$zz_status = trim(I('post.zz_status'));
			
			if($ulist['sell_status'] == 1){
				
				if($sell_status != ''){
					$data['sell_status'] = 0;
				}
				
			}else{
				
				if($sell_status != ''){
					
					$data['sell_status'] = 1;
					
				}
				
			}
			
			if($ulist['tx_status'] == 1){
				
				if($tx_status != ''){
					$data['tx_status'] = 0;
				}
			}else{
				
				if($tx_status != ''){
					$data['tx_status'] = 1;
				}
			}
			
			if($ulist['zz_status'] == 1){
				
				if($zz_status != ''){
					$data['zz_status'] = 0;
				}
			}else{
				
				if($zz_status != ''){
					$data['zz_status'] = 1;
				}
			}
			
			$re = M('user')->where(array('userid'=>$userid))->save($data);
			
			if($re){
				
				$this->success('修改成功');
				
			}else{
				$this->error('修改失败');
			}
			
			
		}else{
			
			$this->assign('info',$ulist);
			$this->display();
		}
	}
	


	


    /**
     * 设置一条或者多条数据的状态
     * 
     */
    public function setStatus($model = CONTROLLER_NAME){
  
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



/**
     * 生成激活码
     */
    public function create_cdk()
    {
        if (IS_POST) {
            $cdk_num = intval(I('post.cdk_num'));  //生成数量
            if($cdk_num <= 0){
            	$this->error('生成数量必须大于0');
            }
            if ($cdk_num) {
                for ($i = 0; $i < $cdk_num; $i++) {
                    //查询是否重复
                    //$cdkey=create_randomstr_s();
                    $check = true;
                    while ($check==true) {
                        $cdkey = create_randomstr_s();
                        $result = M('cdkey')->where(array('cdkey' => $cdkey))->find();
                        if (empty($result)) {
                            $data['cdkey'] = $cdkey;
                            $check = false;
                        }
                    }
                    $data['status'] = 0;
      
                    $data['addtime']=time();
                    $result=M('cdkey')->add($data);
                }
                if($result){
                    $this->success('操作成功');
                }
            }
        } else {
        	// echo create_randomstr_s(8);die;
        	$result = M('cdkey')->select();
        	$this->assign("list",$result);
            $this->display();
        }

    }








    public function team()
    {

		 $querytype = trim(I('get.querytype'));
		 $account = trim(I('get.keyword'));
		 if($querytype != ''){
			 if($querytype=='mobile'){
				 $map['account'] = $account;
			 }elseif($querytype=='userid'){
				  $map['userid'] = $account;
			 }
		 }else{
			 $map = '';
		 }
		
		
		
		$userobj = M('user');
		$count = $userobj->where($map)->count();
		$p = getpagee($count,50);
		
		$userlist = $userobj->where ( $map )->order ( 'userid desc' )->limit ( $p->firstRow, $p->listRows )->select ();
    	

    	foreach ($userlist as $key => $value) {
    		// dump($value);die;
    		// echo"<br>";
    		$teamList = $this->tdcz($value["userid"]);

    		$userlist[$key]["team_rs"] = count($teamList);

    		foreach ($teamList as $k => $v) {
    			$userCz = M("recharge")->where(array("uid"=>$v,"status"=>3))->sum("price");
    			$czSum += $userCz;
    		}
    		$userlist[$key]["team_cz"] = floatval($czSum);
    		unset($czSum);


    		foreach ($teamList as $tk => $tv) {
    			$userTx = M("withdraw")->where(array("uid"=>$tv,"status"=>3))->sum("price");
    			$txSum += $userTx;
    		}
    		$userlist[$key]["team_tx"] = floatval($txSum);
    		unset($txSum);


    		foreach ($teamList as $sk => $sv) {
    			$userSy = M("user")->where(array("userid"=>$sv))->sum("money");
    			$sySum += $userSy;
    		}
    		$userlist[$key]["team_sy"] = floatval($sySum);
    		unset($sySum);

    		foreach ($teamList as $jk => $jv) {
    			$userJm = M("somebill")->where(array("uid"=>$jv,"jl_class"=>2,"jc_class"=>"+"))->sum("num");
    			$jmSum += $userJm;
    		}
    		$userlist[$key]["team_jm"] = floatval($jmSum);
    		unset($jmSum);


    		foreach ($teamList as $yk => $yv) {
    			$userYj = M("somebill")->where(array("uid"=>$yv,"jl_class"=>1,"jc_class"=>"+"))->sum("num");
    			$yJSum += $userYj;
    		}
    		$userlist[$key]["team_yj"] = floatval($yJSum);
    		unset($yJSum);


    	}

    	// dump($userlist);die;

    	// die;

    	$this->assign ( 'list', $userlist ); // 賦值數據集
		$this->assign('count',$count);
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	$this->display();
    }



    public function tdcz($pid)
    {   
         // 搜索
        $pid        =   $pid;
        // echo $pid;die;
        $user           =   M('user');

        $tree = $pid."###".$this->teamAll($pid);
        // $tree = $tree;
        // dump($tree);die;
        $tree = rtrim($tree,"###");
        // dump($tree);die;

        $tree = explode("###",$tree);
        
        return $tree;
    }



    public  function teamAll($pid='0')
    {
        $t=M('user');
        $wherea=array(  
        "pid"=>$pid
         );
        //$list=$t->where(array('pid'=>$pid,'sex'==0))->order('userid asc')->select();
        $list=$t->where($wherea)->order('userid asc')->select();

        if(is_array($list)){
            $i++;
            foreach($list as $k => $v)
            {
                $map['pid']=$v['userid'];
                $count=$t->where($map)->count(1);
                $class=$count==0 ? 'fa-user':'fa-sitemap';

               if($v['pid'] == $pid)
               {   
                    $data .= $v['userid']."###";
                    $data .= $this->teamAll($v['userid']);
               }
            }
            return $data;
        }
    }

}
