<?php
/**
 * 用户注册.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午2:35
 */

require 'redis.php';
if(!empty($_POST)){
    // 记录用户信息
    $redis->hmset('user.'.$uid,
        array(
            'uid' => $redis->incr('userid'),
            'username' => $_POST['username'],
            'password' => md5(trim($_POST['password'])),
            'age' => $_POST['age']
        )
    );
    $redis->rpush('uid', $uid); //记录uid至list（分页统计）
    $redis->set('username.'.$username, $uid); // 记录username为string类型（登录验证）
    header('location:list.php');
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>用户注册</title>
</head>
<body>
<form action="" method="post">
    用户名：<input type="text" name="username" /><br/>
    密码：<input type="password" name="password" /><br/>
    年龄：<input type="text" name="age"/><br/>
    <input type="submit" value="注册" /><input type="reset" value="重填"/>
</form>
</body>
</html>
