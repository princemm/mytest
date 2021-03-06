<?php
header("Content-type: text/html; charset=utf-8");
function get_millisecond(){
		list($usec, $sec) = explode(" ", microtime());  
		$msec=round($usec*1000);  
		return $msec;  
}
function getnonce( $length = 8 ) {
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    for ( $i = 0; $i < $length; $i++ )
    {
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
}
function postsign($data_string,$secret){
	$tmpStr = base64_encode(hash_hmac('sha256',$data_string,$secret,true));
	return $tmpStr;
}
function curl_post_page($url,$data_string, $sign) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Content-Length: ' . strlen($data_string),
		'Authorization:' . $sign,
		'WWW-Authenticate:'.$sign)
    );
	//curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function curl_get_page($url, $sign) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
		'Authorization:' . $sign,
		'WWW-Authenticate:'.$sign)
    );
	//curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
	curl_setopt($ch, CURLOPT_TIMEOUT, 2);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
function wifi_login($maker_id,$maker_secret,$phone,$passwd){
	$data = json_decode(file_get_contents("katemp/logininfo.json"));
	if ($data->expire_time < time()) {
		$temparr = array();
		$temparr['appid'] = $maker_id;
		$temparr['ts'] = time().'';
		$temparr['nonce'] = getnonce(8);
		$temparr['version'] = '2';
		//$temparr['email'] = '';
		$temparr['phoneNumber'] = '+86'.$phone;
		$temparr['password'] = $passwd;
		ksort($temparr);

		$data_string = json_encode($temparr);
		$sign = postsign($data_string,$maker_secret);
		$url = 'https://api.coolkit.cc:8080/api/user/login';
		$result = curl_post_page($url, $data_string, "Sign ".$sign);
		$result = json_decode($result, true);
		if(isset($result['at']) && $result['at']){
			$data->expire_time = time() + 3600*24*28;
			$data->access_token = $result['at'];
			$data->apikey = $result['user']['apikey'];
			$fp = fopen("katemp/logininfo.json", "w");
			fwrite($fp, json_encode($data));
			fclose($fp);
			return $data;
		}else{
			echo "登录失败";exit;
		}
	}else{
		return $data;
	}
	

}
function wifi_getip($maker_id,$maker_secret,$attoken){
	$temparr = array();
	
	$temparr['appid'] = $maker_id;
	$temparr['ts'] = time().'';
	$temparr['nonce'] = getnonce(8);
	$temparr['version'] = '2';
	$temparr['accept'] = 'ws';
	$temparr['model'] = 'xiaomi';
	$temparr['os'] = 'android';
	ksort($temparr);

	$data_string = json_encode($temparr);
	$sign = $attoken;
	$url = 'https://cn-disp.coolkit.cc:8080/dispatch/app';
	$result = curl_post_page($url, $data_string, 'Bearer '.$sign);
	$result = json_decode($result, true);
	if(isset($result['error']) && $result['error']==0){
		return $result['IP'].':'.$result['port'];
	}else{
		echo "分配服务接口失败";exit;
	}
}

function wifi_getdevice($maker_id,$maker_secret,$apikey,$tk){
	$temparr = array();
	$temparr['appid'] = $maker_id;
	$temparr['ts'] = time().'';
	$temparr['nonce'] = getnonce(8);
	$temparr['version'] = '2';
	$temparr['apikey'] = $apikey;
	$temparr['lang'] = 'cn';

	$data_string = http_build_query($temparr);

	$url = 'https://cn-api.coolkit.cc:8080/api/user/device?'.$data_string;

	$result = curl_get_page($url, "Bearer ".$tk);
	$result = json_decode($result, true);
	return $result;
}

$maker_id="oc3tvAdJPmaVOKrLv0rjCC0dzub4bbnD";
$maker_secret="V0LmoW0cd2cg38i1eIM0P5Z29GjES4PA";

//our brand
//$maker_id="Ycg6mMSS329tK4JKr13voU4G01fSe9bd";
//$maker_secret="XDkDLPkYEpZFJwx1R5HyZ9FM7wbt4ta1";

$apikey = '';
$tk = '';
$ip_address = 'cn-long.coolkit.cc:8080';

$millisecond = get_millisecond();
$millisecond = str_pad($millisecond,3,'0',STR_PAD_RIGHT);
$tstime = date("YmdHis").$millisecond;

$nonce = getnonce(8);

$devicesarr = array();
if(isset($_GET['action']) && $_GET['action']=='on'){
	$logininfodata = wifi_login($maker_id,$maker_secret,'18585996708','12345678');
	$tk = $logininfodata->access_token;
	$apikey = $logininfodata->apikey;

	$devicesarr = wifi_getdevice($maker_id,$maker_secret,$apikey,$tk);
	//echo "<pre>";print_r($devicesarr);exit;
	//$ip_address = wifi_getip($maker_id,$maker_secret,$tk);

}

if(isset($_GET['action']) && $_GET['action']=='off'){
	
}

