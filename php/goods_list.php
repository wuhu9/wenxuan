<?php
@include "./conn.php";

$res = [];

//   不需要前端携带数据

$sql = "SELECT * FROM goods_list";

// 执行sql语句
$a = mysqli_query($con, $sql);

$list = [];

while ($arr = mysqli_fetch_array($a)) {
    array_push($list, $arr);
}

if ($list) {
    $res['status'] = true;
    $res['msg'] = '数据请求成功';
    $res['data'] = $list;
} else {
    $res['status'] = false;
    $res['msg'] = '数据库错误';
}


echo (json_encode($res));
