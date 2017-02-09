<?php
//echo $_SERVER['HTTP_USER_AGENT'];exit;
function is_weixin(){ 
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
		return true;
	}else{
		return false;
	}
}
		$isios = '0';
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
			$isios = '1';
		}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
			$isios = '0';
		}
		//echo "[".$isios."]".$_SERVER['HTTP_USER_AGENT'];//exit;
		/*
		if($isios){
			header("Content-type: text/html; charset=utf-8"); 
			//header('Location: https://itunes.apple.com/cn/app/zhu-lian-bang/id1141749197?mt=8');
			header('Location: http://www.zlbcn.com/zlbapp_ios.html');
			exit;
		}else{
			header("Content-type: text/html; charset=utf-8"); 
			header('Location: http://www.zlbcn.com/zlbapp.html');
			exit;
		}*/
$isweixin = '0';
if(is_weixin()){
	$isweixin = '1';
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet" href="xzapp/css/bootstrap.min.css">
<link rel="stylesheet" href="xzapp/css/animate.css">
<link rel="stylesheet" href="xzapp/css/font-awesome.min.css">
<link rel="stylesheet" href="xzapp/css/styles.css">

<title>助联帮</title>
<style>

  html,body,div,span,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,caption,article,aside,canvas,details,figcaption,figure,footer,header,hgroup,menu,nav,section,summary,time,mark,audio,video{margin:0;padding:0;outline:0;border:0;background:transparent;vertical-align:baseline;font-size:100%;}

img{vertical-align:top;}

i, b, em {font-style: normal;}

body{color: #333;font-size: 14px;line-height: 1.6;margin:0px;font-family: NotoSansHans-Regular, AvenirNext-Regular, "proxima-nova", "Hiragino Sans GB", "Microsoft YaHei", "WenQuanYi Micro Hei", "Open Sans", "Helvetica Neue", Arial, sans-serif;

}

.MainHeader{border-top:2px solid #eee; border-bottom:1px solid #eee; background-color:#fdfdfd;padding: 10px 0 6px;}

.MainHeader .title{margin:auto; padding:15px 0; text-align:center;}

.MainHeader .title h1{color: #666;font-size: 22px;padding-bottom:10px;}

.MainHeader .title p{color: #555;}

.MainHeader .title p > span + span::before {content: "/";color: #CCC; padding:0px 10px;}

.MainContent{background-color:#FAFAFA;border: solid 1px #EEE; max-width:500px; margin:auto; margin-top:30px;padding:20px;}

.MainContent .ImgIcon{text-align:center; margin-bottom:30px;}

.MainContent .ImgIcon img{border-radius: 24px;}

.MainContent h2{text-align:center; line-height:24px;color: #555;font-size: 20px;margin-bottom: 30px; font-weight:normal;}

.MainContent p{text-align:center;color: #555; margin-bottom:10px;}

.MainContent form{ text-align:center;}

.MainContent .password{width:100%;height: 34px;color:#555;background-color:white;border: 1px solid #CCC;border-radius: 4px; text-align:center; margin-bottom:30px;box-shadow: none;}

.MainContent .button{ background-color:#2ECC71; border:0px;cursor: pointer;color:#fff;padding:8px 15px;}

.MainContent .button:hover{background-color:#27ae60;}

.devider{border-top: 2px dotted #EEE;margin: 30px auto;border: 1px dashed #eee; max-width:800px; }

.MainView{margin-bottom:30px;}



.click_opacity {width: 100%;height: 100%;background: black;opacity: 0.6;position: fixed;z-index: 10000;top: 0px;}

.to_btn{position: fixed;top: 10px;right: 10px;text-align: right;z-index: 10001;font-family: "微软雅黑";color: white;}



.to_btn .span1 {font-size: 1.6rem;color: white;margin-top: 5px;}

.to_btn img {width: 20%;height: auto;display: inline-block;}

.to_btn .span2 {display: inline-block;line-height: 36px;width: 80%;margin-bottom: 12px;text-align: left;font-size: 16px;}

.to_btn span {display: block;float: right;}

.to_btn .span2 em {display: inline-block;width: 16px;height: 16px;background: #009DD9;color: white;font-size: 12px;text-align: center;line-height: 16px;border: 1px solid white;border-radius: 50%;margin-right: 3px;}

.to_btn .span2 img {display: inline-block;width: 30px;height: 30px;margin: 0px 5px;}

.to_btn .android_open img {display: inline-block;width: 150px;height: 34px;}

    </style>
</head>
<body>
<div class="MainHeader">
  <div class="title">
    <h1>助联帮</h1>
<?php if($isios){?>
    <p><span>版本：1.9.0.5</span><span class="daxiao"><span>文件大小：5.7MB</span></span><span>2017-1-11</span></p>
<?php }else{ ?>
	<p><span>版本：2.0.0</span><span class="daxiao"><span>文件大小：7.4MB</span></span><span>2017-2-7</span></p>
<?php } ?>

  </div>
</div>
<div class="MainContent">
  <div class="ImgIcon"> <img src="xzapp/images/512.png" height="120" width="120"> </div>
  <form>
<?php if($isios){?>
    <div class="download"><a href='https://itunes.apple.com/cn/app/zhu-lian-bang/id1141749197?mt=8' class='download_url'><i class='fa fa-apple'></i>点击下载</a></div>
<?php }else{ ?>
	<div class="download"><a href='http://www.zlbcn.com/zlbv200.apk' class='download_url'><i class='fa fa-android'></i>点击下载</a></div>
<?php } ?>
    <div class="android_download"></div>
  </form>
</div>
<hr class="devider">
<div class="MainView">
  <div style="text-align:center;"> 用手机扫描下面的二维码安装 <br>
    <br>
    <div class="modal-body" align="center"> <img src="http://qr.liantu.com/api.php?text=http://www.zlbcn.com/downapp.php" width="150"> </div>
  </div>
</div>

<link href="xzapp/css/app.css" rel="stylesheet" type="text/css" >
<?php if($isweixin){?>
<?php if($isios){?>
<div id="weixin" style="display: block;">
  <div class="click_opacity"></div>
  <div class="to_btn"> <span class="span1"><img src="xzapp/images/click_btn.png"></span> <span class="span2"><em>1</em> 点击右上角<img src="xzapp/images/menu.png">打开菜单</span> <span class="span2"><em>2</em> 选择<img src="xzapp/images/safari.png">用Safari打开下载</span> </div>
</div>
<?php }else{ ?>
<div id="weixin_an" style="display: block;">
  <div class="click_opacity"></div>
  <div class="to_btn"> <span class="span1"><img src="xzapp/images/click_btn.png"></span> <span class="span2"><em>1</em> 点击右上角<img src="xzapp/images/menu_android.png">打开菜单</span> <span class="span2 android_open"><em>2</em> 选择<img src="xzapp/images/android.png"></span> </div>
</div>
<?php } ?>
<?php } ?>
</body>
</html>
