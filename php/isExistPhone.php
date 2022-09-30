<?php
@include_once("conn.php");

// 如何判断用户是否存在?    => 对应用户名查找数据  
// 没有 => 可以使用的用户
// 有  => 用户名已被注册

if (!isset($_GET["phone"])) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$phone = $_GET["phone"];

$obj = array();

$sql = "select * from `user`  where phone = '$phone'";

$result = mysqli_query($conn, $sql);
// print_r($result);  //mysqli_result 对象

if ($result) { // 查询成功    (查询成功 并不代表有数据, 有数据 => 还要解析)
    // print_r($result);  //mysqli_result 对象

    $item = mysqli_fetch_assoc($result);


    if (!$item) { // 没有数据 
        $obj["status"] = true;
        $obj["message"] = "可以使用的手机号";
    } else { // 有数据
        $obj["status"] = false;
        $obj["message"] = "手机号已被注册";
    }
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
