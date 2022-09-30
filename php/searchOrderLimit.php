<?php
// 在一个php文件中引入另一个php  (引入并执行)
@include_once("conn.php"); // $conn


if (!(isset($_GET["wd"]) && isset($_GET["col"]) && isset($_GET["type"]) && isset($_GET["page"]) && isset($_GET["size"]))) {
    exit('{"status":false,"message":"请传入完整参数!"}');
}

$wd = $_GET["wd"];   //搜索的关键词
$col = $_GET["col"]; //排序的列名
$type = $_GET["type"]; //排序的方式  asc desc
$page = $_GET["page"]; // 第几页
$size = $_GET["size"]; //每页显示多少条


// -- 每页显示10条 (size)
// -- 第1页 limit 0,10     =>  [1,10]
// -- 第2页 limit 10,10    =>  [11,20]
// -- 第3页 limit 20,10    =>  [21,30]
// -- 第n页 limit (n-1)*size,size    =>  [21,30]

// 页码最小值和最大值限制 !!!!!
// 最小值: 1
// 最大值: 满足条件的总数据 / 每页显示多少条  => 向上取值

// 满足条件的总数据 =>   如何获取?  在数据库中提前查询一遍 

// 查询满足条件的总数据 
$sql = "select * from `list` where title like '%$wd%'";

$resultAll = mysqli_query($conn, $sql);

if ($resultAll) { // 查询有结果   
    $total = $resultAll->num_rows;  //查询的结果数据的中数量

    if ($total > 0) { // 有数据
        $maxPage = ceil($total / $size);  //最大页码

        if ($page < 1) {
            $page  = 1;
        }

        if ($page > $maxPage) {
            $page = $maxPage;
        }

        $skip = ($page - 1) * $size;


        $obj = array();

        $sql = "select * from `list` where title like '%$wd%'  order by $col $type limit $skip,$size";
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
                $obj["total"] = $total;
                $obj["maxPage"] = $maxPage;
                $obj["current"] = $page;
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
    } else {
        $obj["status"] = true;
        $obj["message"] = "暂无数据";
    }
} else {
    $obj["status"] = false;
    $obj["message"] = "sql语句有误";
    $obj["sql"] = $sql;
}




echo json_encode($obj);



// 总结:
// 单数据查询 => 直接解析
// 多数据查询 => 循环解析
