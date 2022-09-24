<?php
@include "./conn.php";

if (!($_POST['username'] && $_POST['password'])) {
    exit("数据不完整");
}
// 最终返回给前端的结果
$res = [];

// 前端必须用 username和password传参数
$name = $_POST['username'];
$pwd = $_POST['password'];

// 判断是否接受到
if ($name && $pwd) {
    // 1 写sql语句
    $sql = "SELECT * FROM user WHERE username = '$name'";
    // 2 运行sql语句  mysqli_query(数据库连接 ， sql语句)
    $a = mysqli_query($con, $sql);   // 会得到一个结果集
    // 3 把这个结果集转化为对象
    $arr = mysqli_fetch_array($a);
    
    if ($arr) {
        // 判断密码是否正确
        if ($arr['password'] === $pwd) {
            $res['status'] = true;
            $res['msg'] = '登录成功';
        } else {
            $res['status'] = false;
            $res['msg'] = '密码错误';
        }
    } else {
        $res['status'] = false;
        $res['msg'] = '用户名不存在';
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

// 最终返回给前端的结果
echo (json_encode($res, JSON_UNESCAPED_UNICODE));  // 阻止中文转码
