<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>重邮问问答</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,maximum-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="/cquptque/Public/css/index.css">
	<script src="/cquptque/Public/js/weixin.js"></script>	
</head>
<body>
	<div id="point">
		<div></div>
	</div>
	<div style="display:none;background:url(/cquptque/Public/img/back.png)"></div>
	<div id="out">
		<div id="contain">
			<div class="begin cell">
				<div class="rule"></div>
				<div class="beginBtn start"></div>
				<div class="beginBtn rank"></div>
				<div class="beginBtn info"></div>
				<div class="on"></div>
			</div>
			<div class="select cell">
				<div class="goback"></div>
				<div class="logo"></div>
				<div class="selectBtn dangtuan" data-type="4"></div>
				<div class="selectBtn hexin" data-type="3"></div>
				<div class="selectBtn chuantong" data-type="1"></div>
				<div class="selectBtn wangluo" data-type="2"></div>
			</div>
			
		</div>
	</div>	
</body>
<script src="/cquptque/Public/js/zepto.min.js"></script>
<script type="text/javascript">
	var name = "姓名";
	var table_id = "";
	var openId = "<?php echo ($openId); ?>";//ouRCyjhbyphqHJ0P_pa8wvhmEJ9A
	var honor = "";
	var winWidth = $(window).width(); //屏幕宽度
	var running = false;//动画是否进行
	var pagenum = 0; //页面位置
	var timer = ""; //定时器
	var lastTime = ""; //倒计时定时器
	var last = 0; //用时
	var queText = ""; //答题页面
	var animateNum = ['first','second','third','forth','fifth','sixth','seventh','igth','ninth','tenth','eleventh','twelvth','thirteenth','forteenth','fifteenth','sixteenth','seventeenth','eigthteenth']; //对应动画名称
	var pushData = []; //提交答案
	var shareScore,shareRank,queA,queB,queC,queD;
	$('#out').css({'width':$(window).width()+'px','height':$(window).height()+'px'});
	$('#point').css({'width':$(window).width()+'px','height':$(window).height()+'px','display':'none'});
	$('.cell').css({'width':$('#out').width()+'px'});
	//beginGame
	$('.start').on('touchend',function(){
		if(!running){
			move();
		}
	});
	//倒计时
	function time(){
		$('.timeline').eq(pagenum-2).css({'-webkit-animation':'timeline 15s','animation':'timeline 15s','-o-animation':'timeline 15s','-moz-animation':'timeline 15s'});
		lastTime = setInterval(function(){
			last++;
		},1000)
		timer = setTimeout(function(){
			$('.timeline').eq(pagenum-2).css('width','0');
			clearInterval(lastTime);
			clearInterval(timer);
			var ans = '4';
			var que = $('.que').eq(pagenum-2).data('id');
			var data = {};
			data.queId = que;
			data.ansId = ans;
			data.time = last;
			pushData.push(data);
			last = 0;
			if(pagenum == 16){
				upAns();
			}else{
				move();
			}
		},15000);
	}
	//move
	function move(){
		var winLeft = -winWidth*(pagenum+1);
		if(pagenum==0){
			pagenum++;
			$('#contain').css({'left':winLeft + 'px'});
			$('#out').css({'background':'url(/cquptque/Public/img/back.png)','background-size':'100% 100%'});
		}else{
			$('#contain').css({'-webkit-animation':'move' + animateNum[pagenum] + ' 0.5s','animation':'move' + animateNum[pagenum] + ' 0.5s','-o-animation':'move' + animateNum[pagenum] + ' 0.5s','-moz-animation':'move' + animateNum[pagenum] + ' 0.5s'});
			pagenum++;
			running = true;
			timer = setTimeout(function(){
				$('#contain').css('left',winLeft + 'px');	
				running = false;
				if(pagenum > 1 && pagenum < 17){
					time();
				}
			},500);
		}
		
		//console.log(pagenum);
	};
	//selectBtn
	$('.selectBtn').on('touchend',function(){
		if(!running){
			var type = $(this).data('type');
			table_id = type;
			view(type);
			clearInterval(timer);
			$('.selectBtn').unbind('touchend');
		}
	});
	//返回首页
	$('.goback').on('touchend',function(){
		if (!running) {
			pagenum = 0;
			$('#contain').css('left','0px');
			$('#out').css({'background':'url(/cquptque/Public/img/indexbc.png)','background-size':'100% 100%'});
		};
	})
	//渲染
	function view(data){
		if(data == '5'){
			for(var i = 0;i < 15;i++){
				queText += '<div class="anspage cell">';
					queText += '<div class="time">';
					queText += '<h1>TIME</h1>';
					queText += '<div class="countdown">';
					queText += '<div class="timeline_out">';
					queText += '<div class="timeline"></div>';
					queText += '</div></div></div>';
					queText += '<p class="que" data-id=""><i>第题</i></p>';
					queText += '<div data-id="1" class="ansBtn off"><i>A:</i></div>';
					queText += '<div data-id="2" class="ansBtn off"><i>B:</i></div>';
					queText += '<div data-id="3" class="ansBtn off"><i>C:</i></div>';
					queText += '<div data-id="4" class="ansBtn off"><i>D:</i></div></div>';
			}
			queText +='<div class="end cell"><h1>游戏结束</h1><h2>本次游戏答对<span class="trueNum"></span>道题</h2><h2>获得<span class="endScore"></span>分</h2><h3>当前模式排名<span class="endRank"></span>名</h3><div class="share"></div><div class="again"></div><div class="rank"></div></div><div class="rankInt cell"><div class="time"><div><div class="mine hinfo_on"></div><div class="allrank hrank"></div><div class="again hagain"></div></div></div><div class="info"><div class="share">分 享</div><div class="head"></div><h3 class="name">sdjgisiogj</h3><p><span class="back"></span><span class="honor">头&nbsp;&nbsp;&nbsp;&nbsp;衔：</span></p><p><span class="back"></span><span class="rate">正确率：</span></p><p><span class="back"></span><span class="allscore">总分数：</span></p><h4 class="fourt">综合战斗力</h4><div class="four"><span>党团知识<h4></h4></span><span>网络文明<h4></h4></span><span>核心价值观<h4></h4></span><span>传统文化<h4></h4></span><canvas id="canvas"></canvas></div></div><ul class="rankTop" style="display:none"></ul></div>';
			$('#contain').append(queText);
			rankInfo();
			rankEvent();
			$('.cell').css({'width':$('#out').width()+'px'});
			
		}else{
			$.ajax({
				type: 'post',
				url: '<?php echo U("Home:index/questionApi"); ?>',
				data: 'type=getContent&key=86b4359bdfdefb5b21d6260476087062&tableId='+data,
				success: function(data){
					$.each(data.data,function(index,element){
				 	queText += '<div class="anspage cell">';
					queText += '<div class="time">';
					queText += '<h1>TIME</h1>';
					queText += '<div class="countdown">';
					queText += '<div class="timeline_out">';
					queText += '<div class="timeline"></div>';
					queText += '</div></div></div>';
					queText += '<p class="que" data-id="'+element.qid+'"><i>第'+(index+1)+'题</i> '+element.question+'</p>';
					queText += '<div data-id="1" class="ansBtn off"><i>A:</i> '+element.ans_A+'</div>';
					queText += '<div data-id="2" class="ansBtn off"><i>B:</i> '+element.ans_B+'</div>';
					queText += '<div data-id="3" class="ansBtn off"><i>C:</i> '+element.ans_C+'</div>';
					queText += '<div data-id="4" class="ansBtn off"><i>D:</i> '+element.ans_D+'</div></div>';
					});
					queText +='<div class="end cell"><h1>游戏结束</h1><h2>本次游戏答对<span class="trueNum"></span>道题</h2><h2>获得<span class="endScore"></span>分</h2><h3>当前模式排名<span class="endRank"></span>名</h3><div class="share"></div><div class="again"></div><div class="rank"></div></div><div class="rankInt cell"><div class="time"><div><div class="mine hinfo_on"></div><div class="allrank hrank"></div><div class="again hagain"></div></div></div><div class="info"><div class="share">分 享</div><div class="head"></div><h3 class="name">sdjgisiogj</h3><p><span class="back"></span><span class="honor">头&nbsp;&nbsp;&nbsp;&nbsp;衔：</span></p><p><span class="back"></span><span class="rate">正确率：</span></p><p><span class="back"></span><span class="allscore">总分数：</span></p><h4 class="fourt">综合战斗力</h4><div class="four"><span>党团知识<h4></h4></span><span>网络文明<h4></h4></span><span>核心价值观<h4></h4></span><span>传统文化<h4></h4></span><canvas id="canvas"></canvas></div></div><ul class="rankTop" style="display:none"></ul></div>';
					console.log(data);
					$('#contain').append(queText);
					rankEvent();
					$('.cell').css({'width':$('#out').width()+'px'});
					//ans
					$('.ansBtn').on('touchend',function(){		
						if(!running){
							clearInterval(timer);
							clearInterval(lastTime);
							$(this).removeClass('off');
							$(this).addClass('on');
							var ans = $(this).data('id');
							var que = $(this).siblings('.que').data('id');
							var data = {};
							data.qid = ''+que;
							data.true_ans = ''+ans;
							data.costTime = ''+last;
							pushData.push(data);
							last = 0;
							$(this).parent().find('.ansBtn').unbind('touchend');
							if(pagenum == 16){
								upAns();
							}else{
								move();
							}
							
						}
					});
					move();
				},
				error: function(){
					alert('获取数据失败');
				}
			});
		}
	}
	//ansBtn
	
	//上传答案
	function upAns(){
		$.ajax({
			type: 'post',
			url: '<?php echo U("Home:index/answerApi"); ?>',
			data: 'type=getGrade&key=86b4359bdfdefb5b21d6260476087062&tableId='+table_id+'&content='+JSON.stringify(pushData)+'&openId='+openId,
			success: function(data){
				console.log(data);
				$('.endRank').html(data.rank);
				$('.endScore').html(data.grade);
				$('.trueNum').html(data.num);
				alert(1);
				shareRank = data.userInfo.avgGrade;
				document.title = '我参与了重邮问问答闯关，排行'+shareRank+'名，你约吗？';
				move();
				rankInfo();
			},
			error: function(data){
				alert('提交失败');
			}
		})
	}
	//排行榜及个人信息
	function rankInfo(){
		//draw();
		$.ajax({
			type: 'post',
			url: '<?php echo U("Home:index/userInfo"); ?>',
			data: 'key=86b4359bdfdefb5b21d6260476087062&openId='+openId+'&type=rankAll',
			success: function(data){
				console.log(data);
				var rankList = '';
				rankList += '<li class="ranktitle"><span class="rankli">排名</span><span class="rankname">昵称</span><span class="rankscore">总分</span></li>';
				$.each(data.data,function(index,element){
					rankList += '<li><span class="rankli">'+(index+1)+'</span><span class="rankname">'+element.name+'</span><span class="rankscore">'+element.avgGrade+'</span></li>';
				});
				$('.rankTop').html(rankList);
				// $('.rankTop');
				// $('.info');
			},
			error: function(data){
				alert('提交失败');
			}
		});
		$.ajax({
			type: 'post',
			url: '<?php echo U("Home:index/userInfo"); ?>',
			data: 'key=86b4359bdfdefb5b21d6260476087062&openId='+openId+'&type=userInfo',
			success: function(data){
				console.log(data);
				//var imgSrc = data.userInfo.img_src.substr(0,data.userInfo.img_src.length-1)+64;
				$('.head').css({'background':'url('+data.userInfo.img_src+')','background-size':'100% 100%'});
				
				$('.name').html(data.userInfo.name);
				
				$('.honor').html('头&nbsp;&nbsp;&nbsp;&nbsp;衔：'+data.userInfo.honor);
				honor = data.userInfo.honor;
				$('.rate').html('正确率：'+data.userInfo.rate+'%');
				$('.allscore').html('总分数：'+data.userInfo.avgGrade);
			},
			error: function(data){
				alert('提交失败');
			}
		});
		$.ajax({
			type: 'post',
			url: '<?php echo U("Home:index/userInfo"); ?>',
			data: 'key=86b4359bdfdefb5b21d6260476087062&openId='+openId+'&type=four',
			success: function(data){
				console.log(data);
				//alert(data.queB.rightNum);
				queA = parseInt(data.data[1].rightNum);
				queB = parseInt(data.data[0].rightNum);
				queC = parseInt(data.data[3].rightNum);
				queD = parseInt(data.data[2].rightNum);
				$('.four span').eq(1).find('h4').html('('+data.data[1].rightNum+')');
				//queB = data.queB.rightNum;
				$('.four span').eq(3).find('h4').html('('+data.data[0].rightNum+')');
				$('.four span').eq(0).find('h4').html('('+data.data[3].rightNum+')');
				//queD = data.queD.rightNum;
				$('.four span').eq(2).find('h4').html('('+data.data[2].rightNum+')');
				draw(queA,queB,queC,queD);
				// $('.rankTop');
				// $('.info');
			},
			error: function(data){
				alert('提交失败');
			}
		});
	}
	
	//
	function draw(queA,queB,queC,queD){
		
		var canvas = document.getElementById('canvas');
		var back = $('.four');
		var cwidth = back.width();
		canvas.setAttribute('width',cwidth);
		var cheight = back.height();
		canvas.setAttribute('height',cheight);
		var ctx = canvas.getContext("2d");
		
		ctx.beginPath();
		ctx.clearRect(0,0,cwidth,cheight);
		ctx.strokeStyle = "#4ecfff";
		ctx.fillStyle = "#4ecfff";
	    ctx.moveTo(cwidth/2,cheight/2-cwidth/2*queC/15*9/10-1);
	    ctx.lineTo(cwidth/2+cwidth/2*queA/15*9/10+1,cheight/2);
	    ctx.lineTo(cwidth/2,cheight/2+cwidth/2*queD/15*9/10+1);
	    ctx.lineTo(cwidth/2-cwidth/2*queB/15*9/10-1,cheight/2);
	    ctx.strokeStyle = "#fff";
	    ctx.moveTo(0,cheight/2);
	    ctx.lineTo(cwidth,cheight/2);
	    ctx.strokeStyle = "#fff";
	    ctx.moveTo(cwidth/2,0);
	    ctx.lineTo(cwidth/2,cheight);

	    
	    ctx.closePath();
	    ctx.stroke();
	    ctx.fill();
	    var size = parseInt($('.four span').css('font-size'));
		    $('.four span').eq(0).css({'left':cwidth/2-2*size+'px','top':'-2em'});
		    //$('.four span').eq(0).find('h4').html('('+queC+')');
		    $('.four span').eq(1).css({'right':'-3em','top':cheight/2-size+'px'});
		    //$('.four span').eq(1).find('h4').html('('+queA+')');
		    $('.four span').eq(2).css({'left':cwidth/2-2.5*size+'px','top':cheight+'px'});
		    //$('.four span').eq(2).find('h4').html('('+queD+')');
		    $('.four span').eq(3).css({'left':'-3em','top':cheight/2-size+'px'});
		    //$('.four span').eq(3).find('h4').html('('+queB+')');
	}
	function rankEvent(){
		//share
		$('.share').on('touchend',function(){
			$('#point').css('display','block');
		});
		$('#point').on('touchend',function(){
			$('#point').css('display','none');
		});
		//rank
		$('.rank').on('touchend',function(){
			if(pagenum==0){
				view('5');
			}
			pagenum = 18;
			var winLeft = -winWidth*pagenum;
			$('#contain').css('left',winLeft + 'px');
			$('.allrank').trigger('touchend');
		});

		$('.info').on('touchend',function(){
			view('5');
			pagenum = 18;
			var winLeft = -winWidth*pagenum;
			$('#contain').css('left',winLeft + 'px');
		});
		//mine
	    $('.mine').on('touchend',function(){
	    	var classN = $(this).attr('class');
	    	if(classN!='mine hinfo'){
	    		$(this).attr('class','mine hinfo');
	    		$('.hrank').attr('class','allrank hrank_on');
	    		$('.info').css('display','none');
				$('.rankTop').css('display','block');
	    	}else{
				$(this).attr('class','mine hinfo_on');
				$('.hrank_on').attr('class','allrank hrank');
				$('.info').css('display','block');
				$('.rankTop').css('display','none');
				$.ajax({
					type: 'post',
					url: '<?php echo U("Home:index/userInfo"); ?>',
					data: 'key=86b4359bdfdefb5b21d6260476087062&openId='+openId+'&type=userInfo',
					success: function(data){
						draw(queA,queB,queC,queD);
						// $('.rankTop');
						// $('.info');
					},
					error: function(data){
						alert('提交失败');
					}
				});
	    	}
	    });
	    //rank
	    $('.allrank').on('touchend',function(){
	    	var classN = $(this).attr('class');
	    	if(classN!='allrank hrank'){
	    		$('.hinfo').attr('class','mine hinfo_on');
				$(this).attr('class','allrank hrank');
	    		$('.info').css('display','block');
				$('.rankTop').css('display','none');
	    	}else{
				$('.hinfo_on').attr('class','mine hinfo');
	    		$(this).attr('class','allrank hrank_on');
	    		$('.info').css('display','none');
				$('.rankTop').css('display','block');
	    	}
	    	
	    });
	    //again
		$('.again').on('touchend',function(){
			window.location.href = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2Fcquptque%2FHome%2FIndex%2Findex&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
		})
	};
    rankEvent();
    //微信
    wx.config({
	    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: 'wx81a4a4b77ec98ff4', // 必填，公众号的唯一标识
	    timestamp: '<?php echo ($Js["timestamp"]); ?>', // 必填，生成签名的时间戳
	    nonceStr: '<?php echo ($Js["nonceStr"]); ?>', // 必填，生成签名的随机串
	    signature: '<?php echo ($Js["signature"]); ?>',// 必填，签名，见附录1
	    jsApiList: [
	    	'onMenuShareTimeline',
	    	'onMenuShareAppMessage',
	    	'hideMenuItems'
	    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	wx.ready(function(){
		wx.hideMenuItems({
		    menuList: [
		    	 "menuItem:copyUrl",
		    	 "menuItem:originPage"
		    ]
		});
		wx.onMenuShareTimeline({
		    title: '', // 分享标题
		    link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2Fcquptque%2FHome%2FIndex%2Findex&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', // 分享链接
		    imgUrl: 'http://hongyan.cqupt.edu.cn/cquptque/Public/img/share.jpg', // 分享图标
		    success: function () { 
		        // 用户确认分享后执行的回调函数
		    },
		    cancel: function () { 
		        // 用户取消分享后执行的回调函数
		    }
		});
		// wx.onMenuShareAppMessage({
		//     title: '重邮问问答', // 分享标题
		//     desc: '我已经成功闯关重邮问问答，快来挑战我吧！', // 分享描述
		//     link: 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx81a4a4b77ec98ff4&redirect_uri=http%3A%2F%2Fhongyan.cqupt.edu.cn%2Fcquptque%2FHome%2FIndex%2Findex&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', // 分享链接
		//     imgUrl: 'http://hongyan.cqupt.edu.cn/cquptque/Public/img/logo.png', // 分享图标
		//     type: 'link', // 分享类型,music、video或link，不填默认为link
		//     dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		//     success: function () { 
		//         // 用户确认分享后执行的回调函数
		//     },
		//     cancel: function () { 
		//         // 用户取消分享后执行的回调函数
		//     }
		// });
	});
   		
</script>
</html>