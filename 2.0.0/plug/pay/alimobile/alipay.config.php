<?php  
$alipay_config['partner']		= ''; 
$alipay_config['key']			= ''; 
$alipay_config['private_key_path']	= '/www/web/m8_waimairen_com/public_html/plug/pay/alimobile/key/rsa_private_key.pem';
$alipay_config['ali_public_key_path']= '/www/web/m8_waimairen_com/public_html/plug/pay/alimobile/key/alipay_public_key.pem';
$alipay_config['sign_type']    = '0001';
$alipay_config['input_charset']= 'utf-8'; 
$alipay_config['cacert']    = getcwd().'\\cacert.pem';
$alipay_config['transport']    = 'http';
$alipay_config['notify_url'] = 'http://www.kjcpt.com/plug/pay/alimobile/notify_url.php';
$alipay_config['return_url'] = 'http://www.kjcpt.com/plug/pay/alimobile/call_back_url.php';
$alipay_config['error_url'] = 'http://www.kjcpt.com/plug/pay/alimobile/error.php';
$alipay_config['seller_email'] = '';
?>