<?php
namespace Home\Widget;
use Think\Controller;

class SidebarWidget extends Controller{
	/**
	 * 朋友列表
	 */
	public function friendList($uid,$gid){
		$userNum=M('user')->count();
		$users=M('user')->select();
		$this->assign('userNum',$userNum);
		$this->assign('users',$users);
		$this->display("Sidebar:userList");
	}
}
?>