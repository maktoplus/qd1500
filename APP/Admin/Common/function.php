<?php 

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author jry <bbs.sasadown.cn>
 */
function is_login()
{
    return D('Admin/Manage')->is_login();
}

function commission($price,$type)
{
    $yj = M("system")->where(array("id"=>1))->find();
    if($type == 1){
    	$yjprice = number_format($price*$yj["qd_wxyj"],2);
    }elseif($type == 2){
    	$yjprice = number_format($price*$yj["qd_zfbyj"],2);
    }elseif($type == 3){
    	$yjprice = number_format($price*$yj["qd_bkyj"],2);
    }

    return $yjprice;
}

function level_up($user){
    $ulist = M('user')->where("userid in ($user)")->where("use_grade = 1 and static_profit > 0")->select();
    if(empty($ulist)){
        return true;
    }
    $config = M('system')->where(array('id'=>1))->field('user_money,user_num')->find();
    foreach ($ulist as $user){
        if($user['total_recharge'] >= $config['user_money']){
            if(for_user($user['userid'],$config['user_num'])){
                M("user")->where("userid = {$user['userid']}")->setInc(['use_grade']);
            }
        }
    }
    return true;
}

function for_user($user_id)
{
        $arr = [];
        $num = 100;
        for($i = 0;$i<$num;$i++){
            $user = M("user")->where("pid in ($user_id)")->data('userid')->select();
            if($i != 0){
                $arr[$i] = $user_id;
            }
            if(empty($user)){
                return implode($arr);
            }
            $user_id = '';
            foreach ($user as $val){
                if(empty($user_id)){
                    $user_id.=$val['userid'];
                }else{
                    $user_id.=','.$val['userid'];
                }
            }
//            $user_id = implode(',',$user);
        }
}


function getewminfo($id,$price,$type){
	
	$list = M('ewm')->where(array('uid'=>$id,'ewm_price'=>$price))->find();
	
	if($type == 1){
		return $list['ewm_acc'];//返回收款账号
	}elseif($type == 2){
		return $list['uname'];//返回收款账号姓名
	}elseif($type == 3){
		return $list['ewm_url'];
	}
}

function getclass($class){
	if($class == 1){
		$str = '微信收款';
	}elseif($class == 2){
		$str = '支付宝收款';
	}elseif($class == 3){
		$str = '银行收款';
	}
	
	return $str;
}


function getusermoney($id){
	$list = M('user')->where(array('userid'=>$id))->find();
	return $list['money'];
}

function getst($n){
	
	if($n==1){
		return  '待处理';
	}elseif($n==2){
		return  '已退回';
	}elseif($n==3){
		return  '已完成';
	}
	
	
}

function getstatus($n){
	
	if($n==1){
		return  '工作中';
	}elseif($n==2){
		return  '已结束';
	}elseif($n==3){
		return  '已完成';
	}elseif($n==4){
		return  '已失效';
	}
	
	
}

function getuserinfo($uid,$type){
	$ulist = M('user')->where(array('userid'=>$uid))->find();
	if($type==1){
		return $ulist['username'];
	}elseif($type==2){
		return $ulist['account'];
	}
}



function build_phone($phone_t){
	
	$phone_h = $phone_t;
	$phone_c = rand(00000000,99999999);
	$b_phone = $phone_h.$phone_c;
	 return  $b_phone;
	
}


function build_uname($leng){
	$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	if(!is_int($leng) || $leng < 0) {
         return false;
     }
 
     $string = '';
     for($i = $leng; $i > 0; $i--) {
         $string .= $str[mt_rand(0, strlen($str) - 1)];
     }
 
     return 'B'.$string;
}


function md5pwd($value, $salt)
	{
		$user_pwd = md5(md5($value) . $salt);
		return $user_pwd;
	}
	
function getSjuser($uid){
	$list = M('user')->where(array('userid'=>$uid))->find();
	return $list['account'];
}

/*随机生成订单号*/
function getordernum($length = 12, $char = '0123456789') {
	if(!is_int($length) || $length < 0) {
         return false;
    }
     $string = '';
    for($i = $length; $i > 0; $i--) {
         $string .= $char[mt_rand(0, strlen($char) - 1)];
    }
     return 'N'.$string;
}

/**
 * 字节格式化
 * @access public
 * @param string $size 字节
 * @return string
 */
