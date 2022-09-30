<?php
// 在一个php文件中引入另一个php  (引入并执行)
@include_once("conn.php"); // $conn

if (!isset($_GET["id"])) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$id = $_GET["id"]; // 对应字段名id接收前端传递的数据 

// mysqli_query($conn,$sql)  执行传入的sql语句
// $conn  mysql链接
// $sql   执行的sql语句

// 返回值:   mysqli =>增删改(语句执行成功)  查(返回查询的结果对象)  , false (sql语句有误)
// 对于成功的查询和描述语句，mysqli_query() 将返回一个mysql_result对象。对于其他成功的查询，mysqli_query() 将返回TRUE。失败时返回FALSE。

// mysqli_query()  做查询操作
// 查询成功 => mysql_result对象 (查询成功 并不代表有数据, 有数据 => 还要解析)
// 查询失败 => false (sql语句有误)

$obj = array();

$sql = "select * from `list` where id = $id";
$result = mysqli_query($conn, $sql);
// print_r($result);  //mysqli_result 对象
// echo $result->num_rows;   // php对象取值 ->

if ($result) { // 查询成功    (查询成功 并不代表有数据, 有数据 => 还要解析)
    // print_r($result);  //mysqli_result 对象

    // mysqli_fetch_array($result);  // 对传入的mysqli_result进行解析  (每次只解析一条)
    // 解析成功 => 返回数据(数值数组+关联数组)
    // 解析失败 => null;

    // mysqli_fetch_assoc($result);  // 对传入的mysqli_result进行解析  (每次只解析一条)
    // 解析成功 => 返回数据(关联数组)
    // 解析失败 => null;

    // mysqli_fetch_object($result);  // 对传入的mysqli_result进行解析  (每次只解析一条)
    // 解析成功 => 返回数据(对象)
    // 解析失败 => null;


    $item = mysqli_fetch_assoc($result);
    // print_r($item);

    if ($item) { // 有数据 
        $obj["status"] = true;
        $obj["message"] = "OK";
        $obj["data"] = $item;
    } else { // 没有数据
        $obj["status"] = false;
        $obj["message"] = "数据不存在";
    }
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
