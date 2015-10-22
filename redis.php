<?php
/**
 * Redis初始化.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午2:13
 */

// 实例化
$redis = new Redis();
// 连接服务器
$r = $redis->connect('127.0.0.1');
// 授权
$redis->auth('flyer0126');
