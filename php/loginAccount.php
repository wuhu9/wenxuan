<?php
@include_once("conn.php");
// 登录  前端传入的用户名,密码  和 数据库中的用户名,密码 做对比

// 前端传入的用户名,密码
// $account = "123123@qq.com";   // 用户名 / 手机号 /  邮箱
// $pwd = "123123";


// 参数必填
if (!(isset($_POST["account"]) && isset($_POST["pwd"]))) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}


$account = $_POST["account"];
$pwd = $_POST["pwd"];

$obj = array();

// 对应账号查找数据
$sql = "select * from `user`  where username = '$account' or phone = '$account'";

$result = mysqli_query($conn, $sql);
// print_r($result);  //mysqli_result 对象

if ($result) { // 查询成功    (查询成功 并不代表有数据, 有数据 => 还要解析)
    // print_r($result);  //mysqli_result 对象

    $item = mysqli_fetch_assoc($result);  // 解析数据

    if ($item) { // 有数据 
        if ($pwd === $item["password"]) { // 前端传入的密码 和 数据库中的密码做对比
            $obj["status"] = true;
            $obj["message"] = "登录成功";
            $obj["user"] = $item["username"];
        } else {
            $obj["status"] = false;
            $obj["message"] = "账号或密码有误!";
        }
    } else { // 没有数据
        $obj["status"] = false;
        $obj["message"] = "该账号不存在!";
    }
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
