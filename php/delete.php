<?php
@include "./conn.php";

if (!($_GET['id'])) {
    exit("数据不完整");
}
$res = [];


// 前端携带参数  cart_id
$id = $_GET['id'];

if ($id) {
    // 
    $sql = "DELETE FROM cart WHERE cart_id = $id";
    $a = mysqli_query($con, $sql);   // 得到的就是数字
    if ($a > 0) {
        $res['status'] = true;
        $res['msg'] = '删除成功';
    } else {
        $res['status'] = false;
        $res['msg'] = '数据库错误';
    }
} else {
    $res['status'] = false;
    $res['msg'] = '前端数据有误';
}

echo (json_encode($res));
