<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends CommonController
{

    public function index(){

    	Header("Location:".U("index/qdgame"));
      
		$ulist = M('user')->order('zsy desc')->limit(10)->select();
		
		foreach($ulist as $k=>&$v){
			$v['username'] = $this->substr_cut($v['username']);
		}
		
		
		
		$num = count($ulist);

		$this->assign('num',$num);
		$this->assign('ulist',$ulist);
        $this->display();
    }
	
	public function substr_cut($user_name){
		$strlen     = mb_strlen($user_name, 'utf-8');
		$firstStr     = mb_substr($user_name, 0, 2, 'utf-8');
		$lastStr     = mb_substr($user_name, -2, 2, 'utf-8');
		return $strlen == 2 ? mb_substr($user_name, 0, 1, 'utf-8') . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . "**" . $lastStr;
	}
	
	public function qdgame(){
		$userid = session('userid');
		$ulist = M('user')->where(array('userid'=>$userid))->find();
//		$rob_res = M('userrob')->where(array('uid'=>$userid,"status"=>1))->find();
		$rob_res = M('roborder')->where(array('uid'=>$userid,'status'=>2,'umoney'=>array('gt',0)))->order('id desc')->select();
		//前20条 收益信息
//        $somebill = M('roborder')->where(array('status'=>3))->limit(20)->order('id desc')->select();
        $somebills = M('roborder')->where(array('status'=>1))->limit(5)->order('id desc')->select();
        $clist = M('system')->where(array('id'=>1))->find();
        if(!empty($rob_res)){
		    $rob_res['price'] = json_decode($rob_res['price']);
		    $count = count($rob_res); //总数
        }else{
            $count = 0;
        }
		if($ulist['money'] > 0){
			$max_pipeinone = $ulist['money'] * ($clist['qd_cf']  / 100);
		}else{
			$max_pipeinone = 0;
		}

//		if($rob_res){
//			$is_gz = true;
//		}else{
//			$is_gz = false;
//		}

        if(!empty($rob_res)){
            $arr = json_decode($rob_res['prices'],true);
            $this->assign('arr',$arr);
        }



		
		$tarr = explode(',',$clist['qd_ndtime']);
		/*******刷新一次更改一次，不行*******/
		/* $st = in_array($h,$tarr);
		
		$nd = explode(',',$clist['qd_nd']);
		
		$num = count($nd);
		$key = rand(0,$num-1);	

		if($st){

			$key = rand(0,$num-1);

			if($key=='' || $key == 0){
				$key = '0';
			}
			if($m > 0 && $m <= 59){
				$tkey = $key;
			}
			$qd_yjjc = $nd[$tkey];
		}else{
			$qd_yjjc = '0';
		}  */
		
		/******只能手动后台更改了*****/


//		$notice = M('news')->find();
		// var_dump($notice);die;
		// $a = M('user')->where(array('pid'=>3))->sum("d_money");//上二代

		// dump($a);die;
        $user_money = json_decode($clist['user_money']);
        if($ulist['use_grade'] == 0){
            $yjjc = $clist['qd_yjjc'];
        }else{
            $yjjc =  $user_money[$ulist['use_grade']-1];
        }
		$this->assign("notice",$clist['notice']);

		$this->assign("somebill",$somebill);
		$this->assign("count",$count);
		$this->assign("somebills",$somebills);
		$this->assign("rob_res",$rob_res);
		$this->assign('tarr',$tarr);
		$this->assign('ulist',$ulist);
//		$this->assign('qd_yjjc',$clist['qd_yjjc']);
		$this->assign('qd_yjjc',$yjjc);
		$this->assign('qd_minmoney',$clist['qd_minmoney']);
		$this->assign('max_pipeinone',$max_pipeinone);
		$this->display();		
	}

	public function shoudan(){
		$userid = session('userid');
		$slist = M('roborder')->where(array('uid'=>$userid,'status'=>2))->order('id desc')->select();
//		dump($slist);exit;
		$flist = M('roborder')->where(array('uid'=>$userid,'status'=>3))->order('id desc')->select();
        $clist = M('system')->where(array('id'=>1))->field('qd_yjjc')->find();
        $name = array('永利皇宫','新濠天地','威尼斯人','羅斯福','太阳城','新葡京','美高梅','凯旋门');
        foreach ($flist as $k =>$v){
            $prices = json_decode($v['prices'],true);
            $data = array();
            for ($i = 0;$i<count($prices);$i++){
                $us= $i%8;
//                $data['us_name'] = $name[$us];
                $data['price'] = $prices[$i+1]['num'];
                $data['yongjin'] = $prices[$i+1]['yongjin'];
                $flist[$k]['first'][$i] = $data;
            }
        }
        foreach ($slist as $k =>$v) {
            $prices = json_decode($v['prices'], true);
            $data = array();
            for ($i = 0; $i < count($prices); $i++) {
                $us = $i % 8;
//            $data['us_name'] = $name[$us];
                $data['price'] = $prices[$i + 1]['num'];
                $data['yongjin'] = $prices[$i + 1]['yongjin'];
                $slist[$k]['first'][$i] = $data;
            }
        }
        //15个
		// $dlist = M('userrob')->where(array('uid'=>$userid,'status'=>4))->select();
		$this->assign('slist',$slist);
		$this->assign('flist',$flist);
		$this->assign('clist',$clist['qd_yjjc']);
		// $this->assign('dlist',$dlist);
		$this->display();	
	}
	
	//会员抢单详请
	public function qiangdanxq(){
		if($_GET){
			$userid = session('userid');
			$ulist = M('user')->where(array('userid'=>$userid))->find();
			$id = trim(I('get.id'));
			// $olist = M('userrob')->where(array('id'=>$id))->find();
			$olist = M('roborder')->where(array('id'=>$id))->find();
			$ewmlist = M('ewm')->where(array('uid'=>$userid,'ewm_price'=>$olist['price'],'ewm_class'=>$olist['class']))->find();
            $conf = M('system')->where(array('id'=>1))->find();
		$this->assign('conf',$conf);
			$this->assign('olist',$olist);
			$this->assign('ewmlist',$ewmlist);
			$this->display();
		}else{
			$this->error('未知错误',U('Index/shoudan'));
		}
		
	}

    /**
     * 自动抢单
     */
	public function qdoption()
    {
        $id = session('userid');
        $clist = M('system')->where(array('id'=>1))->field('qd_minmoney,switch')->find();
        if($clist['switch'] == 0){
            $this->ajaxReturn(['msg'=>'接单维护中,请敬请等待'],'JSON');
        }

        $today = strtotime(date("Y-m-d"),time());

//        $recharge = M('recharge')->where(array('uid'=>$id,'status'=>3,"addtime"=>array("gt",$today)))->find();
//
//        if($recharge){
//            $this->ajaxReturn(['msg'=>'当天充值当天不支持接单'],'JSON');
//        }
//        $profit = new \Util\Profit();
//        $profit->static_profit();exit;
        if(!empty(session('qdoption_time')) && time()-session('qdoption_time') < 3){
            $this->ajaxReturn(['msg'=>'操作繁忙.请稍后再试'],'JSON');
        }

        $num = I('num/d'); // 接单本金
        $type = I('type/d',0);// 类型  0 信用 1 动态
        $qdclass = I('qdclass/d',0);// 收款方式 0 微信 1 支付宝 2 银行卡
        if(empty($num) || empty($id) || $num<=0){
            $this->ajaxReturn(['msg'=>'请填写正确的数值'],'JSON');
        }
//        if(!is_int($num/100)){
//            $this->ajaxReturn(['msg'=>'开启接单必须是100的倍数'],'JSON');
//        }
        if($num < $clist['qd_minmoney']){
            $this->ajaxReturn(['msg'=>'接单最低额度'.$clist['qd_minmoney']],'JSON');
        }

//        if($num > 3000){
//            $this->ajaxReturn(['msg'=>'接单最大额度3000'],'JSON');
//        }
        session('qdoption_time',time());
        $user = D('user');
        $ulist = $user->where(array('userid'=>$id))->find();
        if(empty($ulist['usercard'])){
            $this->ajaxReturn(['msg'=>'请前往个人资料填写身份信息'],'JSON');
        }
        if(empty($ulist['activates'])){
            $this->ajaxReturn(['msg'=>'请前往个人中心激活'],'JSON');
        }
//        $roborder = D('roborder');
//        if($roborder->where(array('uid'=>$id,'status'=>2))->find()){
//            $this->ajaxReturn(['msg'=>'正在接单中,结束后再试'],'JSON');
//        }
//        if($type == 1 && $ulist['trend_money'] >= $num){
//            $key = 'trend_money';
//        }else
        if($type>=0 && $ulist['money'] >= $num){
                $key = 'money';
        }else{
            $this->ajaxReturn(['msg'=>'金额不足,无法开启接单!'],'JSON');
        }
        $ulist['class'] = $type;
        //日志
        if($user->where(array('userid'=>$id))->setDec("$key",$num)){

            if($type == 1){
                $user->where(array('userid'=>$id))->setInc("lock_money",$num);
                $billdec['info'] = '开启手动接单';
            }else{
                $billdec['info'] = '开启接单';
                //拆分订单
                $this->qd_logic($num,$ulist,$qdclass);
            }
            $user = M("user")->where("userid = {$id}")->find();
            $billdec['uid'] = $user['userid'];
            $billdec['jl_class'] = 5; //抢单
//            $billdec['info'] = '开启接单';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '-';
            $billdec['num'] = $num;
            $billdec_re = M('somebill')->add($billdec);
            $this->ajaxReturn(['status'=>1,'msg'=>'成功开启接单'],'JSON');
        }else{
            $this->ajaxReturn(['msg'=>'无法开启接单,请联系客服'],'JSON');
        }
    }


    /**
     * 抢单逻辑处理
     */
    public function qd_logic($num,$user,$qdclass)
    {
        $profit = new \Util\Profit();
        $config = M('system')->where(array('id'=>1))->field('qd_num,qd_time')->find();
        $profit->split_list($num,$config,$user,$qdclass);
    }
	
	//生成抢单订单
	public function pipeiorder(){
		if($_POST){
			$qdclass=trim(I('post.qdclass'));
			$userid = session('userid');
			$ulist = M('user')->where(array('userid'=>$userid))->find();
			$clist = M('system')->where(array('id'=>1))->find();
			if($ulist['rz_st'] != 1){
				$data['status'] = 0;
				$data['msg'] = '请先完善资料';
				$this->ajaxReturn($data);exit;
			}
			if(!$ulist['truename'] || !$ulist['usercard']){
				$data['status'] = 0;
				$data['msg'] = '请更新个人资料';
				$this->ajaxReturn($data);exit;
			}
			if($ulist['tx_status'] != 1){
				$data['status'] = 0;
				$data['msg'] = '您的账号被管理员禁止工作';
				$this->ajaxReturn($data);exit;
			}
			if($ulist['money'] > 0){
				$max_pipeinone = $ulist['money'] * ($clist['qd_cf']  / 100);
			}else{
				$max_pipeinone = 0;
			}
			
			if($max_pipeinone < $clist['qd_minmoney']){
				$data['status'] = 0;
				$data['msg'] = '最低抢单额度为'.$clist['qd_minmoney'].",余额不足请先充值";
				$this->ajaxReturn($data);exit;
			}

			/****需要添加一个未完成订单限制*******/
			$where['status'] = 1;
			$where['uid'] = $userid;
			$no_count = M('userrob')->where($where)->count();
			if($no_count ){
				$data['status'] = 0;
				$data['msg'] = '您有一条匹配订单未完成';
				$this->ajaxReturn($data);exit;
			}
			/********************/

			if($qdclass==3){
				$count_qrnum = M('bankcard')->where(array('uid'=>$userid))->count();
			}else{
				$count_qrnum = M('ewm')->where(array('uid'=>$userid,'ewm_class'=>$qdclass))->count();
			}
			
			
			
			if($qdclass == 1){
				$str = '微信收款二维码';
			}elseif($qdclass== 2){
				$str = '支付宝收款二维码';
			}


			if($qdclass==3){

				if($count_qrnum < 1){
					$data['status'] = 0;
					$data['msg'] = '请先添加收款银行卡';
					$this->ajaxReturn($data);exit;
				}

			}else{

				if($count_qrnum < 1){
					$data['status'] = 0;
					$data['msg'] = '您没有上传'.$str;
					$this->ajaxReturn($data);exit;
				}

			}
			



			$rob_re = M('userrob')->where(array("uid"=>$userid,"status"=>1))->find();
			if(!$rob_re){

				$updata['uid'] = $userid;
				$updata['class'] = $qdclass;
				$updata['price'] = $ulist['money'];
				$updata['yjjc'] = '';
				$updata['umoney'] = $ulist['money'];
				$updata['uaccount'] = $ulist['account'];
				$updata['uname'] = $ulist['truename'];
				$updata['ppid'] = '';
				$updata['status'] = 1;
				$updata['addtime'] = time();
				$updata['ordernum'] = getordernum();
				$up_re = M('userrob')->add($updata);

				$duser = M('user')->where(array("userid"=>$userid))->save(array("d_money"=>$ulist["money"],"money"=>$ulist['money'] - $ulist['money']));
				
				if($up_re && $duser){
					
					$data['status'] = 1;
					$data['msg'] = '已开始接单等待自动匹配';
					$this->ajaxReturn($data);exit;
				}else{
					
					$data['status'] = 0;
					$data['msg'] = '未知错误';
					$this->ajaxReturn($data);exit;
				}
			}else{
				$data['status'] = 0;
				$data['msg'] = '当前处于工作中~';
				$this->ajaxReturn($data);exit;
			}


			
			
			/*********这里需要区分直接匹配成功，和后台没有发布订单时的排队匹配两种情况********/
			$orderlist = M('roborder')->where(array('class'=>$qdclass,'status'=>1))->order('price asc')->select();
			
			if(!empty($orderlist)){//后台有符合条件的待匹配订单，生成一条直接匹配好的记录。
				//符合条件的最小额度的记录为$orderlist[0],所以直接匹配最小的这一条，如果最小金额的都不够匹配，同样也生成一条匹配记录，提示等待(不采用)				
				//这里写业务
				//循环匹配收款二维类型及金额都符合则匹配成功
				$ewmlist = M('ewm')->where(array('uid'=>$userid,'ewm_class'=>$qdclass))->select();
				foreach($orderlist as $k=>$v){
					foreach($ewmlist as $val){
						if($v['price'] == $val['ewm_price']){
							$st = 1;
							$pid = $v['id'];
							break;
						}
					}
				}
				if($st == '' || $st ==0){
					$pipeist = 0;
				}elseif($st == 1){
					$pipeist = 1;
				}
				
				if($pipeist == 1){//匹配成功更新后台发布的订单/生成一条匹配成功的会员匹配记录  同时减去会员账号余额，且加上佣金'qd_yjjc' 生成日录(确认后做这些操作)
					
					
					
					$tolist = M('roborder')->where(array('id'=>$pid))->find();//被匹配的这一条记录
					
					if($tolist['status'] == 1){
						
						$psave['uid'] = $userid;
						$psave['uname'] = $ulist['truename'];
						$psave['umoney'] = $ulist['money'];
						$psave['pipeitime'] = time();
						$psave['status'] = 2;
						
						$pipei_re = M('roborder')->where(array('id'=>$pid))->save($psave);
						
						if($pipei_re){
							
							$updata['uid'] = $userid;
							$updata['class'] = $qdclass;
							$updata['price'] = $tolist['price'];
							$updata['yjjc'] = $clist['qd_yjjc'];
							$updata['umoney'] = $ulist['money'];
							$updata['uaccount'] = $ulist['account'];
							$updata['uname'] = $ulist['truename'];
							$updata['ppid'] = $pid;
							$updata['status'] = 2;
							$updata['addtime'] = time();
							$updata['pipeitime'] = time();
							$updata['ordernum'] = getordernum();
							
							$up_re = M('userrob')->add($updata);
							if($up_re){
								$data['status'] = 1;
								$data['msg'] = '匹配成功';
								$this->ajaxReturn($data);exit;
							}else{
								$data['status'] = 0;
								$data['msg'] = '未知错误';
								$this->ajaxReturn($data);exit;
							}
						}else{
							$data['status'] = 0;
							$data['msg'] = '未知错误';
							$this->ajaxReturn($data);exit;
						}
					}else{
						
						$updata['uid'] = $userid;
						$updata['class'] = $qdclass;
						$updata['price'] = '';
						$updata['yjjc'] = '';
						$updata['umoney'] = $ulist['money'];
						$updata['uaccount'] = $ulist['account'];
						$updata['uname'] = $ulist['truename'];
						$updata['ppid'] = '';
						$updata['status'] = 1;
						$updata['addtime'] = time();
						
						$updata['ordernum'] = getordernum();
						$up_re = M('userrob')->add($updata);
						
						if($up_re){
							
							$data['status'] = 1;
							$data['msg'] = '已生成订单等待自动匹配';
							$this->ajaxReturn($data);exit;
						}else{
							
							$data['status'] = 0;
							$data['msg'] = '未知错误';
							$this->ajaxReturn($data);exit;
						}

					}

					
				}else{
					
					
					$erm = M('ewm')->where(array('uid'=>$userid,'ewm_price'=>array('elt',$max_pipeinone)))->order('ewm_price asc')->select();
					if(!$erm){
						$data['status'] = 0;
						$data['msg'] = '抢单额度不足';
						$this->ajaxReturn($data);exit;
					}
					
					$updata['uid'] = $userid;
					$updata['class'] = $qdclass;
					$updata['price'] = '';
					$updata['yjjc'] = '';
					$updata['umoney'] = $ulist['money'];
					$updata['uaccount'] = $ulist['account'];
					$updata['uname'] = $ulist['truename'];
					$updata['ppid'] = '';
					$updata['status'] = 1;
					$updata['addtime'] = time();
					$updata['ordernum'] = getordernum();
					$up_re = M('userrob')->add($updata);
					
					if($up_re){
						
						$data['status'] = 1;
						$data['msg'] = '已生成订单等待自动匹配';
						$this->ajaxReturn($data);exit;
					}else{
						
						$data['status'] = 0;
						$data['msg'] = '未知错误';
						$this->ajaxReturn($data);exit;
					}
				}
				
				
			}else{//后台没有符合条件的单则生成一条记录，提示等待
			
				$updata['uid'] = $userid;
				$updata['class'] = $qdclass;
				$updata['price'] = '';
				$updata['yjjc'] = '';
				$updata['umoney'] = $ulist['money'];
				$updata['uaccount'] = $ulist['account'];
				$updata['uname'] = $ulist['truename'];
				$updata['ppid'] = '';
				$updata['status'] = 1;
				$updata['addtime'] = time();
				$updata['ordernum'] = getordernum();
				$up_re = M('userrob')->add($updata);
				
				if($up_re){
					
					$data['status'] = 1;
					$data['msg'] = '已生成订单等待自动匹配';
					$this->ajaxReturn($data);exit;
				}else{
					
					$data['status'] = 0;
					$data['msg'] = '未知错误';
					$this->ajaxReturn($data);exit;
				}
				
			}

		}else{
			$data['status'] = 0;
			$data['msg'] = '非法操作';
			$this->ajaxReturn($data);exit;
			
		}
		
		
	}
	
	
	public function pipeiauto(){
		if($_POST){
			$data['status'] = 0;
			$data['msg'] = '抢单业务繁忙！';
			$this->ajaxReturn($data);exit;
		}else{
			$data['status'] = 0;
			$data['msg'] = '非法操作';
			$this->ajaxReturn($data);exit;
		}
	}




	public function returned(){

		$rid = I("rid",0,"intval");

		if(IS_POST && IS_AJAX){


			$rid = I("rid",0,"intval");
			$voucher = I("voucher");

			if($rid > 0 && $voucher){
				$robinfo = M("roborder")->where(array("id"=>$rid))->save(array("status"=>3,"is_hk"=>1,"finishtime"=>time(),"voucher"=>$voucher));

				if($robinfo){

					$data['status'] = 1;
					$data['msg'] = '确认成功，等待系统审核!';
					$this->ajaxReturn($data);exit;

				}else{
					$data['status'] = 0;
					$data['msg'] = '确认失败!';
					$this->ajaxReturn($data);exit;
				}


			}else{

				$data['status'] = 0;
				$data['msg'] = '确认失败!';
				$this->ajaxReturn($data);exit;
			}

			


		}else{

			$robinfo = M("roborder")->where(array("id"=>$rid))->find();
			// dump($robinfo);
			$this->display();

		}



	}


	public function stoporder(){
		$id = trim(intval(I('post.rid')));
		if($id > 0){

			$userid = session('userid');

			$robres = M('userrob')->where(array('id'=>$id))->find();

			if($robres['uid'] != $userid){
				$data['status'] = 0;
				$data['msg'] = '操作失败';
				$this->ajaxReturn($data);exit;
			}

			$userres = M('user')->where(array('userid'=>$userid))->find();

			$handlemoney = M('user')->where(array('userid'=>$userid))->save(array("money"=>$userres["money"] + $userres["d_money"],"d_money" =>0.00));

			$re = M('userrob')->where(array('id'=>$id))->delete();
			if($re && $handlemoney){
				$data['status'] = 1;
				$data['msg'] = '操作成功';
				$this->ajaxReturn($data);exit;
			}else{
				$data['status'] = 0;
				$data['msg'] = '操作失败';
				$this->ajaxReturn($data);exit;
			}

		}

	}
    //手动抢单
    public function manual()
    {
        $id = I('id');
//        dump($id);
        if(empty($id)){
            $data['status'] = 0;
            $data['msg'] = '异常操作';
            $this->ajaxReturn($data);exit;
        }
        $userid = session('userid');
        if(empty($id)){
            $data['status'] = 0;
            $data['msg'] = '请先登录';
            $this->ajaxReturn($data);exit;
        }
        $userres = M('user')->where(array('userid'=>$userid))->find();
        if(empty($userres)){
            $data['status'] = 0;
            $data['msg'] = '用户不存在';
            $this->ajaxReturn($data);exit;
        }
        if(!empty(session('manual')) && time()-session('manual') <3){
            $data['status'] = 0;
            $data['msg'] = '操作频繁';
            $this->ajaxReturn($data);exit;
        }
        $model = M('roborder');
        $model->startTrans();
        $robinfo = $model->lock(true)->where(array("id"=>$id,'status'=>1))->find();
        if(empty($robinfo)){
            $data['status'] = 0;
            $data['msg'] = '请稍后再试';
            $model->rollback();  // 回滚.
            session('manual',time());
            $this->ajaxReturn($data);exit;
        }
        if($userres['lock_money'] < $robinfo['price']){
//            if(empty($userres)){
                $data['status'] = 0;
                $data['msg'] = '手动接单金额不足';
                $model->rollback();  // 回滚
                $this->ajaxReturn($data);exit;
            session('manual',time());
//            }
        }
        $config = M('system')->where(array('id'=>1))->field('qd_num,qd_time')->find();

        $rdata['addtime'] = time();
        $rdata['status'] = 2;
        $rdata['uid'] = $userres['userid']; // 用户id
        $rdata['uname'] = $userres['username'];
        $rdata['pipeitime'] = time();
        $rdata['ordernum'] = $this->a_order_rand();;
        $rdata['yongjin'] = 0; //佣金计算
        $rdata['surplustime'] = time() + intval($config["s_time"])*60; //结束时间
        $rdata['endtime'] = time() + intval($config["qd_time"])*3600; //结束时间
        if($model->where(array("id"=>$id,'status'=>1))->save($rdata)){
            M('user')->where(array('userid'=>$userid))->setDec("lock_money",$robinfo['price']);
            $data['status'] = 1;
            $data['msg'] = '抢单成功';
            $model->commit();  // 提交
            session('manual',time());
            $this->ajaxReturn($data);exit;
        }else{
            $data['status'] = 0;
            $data['msg'] = '请稍后再试';
            $model->rollback();  // 回滚
            $this->ajaxReturn($data);exit;
        }
    }
    function a_order_rand()
    {
        $d = rand('1000','999999');

        if(strlen($d) == 4){
            $d = $this->aGetRandStr(2).$d;
        }elseif(strlen($d) == 5){
            $d = $this->aGetRandStr(1).$d;
        }

        return 'JZ'.$d;
    }


	// public function test(){

	// 	$a = 1;
	// 	$data = array(
	// 		'money'=>array('exp','money+'.$a),
	// 		'yongjin'=>array('exp','yongjin+'.$a),
	// 	);
	// 	$puser_inc_re = M('user')->where(array('userid'=>10))->save($data);

	// 	dump($puser_inc_re );


	// }


}