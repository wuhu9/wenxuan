<?php
@include "./conn.php";

if (!($_GET["kw"])) {
    exit("数据不完整");
}
$res = [];

$kw = $_GET["kw"];

$sql = "SELECT * FROM goods_list where goods_title like %$kw%";

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

echo (json_encode($res));
