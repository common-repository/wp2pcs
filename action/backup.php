<?php

if(isset($_POST['action']) && $_POST['action'] == 'update-backup-setting') {
  check_admin_referer();

  if(!current_user_can('edit_theme_options')) {
    wp_die('权限不够。');
  }

  $wp2pcs_backup_file = htmlspecialchars($_POST['wp2pcs_backup_file']);
  $wp2pcs_backup_data = htmlspecialchars($_POST['wp2pcs_backup_data']);
  $wp2pcs_backup_time = htmlspecialchars($_POST['wp2pcs_backup_time']);
  $wp2pcs_backup_path_include = trim(htmlspecialchars($_POST['wp2pcs_backup_path_include']));
  $wp2pcs_backup_path_exclude = trim(htmlspecialchars($_POST['wp2pcs_backup_path_exclude']));
  $wp2pcs_backup_path_must = trim(htmlspecialchars($_POST['wp2pcs_backup_path_must']));

  update_option('wp2pcs_backup_file',$wp2pcs_backup_file);
  update_option('wp2pcs_backup_data',$wp2pcs_backup_data);
  update_option('wp2pcs_backup_time',$wp2pcs_backup_time);
  update_option('wp2pcs_backup_path_include',$wp2pcs_backup_path_include);
  update_option('wp2pcs_backup_path_exclude',$wp2pcs_backup_path_exclude);
  update_option('wp2pcs_backup_path_must',$wp2pcs_backup_path_must);

  // 开启定时任务
  if(wp_next_scheduled('wp2pcs_backup_cron_task')) {
    wp_clear_scheduled_hook('wp2pcs_backup_cron_task');
    update_option('wp2pcs_backup_amount',0);
  }

  if($wp2pcs_backup_file != 'never' || $wp2pcs_backup_data != 'never') {
    $run_time = strtotime(date('Y-m-d '.$wp2pcs_backup_time.':00').' +1 day');
    // $run_time = strtotime('+1 minute');
    wp_schedule_event($run_time,'daily','wp2pcs_backup_cron_task');
  }

  wp_redirect(add_query_arg(array('tab'=>$page_name,'time'=>time()),$page_url));
  exit();
}
