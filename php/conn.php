<?php
    $host = 'localhost:3306';
    $user = 'root';
    $pwd = 'root';
    $dbname = '2212';
    // 连接数据库
    $con = mysqli_connect($host, $user, $pwd, $dbname);
    
    if (!$con) {
        die('数据库连接失败');    // 结束整个php语句
    }
