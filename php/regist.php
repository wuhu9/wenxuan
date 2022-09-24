<?php
@include "./conn.php";

if (!($_POST['username'] && $_POST['password'])) {
    exit("数据不完整");
}

//  返回给前端的
$res = [];

//  接受前端的数据
$name = $_POST['username'];
$pwd = $_POST['password'];

// 判断是否接受到了
if ($name && $pwd) {
    // 去数据库里面查询是否被注册
    // 1 写sql语句
    $sql = "SELECT * FROM user WHERE username = '$name'";
    // 2 运行sql语句  mysqli_query(数据库连接 ， sql语句)
    $a = mysqli_query($con, $sql);   // 会得到一个结果集
    // 3 把这个结果集转化为对象
    $arr = mysqli_fetch_array($a);
    if ($arr) {
        $res['status'] = false;
        $res['msg'] = '用户名已被注册';
    } else {
        // 去注册  --- 插入新的数据
        $sql = "INSERT INTO user (username , password) VALUES ('$name' , '$pwd')";
        // 运行sql语句
        $a = mysqli_query($con, $sql);    // 得到一个数字，受影响的函数
        if ($a > 0) {
            $res['status'] = true;
            $res['msg'] = '注册成功';
        } else {
            $res['status'] = false;
            $res['msg'] = '数据库错误';
        }
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}


echo (json_encode($res, JSON_UNESCAPED_UNICODE));
