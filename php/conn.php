<?php
	// 响应头 配置CORS   => 控制允许访问的来源
	@header("Access-Control-Allow-Origin:*");  //允许所有人访问
	
	// @header("Access-Control-Allow-Origin:http://127.0.0.1:5500");  //live server访问: http://127.0.0.1:5500
	// @header("Access-Control-Allow-Origin:http://192.168.58.247");

	/* // 1. 连接mysql (创建连接)
	// mysqli_connect(hostname,user,pwd)     创建连接  
	// 返回值: 连接成功 连接对象(mysql相关的信息)   失败 => false

	// hostname 主机名
	// user 用户名
	// pwd  密码

	$conn = mysqli_connect("localhost:3306", "root", "root111");
	// print_r($conn);

	// 2. 选择数据库  
	// mysqli_select_db($conn,dbName);     选择数据库  
	// 返回值: 选择成功 =>true   失败 => false
	$res = mysqli_select_db($conn, "2210");

	if (!$res) {
		exit('{"status":false,"message":"数据库链接失败"}');
	}

	echo "连接成功"; */


	// 连接mysql (创建连接)  选择数据库
	// 返回值: 连接成功 连接对象(mysql相关的信息)   失败 => false
	$conn = mysqli_connect("localhost:3306", "root", "root", "2212");
	if (!$conn) {
		exit('{"status":false,"message":"数据库链接失败"}');
	}

	// mysqli_query($conn,$sql)
	// $conn  mysql链接
	// $sql   执行的sql语句

	// 返回值:   mysqli =>增删改(语句执行成功)  查(返回查询的结果对象)
	// 对于成功的查询和描述语句，mysqli_query() 将返回一个mysql_result对象。对于其他成功的查询，mysqli_query() 将返回TRUE。失败时返回FALSE。

	// 描述
	mysqli_query($conn, "set names utf8"); // 从数据库取数据时  将编码转为utf-8;  
	mysqli_query($conn, "set character set utf-8"); // 向数据库存数据时  将编码转为utf-8

	// echo "连接成功"; //后续的代码
