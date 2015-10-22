<?php
/**
 * 用户登录.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午5:25
 */

require 'redis.php';
if(!empty($_POST)){
    // 接收数据
    $username = $_POST['username'];
    $password = md5(trim($_POST['password']));

    // 用户验证
    $uid = $redis->get('username.'.$username);
    if(!empty($uid) && $password == $redis->hget('user.'.$uid, 'password')){
        // 登录成功
        $auth = md5(time()).$username.rand();
        $redis->set('auth.'.$auth, $uid);
        setcookie("auth", $auth, time()+86400);
        header('location:list.php');
    } else{
        $errmsg = '登录失败，请重试';
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>用户登录</title>
</head>
<body>
<?php echo !empty($errmsg) ? $errmsg."<br/>" : ''; ?>
<form action="" method="post">
    用户名：<input type="text" name="username" /><br/>
    密码：<input type="password" name="password" /><br/>
    <input type="submit" value="登录" /><input type="reset" value="重填"/>
</form>
</body>
</html>
