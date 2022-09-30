<?php

@include_once("conn.php");


if (!(isset($_POST["user"]) && isset($_POST["gid"]) && $_POST["num"])) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$user = $_POST["user"];
$gid = $_POST["gid"];
$num = $_POST["num"];


$obj = array();

$sql = "select * from `shoppingcar` where user='$user' and gid = '$gid'";

$result = mysqli_query($conn, $sql);
// print_r($result);  //mysqli_result 对象

if ($result) { // 查询成功    (查询成功 并不代表有数据, 有数据 => 还要解析)
    // print_r($result);  //mysqli_result 对象

    $item = mysqli_fetch_assoc($result);

    if (!($item)) { 
        $sql = "insert into `shoppingcar`(user,gid,num) values('$user',$gid,1);";
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
    }else{
        $sql = "UPDATE shoppingcar SET num = num + $num WHERE user = '$user' AND gid = '$id'";
        // 执行sql   得到受影响的行数 --- 数字
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $obj['status'] = true;
            $obj['msg'] = '加入购物车成功';
        } else {
            $obj['status'] = false;
            $obj['msg'] = '数据库错误';
        }
    }

   
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}

echo json_encode($obj);