$deviceid = '';
$showflag = 0;
if(isset($_GET['action']) && $_GET['action']=='setonoff'){
	$showflag = 1;

	$logininfodata = wifi_login($maker_id,$maker_secret,'18585996708','12345678');
	$tk = $logininfodata->access_token;
	$apikey = $logininfodata->apikey;

	$deviceid = $_GET['deviceid'];
	//$ip_address = wifi_getip($maker_id,$maker_secret,$tk);
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>websocket_TEST</title>
<style>
	.sel_btn{
		height: 28px;
		line-height: 21px;
		padding: 0 11px;
		background: #02bafa;
		border: 1px #26bbdb solid;
		border-radius: 3px;
		/*color: #fff;*/
		display: inline-block;
		text-decoration: none;
		font-size: 12px;
		outline: none;
		width:100px;
	}
	.ch_cls{
		background: #e4e4e4;
	}
</style>
</head>
<body>
<br><br>
<?php
foreach($devicesarr as $val){
?>
<p style="font-size:20px;"><a href="index.php?action=setonoff&apikey=<?php echo $val['apikey'];?>&deviceid=<?php echo $val['deviceid'];?>"><?php echo $val['name'];?></a> &nbsp; &nbsp;<?php if($val['online']){?>在线<?php }else{ ?>不在线<?php } ?></p>
<?php
}
?>
<?php if($showflag){ ?>
<center>
<a href="javascript:void()" onclick="seton()" class="sel_btn">开</a> &nbsp; &nbsp;| &nbsp; &nbsp;<a href="javascript:void()" onclick="setoff()" class="sel_btn">关</a>
</center>

<br><br>

<input type="hidden" name="hbInterval" id="hbInterval" value="12">
<textarea class="log" style="width: 100%; height: 500px;">
=======websocket <?php echo date('Y-m-d H:i:s',time());?>======
</textarea>

<?php } ?>
<script type="text/javascript" src="jquery.min.js"></script>

<script language="javascript">
function link(str){
	var url='wss://<?php echo $ip_address;?>/api/ws';
	log(url);
	
	socket=new WebSocket(url);
	socket.onopen=function(){
		log('连接成功');
		socket.send(str);
	};
	socket.onmessage=function(msg){
		log('获得消息:'+msg.data);
		var json33 = JSON.parse(msg.data);
		$('#hbInterval').val(json33.config.hbInterval);
		timesend();
	};
	socket.onclose=function(){
		log('断开连接');
	};
	socket.onerror = function(evt){
		log('WebSocketError');
	};
}

function seton(){
	var str_seton = JSON.stringify({'action':'update','apikey':'<?php echo $apikey;?>','deviceid':'<?php echo $deviceid;?>','userAgent':'app','selfApiKey':'<?php echo $apikey;?>','sequence':'<?php echo $tstime;?>','params':{'switch':'on'}});
	//var str_seton = "{'action':'update','apikey':'<?php echo $apikey;?>','deviceid':'<?php echo $deviceid;?>','userAgent':'app','selfApiKey':'<?php echo $apikey;?>','sequence':'<?php echo $tstime;?>','params':{'switch':'on'}}";
	socket.send(str_seton);
}
function setoff(){
	var str_seton = JSON.stringify({'action':'update','apikey':'<?php echo $apikey;?>','deviceid':'<?php echo $deviceid;?>','userAgent':'app','selfApiKey':'<?php echo $apikey;?>','sequence':'<?php echo $tstime;?>','params':{'switch':'off'}});
	//var str_seton = "{'action':'update','apikey':'<?php echo $apikey;?>','deviceid':'<?php echo $deviceid;?>','userAgent':'app','selfApiKey':'<?php echo $apikey;?>','sequence':'<?php echo $tstime;?>','params':{'switch':'on'}}";
	socket.send(str_seton);
}
function dis(){
  socket.close();
  socket=null;
}
function log(var1){
  $('.log').append(var1+"\r\n");
}

function sendping(){
	log("send ping");
	socket.send("ping");
}
function timesend(){
	var times = parseInt($('#hbInterval').val());
	times = (times-2)*1000;
	setInterval("sendping()", times);
}
//var str22 = JSON.parse('{"error":0,"apikey":"5ee76e54-d9ba-4d4b-a8c7-885d3c06aa99","config":{"hb":1,"hbInterval":48},"sequence":"20161209092642775"}');

//alert(str22.config.hbInterval);
if (window.WebSocket){
    log('支持WebSocket');
} else {
    log('不支持WebSocket');
}

<?php
if($ip_address){
?>

var str = JSON.stringify({'action':'userOnline','version':'2','imei':'imei','ts':'<?php echo time();?>','at':'<?php echo $tk;?>','userAgent':'app','apikey':'<?php echo $apikey;?>','appid':'<?php echo $maker_id;?>','nonce':'<?php echo $nonce;?>','sequence':'<?php echo $tstime;?>'});


$(document).ready(function(){
	link(str);
	
}); 

<?php
}
?>
</script>
</body>
</html>