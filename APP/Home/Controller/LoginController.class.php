<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller
{
    /**
     * 登陆
     */
    public function login()
    {
        //判断网站是否关闭
        $close=is_close_site();
        if($close['value']==0){
            $this->assign('message',$close['tip'])->display('closesite');
        }else{
            $this->display();
        }
    }






    //注册
	/**GG Bond 更新2019.01.21**/
	public function register(){
		if(IS_AJAX){
//			dump(I('post.'));exit;
			$u_yqm = trim(I('post.pid'));
			$sonelist = M('user')->where(array('u_yqm'=>$u_yqm))->find();
			if(empty($sonelist)){
				$re_data['status'] = 0;
				$re_data['message'] = "推荐人不存在！";				
				 $this->ajaxReturn($re_data);exit;
			}
			
//            $cdkey = trim(I('post.cdkey'));
//            $cdkeyres = M('cdkey')->where(array('cdkey'=>$cdkey,'status'=>0))->find();
//            if(empty($cdkeyres)){
//                $re_data['status'] = 0;
//                $re_data['message'] = "注册码无效或已被使用！";
//                 $this->ajaxReturn($re_data);exit;
//            }


			$username = trim(I('post.username'));
			$mobile = trim(I('post.mobile'));
			$sms_code = trim(I('post.sms_code'));
			$login_pwd = trim(I('post.login_pwd'));
			$paypass = trim(I('post.paypassword'));
            $session_id = I('unique_id' , session_id());
			//$safety_pwd = trim(I('post.safety_pwd'));
//            $code = M('sms_log')->where(array('mobile'=>$mobile,'session_id'=>$session_id, 'status'=>1))->order('id DESC')->find();
//            if(empty($code)){
//                $re_data['status'] = 0;
//                $re_data['message'] = "请发送验证码";
//                $this->ajaxReturn($re_data);exit;
//            }
//            if($sms_code != $code['code']){
//                $re_data['status'] = 0;
//                $re_data['message'] = "验证码错误";
//                $this->ajaxReturn($re_data);exit;
//            }

			$salt = strrand(4);
			$cuser= M('user')->where(array('account'=>$mobile))->find();
			$muser= M('user')->where(array('mobile'=>$mobile))->find();
			if(!empty($cuser) || !empty($muser)){
				$re_data['status'] = 0;
				$re_data['message'] = "手机号已经被注册";																			
				$this->ajaxReturn($re_data);exit;	
			}
			$data['pid'] = $sonelist['userid'];
			$data['gid'] = $sonelist['pid'];
			$data['ggid'] = $sonelist['gid'];
			$data['account'] = $mobile;
			$data['mobile'] = $mobile;
			$data['u_yqm'] = strrand();
			$data['username'] = $username;
			$data['login_pwd'] = pwd_md5($login_pwd,$salt);
			$data['paypass'] = pwd_md5($paypass,$salt);
			$data['login_salt'] = $salt;
			$data['reg_date'] = time();
			$data['reg_ip'] = get_userip();
			$data['status'] = 1;	
//            $data['cdkey_id'] = $cdkeyres["id"];
			$path=$sonelist['path'];      
            if(empty($path)){
                $data['path']='-'.$sonelist['userid'].'-';
            }else{
                $data['path']=$path.$sonelist['userid'].'-';
            }
			//$data['user_credit']= 5;
			$data['use_grade']= 0;
			$data['u_ztnum']= 0;	
			$data['tx_status']= 1;	
			
			$ure_re = M('user')->add($data);

			if($ure_re){
//                M('cdkey')->where(array("id"=>$cdkeyres["id"]))->save(array("uid"=>$ure_re,"status"=>1));
				if($sonelist['pid'] != '' || $sonelist['pid'] != 0){
					M('user')->where(array('userid'=>$sonelist['userid']))->setInc('u_ztnum',1);//增加会员直推数
				}
//                $arrid =explode('-',$data['path']);
//                $key = count($arrid);
//                unset($arrid[$key-1]);
//                unset($arrid[0]);
//                unset($arrid[1]);
//                if(!empty($arrid)){
//                    $arrid = implode(',',$arrid);
//                    level_up($arrid);
//                }
				$re_data['status'] = 1;
				$re_data['message'] = "注册成功!";																			
				$this->ajaxReturn($re_data);exit;		
			}else{
				$re_data['status'] = 1;
				$re_data['message'] = "网络错误";																			
				$this->ajaxReturn($re_data);exit;	
			}	
		}else{
			$yqm = I('get.mobile');
			if($yqm != ''){
				$this->assign('mobile',$yqm);
			}
			 $this->display();

		}
	}
	
	

	//登陆
	/**GG Bond 更新2019.01.21**/
    public function checkLogin(){
        if (IS_AJAX) {
            $account = I('account');
            $password = I('password');
        
            // 验证用户名密码是否正确
            $user_object = D('Home/User');
            $user_info   = $user_object->login($account, $password);
            if (!$user_info) {
                ajaxReturn($user_object->getError(),0);
            }
            session('account',$account,86400);



             $user_info   = $user_object->Quicklogin($account);
            if (!$user_info) {
                ajaxReturn($user_object->getError(),0);
            }
            // 设置登录状态
            $uid = $user_object->auto_login($user_info);
            // 跳转
            if (0 < $uid && $user_info['userid'] === $uid) {
                session('userid',$uid);
                session('in_time',time(),86400);
                ajaxReturn('登录成功',1,U('User/index'));
            }
        }
    }

    /**
     * 注销
     * 
     */
    public function logout()
    {   
        cookie('msg',null);
        session(null);
        $this->redirect('Login/login');
    }


    public function blacklist()
    {   
        $uid = session('userid');
        cookie('msg',null);
        session(null);
        $st = M("user")->where(array("userid"=>$uid))->save(array("status"=>0));
        if($st){
            $this->redirect('Login/login');
        }else{
            $this->redirect('Login/login');
        }
        
    }

    /**
     * 图片验证码生成，用于登录和注册
     * 
     */
    public function verify()
    {
        set_verify();
    }


    //找回密码
    public function getpsw(){
        
        $this->display();
    }

    public function setpsw(){
        if(!IS_AJAX)
            return ;

        $mobile=I('post.mobile');
        $code=I('post.code');
        $password=I('post.password');
        $reppassword=I('post.passwordmin');
        if(empty($mobile)){
            ajaxReturn('手机号码不能为空');
        }
        if(empty($code)){
            ajaxReturn('验证码不能为空');
        }
        if(empty($password)){
            ajaxReturn('密码不能为空');
        }
        if($password  != $reppassword){
            ajaxReturn('两次输入的密码不一致');
        }

        if(!check_sms($code,$mobile)){
            ajaxReturn('验证码错误或已过期'); 
        }

        $user=D('User');
        $mwhere['mobile']=$mobile;
        $userid=$user->where($mwhere)->getField('userid');
        if(empty($userid)){
            ajaxReturn('手机号码错误或不在系统中');
        }

        $where['userid']=$userid;
        //密码加密
        $salt=user_salt();
        $data['login_pwd']=$user->pwdMd5($password,$salt);
        $data['login_salt']=$salt;
        $res=$user->field('login_pwd,login_salt')->where($where)->save($data);
        if($res){
            session('sms_code',null);
            ajaxReturn('修改成功',1,U('Login/logout'));
        }
        else{
            ajaxReturn('修改失败');
        }

    }

    //返佣金窗口
    public function profit_money()
    {
        $profit = new \Util\Profit();
        $profit->static_profit();exit;
    }

    public function ceshi()
    {
        dump(update_level(1));
    }


    public function is_returned(){


        $list = M("roborder")->where(array("status"=>2,"is_hk"=>0))->select();
        foreach ($list as $key => $value) {
            if(time() > $value["surplustime"]){

                $unfreeze = M("user")->where(array("userid"=>$value["uid"],"status"=>1))->find();

                if($unfreeze["unfreeze_expire"] && $unfreeze["unfreeze_expire"] < time()){

                    $res = M("user")->where(array("userid"=>$value["uid"]))->save(array("status"=>0));

                    $now_time = time();
                    if($res){

                        echo "Now Time:$now_time \n";
                        echo "Unfreeze UserId: ".$value["uid"]." Have been frozen \n";
                        echo "========================================== \n";
                        
                    }

                }elseif(!$unfreeze["unfreeze_expire"]){

                    $res = M("user")->where(array("userid"=>$value["uid"]))->save(array("status"=>0));

                    $now_time = time();
                    if($res){

                        echo "Now Time:$now_time \n";
                        echo "UserId: ".$value["uid"]." Have been frozen \n";
                        echo "========================================== \n";
                    }
                }
            }
        }
    }

    /**
     * 前端发送短信方法: APP/WAP/PC 共用发送方法
     */
    public function send_validate_code(){

//        $this->send_scene = C('SEND_SCENE');
//
//        $type = I('type');
        $scene = I('type',1);    //发送短信验证码使用场景
        $mobile = I('mobile');
//        $sender = I('send');
        if(empty($mobile)){
            ajaxReturn('请输入手机号');
        }
        $verify_code = I('verify_code');
//        $mobile = $mobile;
        $session_id = I('unique_id' , session_id());
//        session("scene" , $scene);
        //注册
//        if($scene == 1 && !empty($verify_code)){
//            $verify = new Verify();
//            if (!$verify->check($verify_code, 'user_reg')) {
//                ajaxReturn(array('status'=>-1,'msg'=>'图像验证码错误'));
//            }
//        }
//        if($type == 'email'){
//            //发送邮件验证码
//            $logic = new UsersLogic();
//            $res = $logic->send_email_code($sender);
//            ajaxReturn($res);
//        }else{
            //发送短信验证码
//            $res = checkEnableSendSms($scene);
//            if($res['status'] != 1){
//                ajaxReturn($res);
//            }
            //判断是否存在验证码
            $data = M('sms_log')->where(array('mobile'=>$mobile,'session_id'=>$session_id, 'status'=>1))->order('id DESC')->find();
            //获取时间配置
//            $sms_time_out = tpCache('sms.sms_time_out');
//            $sms_time_out = $sms_time_out ? $sms_time_out : 120;
            //120秒以内不可重复发送
            if($data && (time() - $data['add_time']) < 60){
                $return_arr = array('status'=>-1,'msg'=>'60秒内不允许重复发送');
                ajaxReturn($return_arr);
            }
            //随机一个验证码
            $code = rand(100000, 999999);
            $params['code'] =$code;
            //发送短信

            session('pwdOutTime',time()+120); // 存储当前时间

//            $resp = sendSms($mobile , $params, $session_id);
            $resp = $this->sendCode($mobile,$scene,$code);
            if($resp['status'] == 1){
                M('sms_log')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => $session_id, 'status' => 1, 'scene' => $scene));

//                M('sms_log')->where(array('mobile'=>$mobile,'code'=>$code,'session_id'=>$session_id , 'status' => 0))->save(array('status' => 1));
                $return_arr = array('status'=>1,'msg'=>'发送成功,请注意查收');
            }else{
                $return_arr = array('status'=>-1,'msg'=>'发送失败'.$resp['msg']);
            }
            ajaxReturn($return_arr);
    }

    /**
     * 发送短信验证码
     */
    public function sendCode($account,$type,$code)
    {
//        $account = trim(I('post.account'));
//        $type = (int)I('post.type'); // 类型 1：注册 2：找回密码 3：找回支付密码
//        if (empty($account)) $this->ajaxError("请输入手机号！");
//        // 账号错误
//        if (!isPhone($account)) return $this->ajaxError("请输入正确格式的手机号！");
//        // 如果已经
//        if (!empty(parent::get("REG_CODE_TIME")) && time() - parent::get("REG_CODE_TIME") < 60) return $this->ajaxError("请求发送短信间隔太短！");
//        if (!empty(parent::get("FORGET_CODE_TIME")) && time() - parent::get("FORGET_CODE_TIME") < 60) return $this->ajaxError("请求发送短信间隔太短！");
//        if (!empty(parent::get("FORGET_PAYCODE_TIME")) && time() - parent::get("FORGET_PAYCODE_TIME") < 60) return $this->ajaxError("请求发送短信间隔太短！");

//        $code = rand(100000, 999999);
//        $smsParams = array(
//            1 => "{\"code\":\"$code\"}",                                                                                                          //1. 用户注册 (验证码类型短信只能有一个变量)
//        );
//        sendSmsByAliyun(13428854912,'BMI钱包',$smsParams[1],'SMS_143719111');
//        exit;
        // 获取配置
//        $sms = tpCache('sms');
//        if(!$sms) return array('msg'=>"没有配置短信");

//        $url = $sms['url'];
//        $key = $sms['key'];
//        $tplId = $sms['tplId'];

        $url = 'http://v.juhe.cn/sms/send';
        $key ='0837d33c1e1020f542d5f8a4757112e0';
        if(2== $type){
            $tplId = 202979;
        }elseif (1 == $type){
            $tplId = 202978;
        }
//        202978 注册 202979 通用 202980 修改密码
//        $code = rand(100000, 999999);

//        if (1 == $type) {
////            $account_occupy = M("member")->where(array("account"=>$account))->find();
////            if ($account_occupy) array('msg'=>"手机号已被使用！");
//            parent::set("REG_CODE", $code);
//            parent::set("REG_MOBILE", $account);
//            parent::set("REG_CODE_TIME", time());
//        } else if (2 == $type) {
//            parent::set("FORGET_CODE", $code);
//            parent::set("FORGET_MOBILE", $account);
//            parent::set("FORGET_CODE_TIME", time());
//        } else if (3 == $type) {
//            parent::set("FORGET_PAY_CODE", $code);
//            parent::set("FORGET_PAY_MOBILE", $account);
//            parent::set("FORGET_PAYCODE_TIME", time());
//        }

        $smsCfg = array(
            'key' => $key,
            'mobile' => $account,
            'tpl_id' => $tplId,
            'tpl_value' => '#code#=' . $code
        );

        //请求发送短信
        $content = $this->juhecurl($url, $smsCfg, 1);

        if ($content) {
            $result = json_decode($content, true);
            $error_code = $result['error_code'];
            if ($error_code == 0) {
                return array('status'=>1,'msg'=>"发送成功！");
            } else {
                //状态非0，说明失败
                return array('msg'=>"请求发送短信失败:" . $error_code);
            }
        } else {
            //返回内容异常，以下可根据业务逻辑自行修改
            return array('msg'=>"请求发送短信失败！");
        }
    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    function juhecurl($url, $params = false, $ispost = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        if ($response === FALSE) {
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}
