<?php

// 增加schedule,自定义的时间间隔循环的时间间隔 每周一次和每两周一次
add_filter('cron_schedules','wp2pcs_more_reccurences_for_backup');
function wp2pcs_more_reccurences_for_backup($schedules){
	$add_array = wp2pcs_reccurences();
	return array_merge($schedules,$add_array);
}

add_action('wp2pcs_backup_cron_task','wp2pcs_backup_cron_task_function');
function wp2pcs_backup_cron_task_function() {
  // 已经备份了的次数
  $wp2pcs_backup_amount = (int)get_option('wp2pcs_backup_amount');

  $wp2pcs_backup_file = get_option('wp2pcs_backup_file');
  $wp2pcs_backup_data = get_option('wp2pcs_backup_data');
  $reccurences_array = wp2pcs_reccurences();
  $backup_file = $reccurences_array[$wp2pcs_backup_file]['interval']/(3600*24);
  $backup_data = $reccurences_array[$wp2pcs_backup_data]['interval']/(3600*24);

  if(!$backup_file && !$backup_data) return;

  if($backup_file > 0 && $wp2pcs_backup_amount%$backup_file == 0) {
    $backup_file = true;
  }
  else {
    $backup_file = false;
  }
  if($backup_data > 0 && $wp2pcs_backup_amount%$backup_data == 0) {
    $backup_data = true;
  }
  else {
    $backup_data = false;
  }

  $wp2pcs_backup_amount ++;
  update_option('wp2pcs_backup_amount',$wp2pcs_backup_amount);

  wp2pcs_backup_to_baidupcs($backup_file,$backup_data);

}