function byte_Format($size) {
    $kb = 1024;          // Kilobyte
    $mb = 1024 * $kb;    // Megabyte
    $gb = 1024 * $mb;    // Gigabyte
    $tb = 1024 * $gb;    // Terabyte

    if ($size < $kb)
        return $size . 'B';

    else if ($size < $mb)
        return round($size / $kb, 2) . 'KB';

    else if ($size < $gb)
        return round($size / $mb, 2) . 'MB';

    else if ($size < $tb)
        return round($size / $gb, 2) . 'GB';
    else
        return round($size / $tb, 2) . 'TB';
}


/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $m 模型，引用传递
 * @param $where 查询条件
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage(&$m,$where,$pagesize=10){
    $m1=clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m=$m1;//为保持在为定的连惯操作，浅复制一个模型
    $p=new Think\PageAdmin($count,$pagesize);
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
function getpagee($count, $pagesize = 10) {
	$p = new Think\Page($count, $pagesize);
	$p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
	$p->setConfig('prev', '上一页');
	$p->setConfig('next', '下一页');
	$p->setConfig('last', '末页');
	$p->setConfig('first', '首页');
	$p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
	$p->lastSuffix = false;//最后一页不显示为总页数
	return $p;
}
//密码加密
function pwd_md5($value, $salt){
	$user_pwd = md5(md5($value) . $salt);
	return $user_pwd;
}
//获取 会员昵称
function getmyname($id){
	$list = M('user')->where(array('userid'=>$id))->find();
	return $list['username'];
}
//获取会员账号
function getmyphone($id){
	$list = M('user')->where(array('userid'=>$id))->find();
	return $list['account'];
}





//按日期搜索
function date_query($field){

        $date_start=I('date_start');
        $date_end=I('date_end');
        if(!empty($date_start) && !empty($date_end) && ($date_start == $date_end)){
            $map["FROM_UNIXTIME(".$field.",'%Y-%m-%d')"]=$date_end;
        }
        else if($date_start!='' && $date_end!='' && $date_start !=$date_end){
            $map[$field]=array('between',array(strtotime($date_start),strtotime($date_end)+86400));
        }
        else if($date_start!='' && empty($date_end)){
            $map[$field]=array('gt',strtotime($date_start)+86400);
        }
        else if(empty($date_start) && $date_end!=''){
            $map[$field]=array('lt',strtotime($date_end)+86400);
        }
        if($map)
            return $map;
}

function do_send_mobile_code($mobile,$content){


	$statusStr = array(
			"0" => "短信发送成功",
			"-1" => "参数不全",
			"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
			"30" => "密码错误",
			"40" => "账号不存在",
			"41" => "余额不足",
			"42" => "帐户已过期",
			"43" => "IP地址限制",
			"50" => "内容含有敏感词"
		);	
	$smsapi = "http://www.smsbao.com/"; //短信网关
	$user = "yhsceo1"; //短信平台帐号
	$pass = md5("q123789q."); //短信平台密码
	$content="【订单提醒】 您的订单已派发，请登录平台及时查询及时处理，以免超时。";//要发送的短信内容
	// $phone = "*****";
	$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$mobile."&c=".urlencode($content);
	$result =file_get_contents($sendurl) ;
	return $statusStr[$result];

	// $uid = 'lalass';
	// $pwd = '123456';
	// $url="http://api.eait.cn/Sms/SmsHttp_U.aspx?Action=SendMessage&UserId=".$uid."&UserPwd=".$pwd."&SendPhone=".$mobile."&SendMessage=".$content;
	// $res=file_get_contents($url);
	// return $res;
}


/**
 * 生成随机字符串（数字字母小写）
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr_s($lenth = 9) {

	$str = "0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ";
	$rand="";
    for($i=0; $i<$lenth-1; $i++){
        $rand .= $str[mt_rand(0, strlen($str)-1)];  //如：随机数为30  则：$str[30]
    }
	return $rand;

}

function a_order_rand()
{

    $d = rand('1000','999999');

    if(strlen($d) == 4){
        $d = aGetRandStr(2).$d;
    }elseif(strlen($d) == 5){
        $d = aGetRandStr(1).$d;
    }

    return $d;
}



function aGetRandStr($len) {
    $chars = array(
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = '';
    for ($i = 0; $i < $len; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}