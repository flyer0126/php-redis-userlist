<?php
/**
 * 用户列表.
 * User: flyer0126
 * Date: 15-10-21
 * Time: 下午2:40
 */

require 'redis.php';

// 用户总数
$userCount = $redis->lLen('uid');
// 每页最大记录数
$pageSize = 3;
// 当前页数
$curPage = !empty($_GET['page']) ? $_GET['page'] : 1;
// 最大页数
$maxPage = ceil($userCount/$pageSize);

/**
 * 获取每页记录数
 * 第1页 0 2
 * 第2页 3 5
 * 第3页 6 8
 */
$uids = $redis->lRange('uid', (($curPage - 1) * $pageSize), $curPage * $pageSize - 1);
if(!empty($uids)){
    foreach($uids as $uid){
        $users[] = $redis->hGetAll('user.'.$uid);
    }
}

/*for($i = 1; $i <= $redis->get('userid'); $i++){
    $users[] = $redis->hGetAll("user.$i");
}
$users = array_filter($users);*/
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>用户列表</title>
</head>
<body>
<a href="reg.php">注册</a>
<?php
// 获取当前登录用户
if(!empty($_COOKIE['auth'])){
    $curUid = $redis->get('auth.'.$_COOKIE['auth']);
    $userName = $redis->hget('user.'.$curUid, 'username');
    echo "欢迎你,$userName "." <a href='logout.php'>退出</a>";
} else {
    echo "<a href='login.php'>登录</a>";
}
?>
<br/>

用户列表：
<table>
    <tr>
        <th>uid</th>
        <th>用户名</th>
        <th>年龄</th>
        <th>操作</th>
    </tr>
    <?php
    if(!empty($users)){
        foreach($users as $user){
    ?>
    <tr>
        <td><?php echo $user['uid']; ?></td>
        <td><?php echo $user['username']; ?></td>
        <td><?php echo $user['age']; ?></td>
        <td>
            <a href='edit.php?uid=<?php echo $user['uid']; ?>'>编辑</a>
            <a href='delete.php?uid=<?php echo $user['uid']; ?>'>删除</a>
            <?php
            if($curUid && $curUid != $user['uid']){
                if($redis->sIsMember('user.'.$curUid.'.followings', $user['uid'])){
                    echo "<a href='unfriend.php?uid={$user['uid']}&curUid={$curUid}'>取消关注</a>";
                } else {
                    echo "<a href='friend.php?uid={$user['uid']}&curUid={$curUid}'>加关注</a>";
                }
            }
            ?>
        </td>
    </tr>
    <?php
        }
    }
    ?>
    <tr>
        <td colspan="4">
            <a href="list.php?page=1">首页</a>
            <a <?php echo $maxPage>$curPage ? "href='list.php?page=".intval($curPage+1)."'" : "href='#'"; ?>>下一页</a>
            <a <?php echo $curPage>1 ? "href='list.php?page=".intval($curPage-1)."'" : "href='#'"; ?>>上一页</a>
            <a href="list.php?page=<?php echo $maxPage; ?>">尾页</a>
        </td>
    </tr>
</table>

<table>
    <tr><td colspan="3">我的关注</td></tr>
    <?php
        $followList = $redis->sMembers('user.'.$curUid.'.followings');
        if(!empty($followList)){
            foreach($followList as $follow){
                $followRow = $redis->hGetAll('user.'.$follow);
    ?>
                <tr>
                    <td><?php echo $followRow['uid']; ?></td>
                    <td><?php echo $followRow['username']; ?></td>
                    <td><?php echo $followRow['age']; ?></td>
                </tr>
    <?php
            }
        }
    ?>
</table>

<table>
    <tr><td colspan="3">我的粉丝</td></tr>
    <?php
    $followerList = $redis->sMembers('user.'.$curUid.'.followers');
    if(!empty($followerList)){
        foreach($followerList as $follower){
            $followerRow = $redis->hGetAll('user.'.$follower);
            ?>
            <tr>
                <td><?php echo $followerRow['uid']; ?></td>
                <td><?php echo $followerRow['username']; ?></td>
                <td><?php echo $followerRow['age']; ?></td>
            </tr>
    <?php
        }
    }
    ?>
</table>
</body>
</html>
