<?php
@include "./conn.php";

if (!($_GET["orderName"] && $_GET['orderType'])) {
    exit("数据不完整");
}
$res = [];


//   需要前端携带数据
$orderName = $_GET['orderName'];
$orderType = $_GET['orderType'];

if ($orderType && $orderName) {

    $sql = "SELECT * FROM goods_list ORDER BY $orderName $type ";

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


echo (json_encode($res));
