<?php
@include_once("conn.php");

if (!isset($_GET["id"])) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$id = $_GET["id"];  // 单删 sid=1   多删sid=1,2,3


$sql = "delete from `shoppingcar` where gid in ($id)";

$result = mysqli_query($conn, $sql);

$obj = array();

if ($result) { //语句执行成功  => 数据不一定会有影响 

    //  $rows = mysqli_affected_rows($conn)  判断受影响的行数
    // $rows > 0    增删改 成功
    // $rows  == 0  语句执行成功 数据未改变 (删除 删除的数据不存在)
    // $rows == -1  语句执行失败 sql语句有误

    $rows = mysqli_affected_rows($conn);

    if ($rows > 0) {
        $obj["status"] = true;
        $obj["message"] = "删除成功";
    } else { //  $rows  == 0
        $obj["status"] = false;
        $obj["message"] = "删除失败,数据不存在";
    }
} else { // 语句执行失败 => 语句有误
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
