<?php
@include "./conn.php";

if (!($_GET['id'])) {
    exit("数据不完整");
}
$res = [];


// 参数id

$id = $_GET['id'];


if ($id) {
    // 根据id查询商品
    $sql = "SELECT * FROM goods_list WHERE goods_id = $id";
    // 执行sql语句
    $a = mysqli_query($con, $sql);

    // 转对象   ---  每次只转一个
    $arr = mysqli_fetch_array($a);

    if ($arr) {
        $res['status'] = true;
        $res['msg'] = '数据请求成功';
        $res['data'] = $arr;
    } else {
        $res['status'] = false;
        $res['msg'] = '数据库错误';
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

echo (json_encode($res));
