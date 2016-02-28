<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->

	<title>chat_index</title>
	<!-- 外部 css 引用 -->
	<link type="text/css" rel="stylesheet" href="/chat/Public/bootstrap3/css/bootstrap.min.css"/>
	<!-- 自定义 css -->
	<style>
		
	</style>		
</head>

<body>
	<div class="container">
		<!-- 头部 -->
		<div class="row"/><div class="page-header"><h1>chat</h1></div></div>
		
		<!-- 主体 -->
		<div class="row">
			<!-- 侧边栏_好友列表 -->
			<div class="col-md-offset-1 col-md-2"><?php echo W("Home/Sidebar/friendList");?></div>

			<!-- 聊天面板 -->
			<div class="col-md-6">
				<div class="panel panel-primary">
					<!-- 面板头部_标题信息 -->
					<div class="panel-heading"><h3 class="panel-title">roomName</h3></div>

					<!-- 面板内容_聊天内容 -->
					<div class="panel-body">
						<div id="msgList">
							<?php if(is_array($msg)): foreach($msg as $key=>$m): ?><strong><?php echo ($m['username']); ?></strong> - <?php echo ($m['msgtime']); ?>
								<p><?php echo ($m['msgcont']); ?></p><?php endforeach; endif; ?>
						</div>
					</div>

					<!-- 面板页脚_分页 -->
					<div class="panel-footer"></div>
					
					<!-- 表单_发送消息 -->
					<form style="margin:5px">
						<!-- 输入框头部 -->
						<div class="form-group row">
							<div class=" col-md-6">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input type="text" id="userName" name="username" class="form-control" placeholder="nickname"/>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
									<input type="text" class="form-control" id="timeText" readonly/>
								</div>
							</div>
						</div>
						
						<!-- 消息输入框 -->
						<div class="form-group">
							<textarea class="form-control" rows="3" id="inputContent" name="inputcontent" placeholder="请输入你要发送的内容"></textarea>
						</div>

						<!-- 发送按钮 -->
						<div class="form-group">
							<a class="btn btn-primary btn-sm form-control" id="sendBtn">发送</a>
						</div>
					</form>
				</div>
			</div> <!-- 聊天面板 -->
		</div> <!-- 主体 -->

		<!-- 页脚 -->
		<div class="row"></div>
	</div>

	<!-- jQuery 引用 -->
	<script type="text/javascript" src="/chat/Public/jquery2.js"></script>
	<!-- 外部 js 引用-->
	<script type="text/javascript" src="/chat/Public/bootstrap3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/chat/Public/jquery.validate.js"></script>
	<!-- 自定义 js -->
	<script type="text/javascript">
		window.onload=function(){
			// 更新聊天信息
			var timerUpdateMsg=setInterval(function(){
				$.post(
					"<?php echo U('Home/Index/getMsg');?>",
					{ num:"10" },
					function(res,status){
						if(res['code']==200){
							$msg=formatMsg(res['data']);
							// alert($msg);
							$("#msgList").html(
								$msg
							);
						}
					}
				);
			},3000);

			// 显示时间
			var timerShowTime=setInterval(function(){
				showTime();
			},500);

			// 消息发送
			var sendBtn = document.getElementById("sendBtn");
			sendBtn.onclick = function(){
				//昵称和内容校验
				var pass=checkInput();

				if(pass){
					//异步发送
					$.post(
						"<?php echo U('Home/Index/sendMsg');?>",
						{
							username:$("#userName").val(),
							msgcont:$("#inputContent").val()
						},
						function(res,status){
							// alert(res['desc']);
                            $("#inputContent").val("");
						}
					);
				}
			};
			
		};

		//输入校验
		function checkInput(){
			// $("form").validate({
			// 		rules:{
			// 			username:{
			// 				required:true,
			// 				minlength:3,
			// 				maxlength:20
			// 			},
			// 			inputcontent:"required"
			// 		},
			// 		messages:{
			// 			username:{
			// 				required:'昵称不能为空',
			// 				minlength:'昵称至少为3位',
			// 				maxlength:'昵称最多为20位'
			// 			},
			// 			inputcontent:'内容不能为空'
			// 		},
			// 		errorPlacement:function(error,element){
			// 		}
			// 	});
			
			var userName = document.getElementById('userName'),
			inputContent = document.getElementById('inputContent');

			if(userName.value==""){
				userName.value="用户名不能为空";
				userName.focus();
				return false;
			}
			if(inputContent.value=="")
			{
				inputContent.value="内容不能为空";
				inputContent.focus();
				return false;
			}
			return true;
		}

		// 获取当前时间
		function showTime(){
			var timeText = document.getElementById("timeText");
			var date     = new Date();

			timeText.value =
			date.getFullYear()+"/"+(date.getMonth()+1)+"/"+date.getDate()+" "
			+formatWeek(date.getDay())+" "
			+date.getHours()+":"+formatTime(date.getMinutes())+":"+formatTime(date.getSeconds());
		}

		// 格式化分秒
		function formatTime(i){
			if(i<10)
				return '0'+i;
			return i;
		}

		// 格式化星期
		function formatWeek(i){
			var week=new Array(7);
			week[0]='星期日';
			week[1]='星期一';
			week[2]='星期二';
			week[3]='星期三';
			week[4]='星期四';
			week[5]='星期五';
			week[6]='星期六';
			return week[i];
		}

		// 格式化消息
		function formatMsg($msg){
			var res="";
			for(var i=0,l=$msg.length;i<l;i++){
				res+="<strong>"+$msg[i]['username']+"</strong>"+" - "+$msg[i]['msgtime'];
				res+="<p>"+$msg[i]['msgcont']+"</p>";
                console.log(res);
			}
			return res;
		}

	</script>
</body>		
</html>