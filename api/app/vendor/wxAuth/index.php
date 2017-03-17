<?php
include_once './auth.class.php';

$options = array(
        'component_appid' => '',
        'component_appsecret' => '',
        'component_verify_ticket'=>''
);

$weObj = new Auth($options);

$auth_code = $_GET['auth_code'];
if(empty($auth_code)){
	//此外示例代授权发起
	$code = $weObj -> get_auth_code();
	$url = $weObj -> getRedirect('http://'.$_SERVER['HTTP_HOST'].'/auth/act/login/do/bind', $code);//此外的url为授权成功后的回调地址，修改成你自己的实际地址
	header("Location:$url");die;
}else{
	//此外示例代授权回调后获取公众号信息
	$wechats_info=$weObj->get_authorization_info($auth_code);//获取授权方信息
}

?>