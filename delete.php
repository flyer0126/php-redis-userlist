<?php
/**
 * 删除用户.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午4:04
 */

require 'redis.php';
$uid = !empty($_GET['uid']) ? $_GET['uid'] : 0;
if($uid){
    $redis->lRem('uid', $uid, 0); // 移除list中匹配的uid
    $redis->del('user.'.$uid);
    header('location:list.php');
}
