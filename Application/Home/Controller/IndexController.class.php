<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
	/**
	 * 首页视图
	 */
    public function index(){
        $num=I('post.num',10,"intval");
    	$msg=D('MsgRelation')->relation(true)->limit($num)->select();
    	$this->assign('msg',$msg);
      	$this->display();
    }

    /**
     * 异步刷新消息
     * @return array 处理结果数组
     */
    public function getMsg(){
        $num=I("post.num",10,"intval");
    	$srcmsg=D('MsgRelation')->relation(true)->order('msgtime desc')->limit($num)->select();
		$msg=$this->reverseArray($srcmsg);
		$res=array(
    		'code'=>$msg?200:400,
    		'desc'=>$msg?'获取消息成功':'获取消息失败',
    		'data'=>$msg?$msg:""
    	);
    	$this->ajaxReturn($res);
    }

	private function reverseArray($arr){
		$resarr=array();
		for($i=count($arr)-1;$i>=0;$i--){
			$resarr[]=$arr[$i];
		}
		return $resarr;
	}

    /**
     * 异步发送消息处理
     * @return array 处理结果数组
     */
    public function sendMsg(){
    	// 接收输入
		$username=I('post.username');
		$msgcont=I('post.msgcont');  

		// 插入数据
		$where=array('username'=>array('eq',$username));
		$uid=M('user')->where($where)->find();
		$uid=$uid?$uid['_id']:M('user')->add(array('username'=>$username));

		$newMsg=array(
			'uid'=>$uid,
			'msgcont'=>$msgcont
		);
		$res=array();
		if(D('MsgRelation')->add($newMsg)){
			$res['code']=200;
			$res['desc']='发送成功';
		}else{
			$res['code']=400;
			$res['desc']='发送失败';	
		}

		// 返回结果
    	$this->ajaxReturn($res);
    }
}