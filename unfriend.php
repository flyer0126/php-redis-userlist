<?php
/**
 * 取消关注.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午6:34
 */
require 'redis.php';

$uid = !empty($_GET['uid']) ? $_GET['uid'] : 0;
$curUid = !empty($_GET['curUid']) ? $_GET['curUid'] : 0;
if($curUid && $uid){
    $redis->sRem('user.'.$curUid.'.followings', $uid); // 我的关注列表去除
    $redis->sRem('user.'.$uid.'.followers', $curUid); // 对方的粉丝列表去除
    header('location:list.php');
}
