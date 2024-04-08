<?php
namespace Home\ Controller;
use Think\Controller;
class WithdrawController extends CommonController {

	//提现记录管理
    public function index(){
		$uid = session('userid');
		$welist = M('withdraw')->where(array('uid'=>$uid))->order('id desc')->select();
		$this->assign('welist',$welist);
        $this->display();
    }
	
	//提现页面
	public function tixian(){
        $uid = session('userid');
        $is_addewm = M('ewm')->where(array('uid'=>$uid,'ewm_class'=>1))->select(); //微信
        $is_addewms = M('ewm')->where(array('uid'=>$uid,'ewm_class'=>2))->select();// 支付宝
        $user = M('user')->where(array('userid'=>$uid))->find();
        $is_bank = M('bankcard')->where(array('uid'=>$uid))->select();
        $clist = M('system')->where(array('id'=>1))->find();
//        echo "<pre>";
//        print_r($is_addewm);exit;
        $this->assign('is_addewm',$is_addewm);
        $this->assign('is_addewms',$is_addewms);
        $this->assign('is_bank',$is_bank);
        $this->assign('user',$user);
        $this->assign('conf',$clist);
		$this->display();
	}
	
	//提现处理
	public function drawup(){
		if($_POST){
			$uid = session('userid');
			$ulist = M('user')->where(array('userid'=>$uid))->find();
			/*******这里写提现条件********/
			$type = I('post.type',0);//币种类型 0 信用积分 1 动态积分
			$back = I('post.back',0);//币种类型 0 银行卡 1 支付 2 微信
			$id = empty(I('post.id'))?I('post.alid'):I('post.id');//收款方式 id
            if(empty(I('post.id')) && $back == 0){
                $data['status'] = 0;
                $data['msg'] = '请选择我的地址或添加收取地址';
                $this->ajaxReturn($data);exit;
            }elseif (empty(I('post.id')) && $back == 1){
                $data['status'] = 0;
                $data['msg'] = '请在收款方式添加微信';
                $this->ajaxReturn($data);exit;
            }elseif (empty(I('post.id')) && $back == 2){
                $data['status'] = 0;
                $data['msg'] = '请在收款方式添加支付宝';
                $this->ajaxReturn($data);exit;
            }
//            if(empty($ulist['usdt_address'])){
//                $data['status'] = 0;
//                $data['msg'] = '请在个人中心添加USDT地址';
//                $this->ajaxReturn($data);exit;
//            }
            if(empty($ulist['activates'])){
                $data['status'] = 0;
                $data['msg'] = '请在个人中心激活';
                $this->ajaxReturn($data);exit;
            }
            $paypass = trim(I('post.paypass'));
            if(pwd_md5($paypass,$ulist['login_salt']) != $ulist['paypass']){
                $data['status'] = 0;
                $data['msg'] = '支付密码错误';
                $this->ajaxReturn($data);exit;
            }
			$save['uid'] = $uid;
			$save['account'] = trim(I('post.account'));
//			$save['name'] = trim(I('post.uname'));
//			$save['way'] = trim(I('post.way'));
			$save['price'] = trim(I('post.price'))+0;
			$save['addtime'] = time();
			$save['status'] = 1;
//			if($save['way'] == '微信'){
//				if($save['account'] != $ulist['wx_no']){
//					$data['status'] = 0;
//					$data['msg'] = '请使用绑定的微信账号';
//					$this->ajaxReturn($data);exit;
//				}
//
//			}elseif($save['way'] == '支付宝'){
//				if($save['account'] != $ulist['alipay']){
//					$data['status'] = 0;
//					$data['msg'] = '请使用绑定的支付宝账号';
//					$this->ajaxReturn($data);exit;
//				}
//
//			/*}elseif($save['way'] == '银行卡'){
//
//				$data['status'] = 0;
//				$data['msg'] = '没有此提现类型';
//				$this->ajaxReturn($data);exit;
//
//			}else{
//				$data['status'] = 0;
//				$data['msg'] = '没有此提现类型';
//				$this->ajaxReturn($data);exit;*/
//			}
            $save['price'] = (float)round($save['price'],2); //保留两位小数
            if($save['price'] > $ulist['money']){
                $data['status'] = 0;
                $data['msg'] = '余额不足';
                $this->ajaxReturn($data);exit;
            }
			$clist = M('system')->where(array('id'=>1))->find();
			if($save['price'] < $clist['mix_withdraw']){
				$data['status'] = 0;
				$data['msg'] = '最小提现额度'.$clist['mix_withdraw'].'元';
				$this->ajaxReturn($data);exit;
			}
			
			if($save['price'] > $clist['max_withdraw']){
				$data['status'] = 0;
				$data['msg'] = '最大提现额度'.$clist['max_withdraw'].'元';
				$this->ajaxReturn($data);exit;
			}
			
			
			// $pipei_sum_price = M('userrob')->where(array('uid'=>$uid,'status'=>3))->sum('price');
			// $rech_sum_price = M('recharge')->where(array('uid'=>$uid,'status'=>3))->sum('price');
			
			// $blz = $pipei_sum_price / $rech_sum_price;
			
			// $cblz = $clist['tx_yeb'] / 100;
			
			// if($blz < $cblz){
				
			// 	$data['status'] = 0;
			// 	$data['msg'] = '您的匹配收款额度不足';
			// 	$this->ajaxReturn($data);exit;
								
			// }
//            elseif ($type == 1 && $save['price'] > $ulist['trend_money']){
//                $data['status'] = 0;
//                $data['msg'] = '动态积分不足';
//                $this->ajaxReturn($data);exit;
//            }
            $key = 'money';
            $str = '余额';

//            if($back == 1){
//                $is_addewm = M('ewm')->where(array('id'=>$id,'uid'=>$uid))->find();
//                $save['way'] = 'USDT';
//                $save['account'] = $ulist['usdt_address']; //USDT 地址
//                $save['name'] = $is_addewm['ewm_price']; //姓名
//                $save['related'] = $is_addewm['id'];
//            }
//            else{
            if($back == 0){
                $is_addewm = M('bankcard')->where(array('id'=>$id,'uid'=>$uid))->find();
                $save['way'] = $is_addewm['bankname'];
                $save['account'] = $is_addewm['banknum'];
                $save['name'] = $is_addewm['name'];
                $save['related'] = $is_addewm['id'];
            }elseif ($back == 1 || $back == 2){
                $is_addewm = M('ewm')->where(array('id'=>$id,'uid'=>$uid))->find();
                if($back == 1){
                    $save['way'] = '微信';
                }else{
                    $save['way'] = '支付宝';
                }
                $save['account'] = $is_addewm['ewm_acc'];
                $save['name'] = $is_addewm['ewm_price'];
                $save['related'] = $is_addewm['id'];
            }else{
                $data['status'] = 0;
                $data['msg'] = '非法操作';
                $this->ajaxReturn($data);exit;
            }
            if(empty($is_addewm)){
                $data['status'] = 0;
                $data['msg'] = '无此提现方式';
                $this->ajaxReturn($data);exit;
            }
//            }
//            if(!$save['related']){
//                $data['status'] = 0;
//                $data['msg'] = '非法操作';
//                $this->ajaxReturn($data);exit;
//            }
            $save['uid'] = $uid;
//            $save['account'] = trim(I('post.account'));
//            $save['name'] = trim(I('post.uname'));
//            $save['way'] = trim(I('post.way'));
//			$save['name'] = $ulist['username'];
            $save['price'] = trim(I('post.price'));
            $save['addtime'] = time();
            $save['status'] = 1;
//            $save['type'] = $type;
			
			$ure =  M('user')->where(array('userid'=>$uid))->setDec($key,$save['price']);//直接扣除提现金额
            $billdec['uid'] = $uid;
//            $save['conversion'] = $clist['conversion']; //比例
//            $save['rmb_money'] = $save['price']/$clist['conversion']; //转化后的比例

            $billdec['jl_class'] = 4; //抢单
            $billdec['info'] = $str.'提现';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '-';
            $billdec['num'] = $save['price'];
            $billdec['related'] = $save['price']*$clist['tx_yeb'];
            $billdec['before'] = $ulist[$key];
            $billdec['after'] = $ulist[$key] - $save['price'];

            $billdec_re = M('somebill')->add($billdec);
			if($ure && $billdec_re){
                $re = M('withdraw')->add($save);
				$data['status'] = 1;
				$data['msg'] = '提现已提交';
				$this->ajaxReturn($data);exit;
			}else{
				$data['status'] = 0;
				$data['msg'] = '非法操作';
				$this->ajaxReturn($data);exit;
			}
		}else{
			$data['status'] = 0;
			$data['msg'] = '非法操作';
			ajaxReturn($data);exit;
		}
		
	}


