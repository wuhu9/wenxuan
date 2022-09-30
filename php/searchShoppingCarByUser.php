<?php
// 在一个php文件中引入另一个php  (引入并执行)
@include_once("conn.php"); // $conn

if (!isset($_GET["user"])) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$user = $_GET["user"];

// mysqli_query($conn,$sql)  执行传入的sql语句
// $conn  mysql链接
// $sql   执行的sql语句

// 返回值:   mysqli =>增删改(语句执行成功)  查(返回查询的结果对象)  , false (sql语句有误)
// 对于成功的查询和描述语句，mysqli_query() 将返回一个mysql_result对象。对于其他成功的查询，mysqli_query() 将返回TRUE。失败时返回FALSE。

// mysqli_query()  做查询操作
// 查询成功 => mysql_result对象 (查询成功 并不代表有数据, 有数据 => 还要解析)
// 查询失败 => false (sql语句有误)

$obj = array();

$sql = "select * from shoppingcar , list where user='$user' and shoppingcar.gid = list.id";
$result = mysqli_query($conn, $sql);
// print_r($result);  //mysqli_result 对象
// echo $result->num_rows;   // php对象取值 ->  查询的数据的数量

if ($result) { // 查询成功    (查询成功 并不代表有数据, 有数据 => 还要解析)

    $list = array();
    // 先解析一次 将解析的结果作为循环的条件 
    // 解析成功 => 有数据 =>执行循环 => 循环解析 再次求解表达式
    // 解析失败 => null  => 跳出循环
    while ($item = mysqli_fetch_assoc($result)) {

        array_push($list, $item); // []
    }

    if (count($list)) { // 有数据 
        $obj["status"] = true;
        $obj["message"] = "OK";
        $obj["list"] = $list;
    } else { // 没有数据
        $obj["status"] = true;
        $obj["message"] = "数据不存在";
    }
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);



// 总结:
// 单数据查询 => 解析解析
// 多数据查询 => 循环解析
