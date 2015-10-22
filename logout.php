<?php
/**
 * 用户退出.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午6:10
 */
require 'redis.php';
if(!empty($_COOKIE['auth'])){
    $redis->del('auth.'.$_COOKIE['auth']);
    setcookie('auth', $_COOKIE['auth'], time()-1);
    header('location:list.php');
}
