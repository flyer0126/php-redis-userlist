<?php
/**
 * 编辑用户.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午3:54
 */
require 'redis.php';

if(!empty($_POST)){
    $username = $_POST['username'];
    $age = $_POST['age'];
    $uid = $_POST['uid'];
    $redis->hMset('user.'.$uid, array('uid' => $uid, 'username' => $username, 'password' => $password, 'age' => $age));
    header('location:list.php');
} else {
    $uid = !empty($_GET['uid']) ? $_GET['uid'] : 0;
    if($uid){
        $user = $redis->hGetAll("user.$uid");
    }
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>编辑用户</title>
</head>
<body>
编辑用户<br/>
<form action="" method="post">
    <input type="hidden" name="uid" value="<?php echo $user['uid']; ?>">
    用户名：<input type="text" name="username" value="<?php echo $user['username']; ?>"/><br/>
    年龄：<input type="text" name="age" value="<?php echo $user['age']; ?>"/><br/>
    <input type="submit" value="编辑" /> <input type="reset" value="重填"/>
</form>
</body>
</html>
