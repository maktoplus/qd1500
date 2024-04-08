<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
/**
 * 用户控制器
 * 陶
 */
class TreeController extends AdminController
{


    /**
     * 用户列表
     * @author jry <bbs.sasadown.cn>
     */
    public function index()
    {   
         // 搜索
        $pid        =   I('keyword', '0', 'string');
        $sex=0;
        $user           =   M('user');
        if($pid!='0')
        {
            $k_where['userid|username|account'] = array(
                $pid,
                $pid,
                $pid,
                '_multi' => true,
            );
            $query=$user->where($k_where)->Field('userid,pid,money,trend_money')->find();
            $pid=$query['pid'];
        }
       
        $tree           =   $this->getTree($pid);
        $this->assign('tree',$tree);

        $this->display();
    }


    public  function getTree($pid='0')
    {
        $t=M('user');
        $sex=0;
        $wherea=array(  
        "pid"=>$pid,
        "sex"=>$sex
         );
        //$list=$t->where(array('pid'=>$pid,'sex'==0))->order('userid asc')->select();
        $list=$t->where($wherea)->order('userid asc')->select();

        if(is_array($list)){
            $html = '';
                $i++;
                foreach($list as $k => $v)
                {
                    $map['pid']=$v['userid'];
                    $count=$t->where($map)->count(1);
                    $class=$count==0 ? 'fa-user':'fa-sitemap';

                   if($v['pid'] == $pid)
                   {
                        //父亲找到儿子
                        $html .= '<li style="display:none" >';
                        $html .= '<span><i class="icon-plus-sign '.$class.' blue "></i>';
                        $html .= $v['username'].'(信用积分:'.$v['money'].'  动态积分:'.$v['trend_money'].')';
                        $html .= '</span> <a href="'.U('User/edit',array('id'=>$v['userid'])).'">';
                        $html .= $v['account'];
                        $html .= '</a>';
                        $html .= $this->getTree($v['userid']);
                        $html = $html."</li>";
                   }
                }
            return $html ? '<ul>'.$html.'</ul>' : $html ;
        }
    }
    
    


    public function djMoneys()
    {   
         // 搜索
        $pid        =   0;
        $sex=0;
        $user           =   M('user');
        if($pid!='0')
        {
            $k_where['userid|username|account'] = array(
                $pid,
                $pid,
                $pid,
                '_multi' => true,
            );
            $query=$user->where($k_where)->Field('userid,pid')->find();
            $pid=$query['pid'];
        }
       
        $tree           =   $this->djGetTree($pid);
        $tree = rtrim($tree,"###");
        // dump($tree);

        $tree = explode("###",$tree);
        dump($tree);
        // foreach ($tree as $key => $value) {
            
        //     $djmoney += floatval($value);

        // }


        // return $djmoney;

        // echo floatval($tree);
        // $this->assign('tree',$tree);

        // $this->display("index");
    }


    public  function djGetTree($pid='0')
    {
        $t=M('user');
        $sex=0;
        $wherea=array(  
        "pid"=>$pid,
        "sex"=>$sex
         );
        //$list=$t->where(array('pid'=>$pid,'sex'==0))->order('userid asc')->select();
        $list=$t->where($wherea)->order('userid asc')->select();

        if(is_array($list)){
            $html = 0;
            // $data = 0;
                $i++;
                foreach($list as $k => $v)
                {
                    $map['pid']=$v['userid'];
                    $count=$t->where($map)->count(1);
                    $class=$count==0 ? 'fa-user':'fa-sitemap';

                   if($v['pid'] == $pid)
                   {   
                        //父亲找到儿子
                        // $html .= '<li style="display:none" >';
                        // $html .= '<span><i class="icon-plus-sign '.$class.' blue "></i>';
                        // echo($v['d_money']);
                        // $html .= '</span> <a href="'.U('User/edit',array('id'=>$v['userid'])).'">';
                        $data .= $v['account']."###";
                        // $html .= '</a>';
                        $data .= $this->djGetTree($v['userid']);
                        // $html = $html."</li>";
                   }
                }
            return $data;
        }
    }



}
