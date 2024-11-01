<?php

// 更新配置
if(isset($_POST['action']) && $_POST['action'] == 'update-load-setting') {
  check_admin_referer();

  if(!current_user_can('edit_theme_options')) {
    wp_die('权限不够。');
  }

  $wp2pcs_load_switch = htmlspecialchars($_POST['wp2pcs_load_switch']);
  $wp2pcs_load_linktype = htmlspecialchars($_POST['wp2pcs_load_linktype']);
  $wp2pcs_load_imglink = htmlspecialchars($_POST['wp2pcs_load_imglink']);
  $wp2pcs_load_remote_dir = htmlspecialchars($_POST['wp2pcs_load_remote_dir']);

  // 开关
  update_option('wp2pcs_load_switch',$wp2pcs_load_switch);
  // 更新链接
  
  if($wp2pcs_load_linktype == 1) {
    global $wp_rewrite;
    if(!$wp_rewrite->permalink_structure) {
      $wp2pcs_load_linktype = 0;
    }
  }
  update_option('wp2pcs_load_linktype',$wp2pcs_load_linktype);
  
  // 更新是否插入图片链接
  update_option('wp2pcs_load_imglink',$wp2pcs_load_imglink);
  
  // 更新采用站点目录还是共享目录作为默认目录
  update_option('wp2pcs_load_remote_dir',$wp2pcs_load_remote_dir);

  wp_redirect(add_query_arg(array('tab'=>$page_name,'time'=>time()),$page_url));
  exit();
}