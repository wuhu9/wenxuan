<?php
@include "./conn.php";

if (!($_GET['num'] && $_GET['page'] && $_GET['kw'] && $_GET['orderName'] && $_GET['orderType'])) {
    exit("数据不完整");
}
$res = [];



// 合并了  like   order   page

$num = $_GET['num'];   // 显示几条数据
$page = $_GET['page'];   // 页数
//   需要前端携带数据  -- 关键字
$kw = $_GET['kw'];
//   需要前端携带数据  --  哪个字段进行排序   升序或者降序(1和2)
$orderName = $_GET['orderName'];
$orderType = $_GET['orderType'];


if ($num && $page) {
    // 处理升序和降序
    if ($orderType == 1) {
        $type = 'asc';
    } else {
        $type = 'desc';
    }
    // 需要给前端总的数量

    // total 属于自己定义的字段
    $sql = "SELECT COUNT(*) total FROM goods_list WHERE goods_title LIKE '%$kw%'";
    // 执行
    $a = mysqli_query($con, $sql);    // 结果集
    // 转对象
    $arr = mysqli_fetch_array($a);
    // {total:20}
    // 定义变量 --- 存储的就是总数量
    $total = $arr['total'];

    // 把对应的页数的数据传给前端
    //      limit 起始位置，数量
    $start = ($page - 1) * $num;
    $sql = "SELECT * FROM goods_list WHERE goods_title LIKE '%$kw%' ORDER BY $orderName $type LIMIT $start,$num";

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
