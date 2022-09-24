<?php
@include "./conn.php";

if (!($_GET['num'] && $_GET['page'])) {
    exit("数据不完整");
}


$res = [];

$num = $_GET['num'];   // 显示几条数据
$page = $_GET['page'];   // 页数

if ($num && $page) {

    // total 属于自己定义的字段
    $sql = "SELECT COUNT(*) total FROM goods_list";
    // 执行
    $a = mysqli_query($con, $sql);    // 结果集
    // 转对象
    $arr = mysqli_fetch_array($a);
    // 定义变量 --- 存储的就是总数量
    $total = $arr['total'];

    // 把对应的页数的数据传给前端
    //      limit 起始位置，数量
    $start = ($page - 1) * $num;
    $sql = "SELECT * FROM goods_list LIMIT $start,$num";

    // 执行sql语句
    $a = mysqli_query($con, $sql);

    $list = [];

    while ($arr = mysqli_fetch_array($a)) {
        array_push($list, $arr);
    }

    if ($list) {
        $res['status'] = true;
        $res['msg'] = '数据请求成功';
        $res['total'] = $total;
        $res['data'] = $list;
    } else {
        $res['status'] = false;
        $res['msg'] = '数据库错误';
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

echo (json_encode($res));
