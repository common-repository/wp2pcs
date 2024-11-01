<?php

if($_GET['action'] == 'update_token' && !empty($_GET['access_token']) && !empty($_GET['refresh_token'])) {

	if(!current_user_can('edit_theme_options')) {
		wp_die('权限不够。');
	}

	$access_token = htmlspecialchars($_GET['access_token']);
	$refresh_token = htmlspecialchars($_GET['refresh_token']);

	update_option('wp2pcs_baidu_access_token',$access_token);
	update_option('wp2pcs_baidu_refresh_token',$refresh_token);
	update_option('wp2pcs_baidu_token_update_time',time());
	
	wp_redirect(add_query_arg(array('tab'=>$page_name,'time'=>time()),$page_url));
	exit();
}