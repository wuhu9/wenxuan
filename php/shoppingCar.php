<?php
@include "./conn.php";

if (!($_GET['username'])) {
    exit("数据不完整");
}


$res = [];

// 前端携带参数  username
$name = $_GET['username'];

if ($name) {
    // 联表查询
    $sql = "SELECT * FROM cart , goods_list WHERE username = '$name' AND cart.goods_id = goods_list.goods_id";
    // 执行sql语句
    $a = mysqli_query($con, $sql);

    $list = [];

    while ($arr = mysqli_fetch_array($a)) {
        array_push($list, $arr);
    }

    if ($list) {
        $res['status'] = true;
        $res['msg'] = '数据请求成功';
        // data随便写的
        $res['data'] = $list;
    } else {
        $res['status'] = false;
        $res['msg'] = '数据库错误';
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

echo (json_encode($res, JSON_UNESCAPED_UNICODE));