    //提现处理
    public function transfer(){
        $uid = session('userid');
        $ulist = M('user')->where(array('userid'=>$uid))->find();
        if($_POST){
            /*******这里写提现条件********/
//
            if(empty($ulist['activates'])){
                $data['status'] = 0;
                $data['msg'] = '请在个人中心激活';
                $this->ajaxReturn($data);exit;
            }
            $save['uid'] = $uid;
            $save['account'] = trim(I('post.usdt_address'));
            $paypass = trim(I('post.paypass'));
            if(pwd_md5($paypass,$ulist['login_salt']) != $ulist['paypass']){
                $data['status'] = 0;
                $data['msg'] = '支付密码错误';
                $this->ajaxReturn($data);exit;
            }
            if($ulist['account'] == $save['account']){
                $data['status'] = 0;
                $data['msg'] = '不能给自己转账';
                $this->ajaxReturn($data);exit;
            }
            $ulists = M('user')->where(array('account'=>$save['account']))->find();
            if(empty($ulists)){
                $data['status'] = 0;
                $data['msg'] = '此账号不存在';
                $this->ajaxReturn($data);exit;
            }

            $save['price'] = trim(I('post.price'))+0;
            if(empty($save['price']) || $save['price'] <= 0){
                $data['status'] = 0;
                $data['msg'] = '转账数量错误';
                $this->ajaxReturn($data);exit;
            }
//            $save['addtime'] = time();
//            $save['status'] = 1;
            $save['price'] = (float)round($save['price'],2); //保留两位小数
            if($save['price'] > $ulist['money']){
                $data['status'] = 0;
                $data['msg'] = '余额不足';
                $this->ajaxReturn($data);exit;
            }
            $key = 'money';
            $str = '余额';
//            $save['account'] = $ulist['account']; //USDT 地址
//            $save['uid'] = $uid;
            $save['t_uid'] = $ulists['userid'];
            $save['t_account'] = $ulists['account'];
            $save['num'] = trim(I('post.price'));
            $save['addtime'] = time();
//            $save['status'] = 1;
//            $save['type'] = $type;

            $ure =  M('user')->where(array('userid'=>$uid))->setDec($key,$save['num']);//直接扣除提现金额
            $ure =  M('user')->where(array('userid'=>$ulists['userid']))->setInc($key,$save['num']);//直接扣除提现金额
            $billdec['uid'] = $uid;
            $billdec['jl_class'] = 7; //抢单
            $billdec['info'] = $str.'转账给他人';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '-';
            $billdec['num'] = $save['num'];
            $billdec['before'] = $ulist[$key];
            $billdec['after'] = $ulist[$key] - $save['num'];
            $billdec_re = M('somebill')->add($billdec);
            $billdecs['uid'] = $ulists['userid'];
            $billdecs['jl_class'] = 8; //抢单
            $billdecs['info'] = $str.'转账收入';
            $billdecs['addtime'] = time();
            $billdecs['jc_class'] = '+';
            $billdecs['num'] = $save['num'];
            $billdecs['before'] = $ulists[$key];
            $billdecs['after'] = $ulists[$key] - $save['num'];

            $billdec_re = M('somebill')->add($billdecs);
            if($ure && $billdec_re){
                $re = M('transfer')->add($save);
                $data['status'] = 1;
                $data['msg'] = '转账成功';
                $this->ajaxReturn($data);exit;

            }else{
                $data['status'] = 0;
                $data['msg'] = '非法操作';
                $this->ajaxReturn($data);exit;

            }
        }else{
            $this->assign('user',$ulist);
            $this->display();
//            $data['status'] = 0;
//            $data['msg'] = '非法操作';
//            ajaxReturn($data);exit;
        }
    }
}