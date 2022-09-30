<?php
@include_once("conn.php");

// 参数必填
if (!(isset($_POST["pwd"]) && isset($_POST["phone"]))) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$pwd = $_POST["pwd"];
$phone = $_POST["phone"];
$user = $_POST["username"];

$obj = array();

$sql = "insert into `user`(password,phone,username) values('$pwd','$phone','$user')";

$result = mysqli_query($conn, $sql);

if ($result) { //语句执行成功  => 数据不一定会有影响 

    //  $rows = mysqli_affected_rows($conn)  判断受影响的行数
    // $rows > 0    增删改 成功
    // $rows  == 0  语句执行成功 数据未改变 (新增 不会出现此情况)
    // $rows == -1  语句执行失败 sql语句有误

    $rows = mysqli_affected_rows($conn);

    if ($rows > 0) {
        $obj["status"] = true;
        $obj["message"] = "新增成功";
    } else { //  $rows  == 0
        $obj["status"] = true;
        $obj["message"] = "新增成功,数据未改变";
    }
} else { // 语句执行失败 => 语句有误
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
