<?php

if(isset($_POST['text3']) && $_POST['text3'] && $_POST['text5']){
		require_once 'phpmailer/class.phpmailer.php';
		$mail = new PHPMailer(true); 
			$mail->IsSMTP(); // 使用SMTP方式发送
			$mail->Host = "smtp.163.com"; // 您的企业邮局域名
			$mail->SMTPAuth = true; // 启用SMTP验证功能
			$mail->Username = 'mylover2012@163.com'; // 邮局用户名(请填写完整的email地址)
			$mail->Password = 'prince520yy'; // 邮局密码
			$mail->Port=25;
			$mail->Charset='UTF-8';
			
			$mail->From = 'mylover2012@163.com'; //邮件发送者email地址
			$mail->FromName = 'ZLBcn.com'; //发送人名称
			
			$mail->AddAddress ("54885782@qq.com","47118100@qq.com");
			
			$mail->Subject = date('Y-m-d',time()).'意向合作';

				$message  = '<html dir="ltr">' . "\n";
				$message .= '<head>' . "\n";
				$message .= '<title>【助联帮】</title>' . "\n";
				$message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
				$message .= '</head>' . "\n";
				$message .= '<body>';
				$message .= '<div style="width: 758px; font-family:Arial; margin:0 auto; border-color: #EBA858 #BABABA #BABABA;border-width: 7px 1px 1px;border-style: solid; font-size:14px;color:#6B6B6B;">';
				$message .= '<div style="padding:10px;">';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">合作方名称: '.$_POST['text1'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">合作方属性: '.$_POST['radio1'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">所在城市: '.$_POST['text2'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">合作方向: '.$_POST['radio2'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">联系人姓名: '.$_POST['text3'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">联系人职务: '.$_POST['text4'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">联系人手机: '.$_POST['text5'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">联系人邮箱: '.$_POST['text6'].'</p>';
				$message .= '<p style=" font-weight:bold;font-size: 12px;height:24px;line-height:24px;">备注: '.$_POST['text7'].'</p>';
				$message .= '</div>';
				$message .= '</div>';
				$message .= '</body>' . "\n";
				$message .= '</html>' . "\n";

				$mail->MsgHTML($message);
				$mail->Send ();
}
	header("Content-type: text/html; charset=utf-8");
	$msg = "alert('提交成功，我们会尽快与您联系');";
	echo "<script>$msg window.location.href='yixiang.html';</script>";

?>