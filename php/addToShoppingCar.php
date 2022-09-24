<?php
@include "./conn.php";

if (!($_GET['username'] &&  $_GET['num'] && $_GET['id'])) {
    exit("数据不完整");
}
$res = [];


// 前端携带数据   username   num    goods_id
$name = $_GET['username'];
$num = $_GET['num'];
$id = $_GET['id'];


if ($name && $num && $id) {

    // 先判断这个人是否把这个商品加入过购物车
    //     已经加入过   修改数量
    //     没有加入过   才插入

    // 先查询 是否把这个商品加入过购物车
    $sql = "SELECT * FROM cart WHERE username = '$name' AND goods_id = $id";
    // 得到的是结果集
    $a = mysqli_query($con, $sql);
    // 转对象
    $arr = mysqli_fetch_array($a);
    if ($arr) {
        // 更新数据
        $sql = "UPDATE cart SET num = num + $num WHERE username = '$name' AND goods_id = $id";
        // 执行sql   得到受影响的行数 --- 数字
        $a = mysqli_query($con, $sql);
        if ($a) {
            $res['status'] = true;
            $res['msg'] = '加入购物车成功';
        } else {
            $res['status'] = false;
            $res['msg'] = '数据库错误';
        }
    } else {
        // 插入数据
        $sql = "INSERT INTO cart (username , num , goods_id) VALUES ('$name' , $num , $id)";
        // 执行sql   得到受影响的行数 --- 数字
        $a = mysqli_query($con, $sql);
        if ($a > 0) {
            $res['status'] = true;
            $res['msg'] = '加入购物车成功';
        } else {
            $res['status'] = false;
            $res['msg'] = '数据库错误';
        }
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

echo (json_encode($res));
