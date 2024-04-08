<?php
// +----------------------------------------------------------------------
// | 零云 [ 简单 高效 卓越 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lingyun.net All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <59821125@qq.com>
// +----------------------------------------------------------------------
namespace Util;

/**
 *收益相关方法
 * Class Profit
 * @package Util
 */
class Profit
{
    // 拆分订单
    public function split_list($num = 10000,$config,$urobres,$qdclass)
    {
        $data['umoney'] = $num;
        $data['price'] = $num;
        $total_money=$num;
        $total_num=$config['qd_num'];
        $total_money=$total_money - $total_num;
        for($i=$total_num;$i>0;$i--){
            $arr[$i]['num']=1;
            $ls_money=0;
            if($total_money>0){
                if($i==1){
                    $arr[$i]['num'] +=$total_money;
                }else{
                    $max_money=floor($total_money/$i);
                    $ls_money=mt_rand(0,$max_money);
                    $arr[$i]['num']+=$ls_money;
                }
            }
            $total_money -= $ls_money;
        }
//        echo "<pre>";
//        print_r($arr);exit;
//        $split_num = round($num/$config['qd_num']); // 平均差分的数值;
//        $len = strlen($split_num)-1;
//        $min = $split_num*0.9;
//        $max = $split_num*1.1;
//        $arr = [];
//        for ($i = 0;$i<$config['qd_num'];$i++){
//
//            if($i == $config['qd_num']-1){
//                $int = $num;
//            }else{
//                $ramd = mt_rand($min,$max); //随机出来的数字
//                if(strlen($ramd) == $len){
//                    $int = substr($ramd,0,$len-1);
//                }
//                if(strlen($ramd) > $len){
//                    $int = substr($ramd,0,$len);
//                }
//                if(strlen($ramd) < $len){
//                    $int = substr($ramd,0,$len-2);
//                }
//                //$int = substr($ramd,0,$len).'0';
//            }
//            $num = $num-$int;
//            $arr[$i]['num'] = $int;
//        }
//        echo "<pre>";
//        print_r($arr);exit;
        $price = json_encode($arr); //分别拆分的数值
        $ordernum = $this->a_order_rand();
//        $data['class'] = $urobres['class'];
        $data['class'] = $qdclass;
       // $data['class'] = 3;
        $data['prices'] = $price;
        $data['addtime'] = time();
        $data['status'] = 2;
        $data['uid'] = $urobres['userid']; // 用户id
        $data['uname'] = $urobres['username'];

        $data['pipeitime'] = time();
        $data['ordernum'] = $ordernum;
        $data['yongjin'] = 0; //佣金计算
        $data['surplustime'] = time() + intval($config["s_time"])*60; //结束时间
        $data['endtime'] = time() + intval($config["qd_time"])*3600; //结束时间
        $reid = M('roborder')->add($data);
        return true;
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

    /**
     * 静态收益
     * 每分钟触发 要把订单的时间统一去掉秒
     */
    public function static_profit()
    {
        $config = M('system')->where(array('id'=>1))->find();
        $user_money = json_decode($config['user_money']);
        $cnd = 3600;
//        $time = time()+($config['qd_time']*3600);
//        $where="addtime BETWEEN {$start} AND {$end}";
        $order_list = M('roborder')->where(['status' =>2,'pipeitime'=>['lt',time()]])->select();
//        dump($order_list);
        if(empty($order_list)){
            return true;
        }
        //静态收益
//        $config['static_profit'];
        foreach($order_list as $value){
            //获取分钟  每分钟定时触发
            $time = date('Y-m-d H:i:').'00';
            $time= strtotime($time);
            //获取分钟  每分钟定时触发
            $value['update_time'] = substr(date('Y-m-d H:i:s',$value['pipeitime']),0,-2);
            $value['update_time'] = $value['update_time'].'00';
            $value['update_time']= strtotime($value['update_time']);
//            整数
//            dump($time);
            $prices = json_decode($value['prices'],true);
//            dump($prices);
//            dump($value['update_time']);
//            $number = ($time-$value['update_time']);
            $number = ($time-$value['update_time'])/$cnd;
//            $number = round($number);
            if(empty($number) || $number > $config['qd_time'] || !is_int($number)){
//            if(empty($number) || $number > $config['qd_time'] ){
                continue;
            }


            //原 num 改 umoney  变动原因： 提现会扣除相对于的金额
            $user = M("user")->where("userid = {$value['uid']}")->find();
            if($user['use_grade'] == 0){
                $yjjc = $config['qd_yjjc'];
            }else{
                $yjjc =  $user_money[$user['use_grade']-1];
            }
            $money = $prices[$number]['num']*$yjjc;
//            $money = $prices[$number]*$yjjc/$config['qd_time'];
            if($money < 0.0001){
                continue;
            }
//            dump($money);exit;
            if($user){
                // $price = $prices[$number]['num']+$money;
                M("user")->where("userid = {$value['uid']}")->setInc('money',$money);
                 M("user")->where("userid = {$value['uid']}")->setInc('money',$prices[$number]['num']);
//            M("user")->where("userid = {$value['userid']}")->setInc('total_static_profit',$money);
//            M("user")->where("userid = {$value['userid']}")->setInc('principal_profit',$money);
                M("user")->where("userid = {$value['uid']}")->setInc('zsy',$money);
                M("user")->where("userid = {$value['uid']}")->setInc('static_profit',$money);
                //日志
                $billdec['uid'] = $user['userid'];
                $billdec['jl_class'] = 1; //抢单
                $billdec['info'] = '接单利息';
                $billdec['addtime'] = time();
                $billdec['jc_class'] = '+';
                $billdec['num'] = $money;
                $billdec['before'] = $user['money'];
                $billdec['after'] = $user['money'] + $money;

                $billdec_re = M('somebill')->add($billdec);
//                if(!empty($user['pid']) && $billdec_re){
//                    $this->second_profit($user['pid'],array($money,$value['umoney']),$config); //返推荐人
//                    if(!empty($user['gid'])){
//                        $this->total_profit($user['gid'],$value['umoney'],$config); //返团队
//                    }
//                }
                if($number == 8){
                    M('roborder')->where("id = {$value['id']}")->save(['status'=>3]);
                    if(!empty($user['pid'])){
                    	$user_money['qd_yjjc'] = $config['qd_yjjc'];
                    	$this->levle_profit($user['pid'],$user_money,$user['use_grade'],$value['umoney']);

                	}
                }
//                else{
                    M('roborder')->where("id = {$value['id']}")->setInc('yongjin',$money);
//                }
                $prices[$number]['yongjin'] = $money;
                $prices = json_encode($prices);
                M('roborder')->where("id = {$value['id']}")->save(['prices'=>$prices]);
                

//                if($user['use_grade'] == 0){
//                    //升级成不同会员
//                    M('user')->where("userid = {$value['uid']}")->save(['use_grade'=>1]);
//                    update_level($user['pid']); //升级成组长
//                }
            }
            //生成日志
//            balancelogs($value['userid'],$value['userid'],$money,6,$user['principal'],$user['principal']+$money,'静态收益',$value['id']);
        }
    }

    /**
     * 静态收益
     * 每分钟触发 要把订单的时间统一去掉秒
     */
    public function static_profits()
    {
        $config = M('system')->where(array('id'=>1))->find();
        $user_money = json_decode($config['user_money']);
//        $cnd = 1;
        $time = time()+($config['qd_time']*3600);
//        $where="addtime BETWEEN {$start} AND {$end}";
        $order_list = M('roborder')->where(['status' =>2,'endtime'=>['lt',time()]])->select();
//        dump($order_list);exit;
        if(empty($order_list)){
            return true;
        }
        //静态收益
//        $config['static_profit'];
        foreach($order_list as $value){
            //获取分钟  每分钟定时触发
//            $time = date('Y-m-d H:i:').'00';
//            $time= strtotime($time);
//            //获取分钟  每分钟定时触发
//            $value['update_time'] = substr($value['endtime'],0,-2);
//            $value['update_time'] = $value['endtime'].'00';
//            $value['update_time']= strtotime($value['endtime']);
            //整数
//            dump($time);
//            dump($value['update_time']);
//            $number = ($time-$value['endtime'])/$cnd;

//            if(empty($number) || $number > $config['static_profit_time'] || !is_int($number)){
//                continue;
//            }
            //原 num 改 umoney  变动原因： 提现会扣除相对于的金额
            $user = M("user")->where("userid = {$value['uid']}")->find();
            if($user['use_grade'] == 0){
                $yjjc = $config['qd_yjjc'];
            }else{
                $yjjc =  $user_money[$user['use_grade']-1];
            }
            $money = $value['umoney']*$yjjc;
            if($money < 0.01){
                continue;
            }

            if($user){
                $price = $value['umoney']+$money;
                M("user")->where("userid = {$value['uid']}")->setInc('money',$price);
//            M("user")->where("userid = {$value['userid']}")->setInc('total_static_profit',$money);
//            M("user")->where("userid = {$value['userid']}")->setInc('principal_profit',$money);
                M("user")->where("userid = {$value['uid']}")->setInc('zsy',$money);
                M("user")->where("userid = {$value['uid']}")->setInc('static_profit',$money);
                //日志
                $billdec['uid'] = $user['userid'];
                $billdec['jl_class'] = 1; //抢单
                $billdec['info'] = '接单利息';
                $billdec['addtime'] = time();
                $billdec['jc_class'] = '+';
                $billdec['num'] = $money;
                $billdec['before'] = $user['money'];
                $billdec['after'] = $user['money'] + $money;

                $billdec_re = M('somebill')->add($billdec);
//                if(!empty($user['pid']) && $billdec_re){
//                    $this->second_profit($user['pid'],array($money,$value['umoney']),$config); //返推荐人
//                    if(!empty($user['gid'])){
//                        $this->total_profit($user['gid'],$value['umoney'],$config); //返团队
//                    }
//                }
                M('roborder')->where("id = {$value['id']}")->save(['status'=>3,'yongjin'=>$money]);
//                if($user['use_grade'] == 0){
//                    //升级成不同会员
//                    M('user')->where("userid = {$value['uid']}")->save(['use_grade'=>1]);
//                    update_level($user['pid']); //升级成组长
//                }
            }

            //生成日志
//            balancelogs($value['userid'],$value['userid'],$money,6,$user['principal'],$user['principal']+$money,'静态收益',$value['id']);
        }
    }

    /**
     * 返推荐人收益
     */
    public function second_profit($user_id,$num,$config)
    {
        return false;
        $system = json_decode($config['user_profit'],true);
        $clist = M('user')->where(array('userid'=>$user_id))->find();
        if($clist['use_grade'] == 0){
            return true;
        }elseif ($clist['use_grade'] == 1){
            if($robor = M('roborder')->where("uid = {$user_id}")->order('price desc')->find()){
                if($robor['price'] < $num[1]){
                    $num[1] = $robor['price'];
                }
            }else{
                return true;
            }
            //普通会员
            $money = $system[0]*$num[1];
        }else{
            if($robor = M('roborder')->where("uid = {$user_id}")->order('price desc')->find()){
                if($robor['price'] < $num[1]){
                    $num[1] = $robor['price'];
                }
            }else{
                return true;
            }
            //组长
            $money = $system[1]*$num[1];
        }
        if($money >= 0.01 && !empty($money)){
            M("user")->where("userid = $user_id")->setInc('total_profit',$money);
            M("user")->where("userid = $user_id")->setInc('zsy',$money); //金额加入动态余额
            M("user")->where("userid = $user_id")->setInc('trend_money',$money); //金额加入动态余额
            //生产日志
            //日志
            $billdec['uid'] = $user_id;
            $billdec['jl_class'] = 2; //抢单
            $billdec['info'] = '直推接单奖励';
            $billdec['addtime'] = time();
            $billdec['jc_class'] = '+';
            $billdec['num'] = $money;
            $billdec['before'] = $clist['trend_money'];
            $billdec['after'] = $clist['trend_money']+$money;
            $billdec_re = M('somebill')->add($billdec);
        }
    }

    /**
     * 团队动态收益
     */
    public function total_profit($user_id,$num,$config){
        return false;
        $system = json_decode($config['total_profit'],true);
        for ($i = 0;$i<4;$i++){
            $clist = M('user')->where(array('userid'=>$user_id))->find();
            if($clist['use_grade'] != 2 && empty($clist['pid'])){
                return true;
            }elseif ($clist['use_grade'] != 2){
                $user_id = $clist['pid'];
                continue;
            }else{
                if($robor = M('roborder')->where("uid = {$user_id}")->order('price desc')->find()){
                    if($robor['price'] < $num){
                        $nums = $robor['price'];
                    }else{
                        $nums = $num;
                    }
                }else{
                    $nums = 0;
                }
                $money = $system[$i]*$nums;
//                $money = $config['total_profit'][$i]*$num;
                if($money >= 0.01 && !empty($money)){
                    M("user")->where("userid = {$clist['userid']}")->setInc('total_profit',$money);
                    M("user")->where("userid = {$clist['userid']}")->setInc('trend_money',$money);
                    M("user")->where("userid = {$clist['userid']}")->setInc('zsy',$money);//金额加入动态余额
                    //生产日志
                    $billdec['uid'] = $user_id;
                    $billdec['jl_class'] = 6; //抢单
                    $billdec['info'] = '团队接单奖励';
                    $billdec['addtime'] = time();
                    $billdec['jc_class'] = '+';
                    $billdec['num'] = $money;
                    $billdec['before'] = $clist['trend_money'];
                    $billdec['after'] = $clist['trend_money']+$money;
                    $billdec_re = M('somebill')->add($billdec);
                }
                $user_id = $clist['pid'];
            }
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
     * 级差奖
     * 上级id 佣金配置 等级 已返数量 金额
     */
    public function levle_profits($id,$config,$level,$money)
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
            $yjjc = 0;
        }
        $yjjcs =  $config[$user['use_grade']-1]; //当前的
        if($price = $yjjcs -$yjjc >0){
            $num = $money*$price; //可以获得的金额
            if($num < 0.01){
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
}
