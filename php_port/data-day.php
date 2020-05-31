<?php
    header("Content-Type:text/html;charset=utf8"); 
    header("Access-Control-Allow-Origin: *"); //解决跨域
    header('Access-Control-Allow-Methods:GET');// 响应类型  
    header('Access-Control-Allow-Headers:*'); // 响应头设置 
    #mysql_select_db("finance", $link); //选择数据库
    #mysql_query("SET NAMES utf8");//解决中文乱码问题
    $servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "finance";
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("连接失败: " . $conn->connect_error);
	} 
	$day = $_GET["day"];
    $sql = "SELECT * FROM index_basic WHERE trade_date LIKE \"$day\" "; //SQL查询语句 SELECT * FROM 表名
    #$rs = mysql_query($q); 
    $result = $conn->query($sql);//获取数据集
    if(!$result){
        die("数据库没有数据!");
    }
    //循环读取数据并存入数组对象
    $datas;$i=0;
    while($row = $result->fetch_assoc())
    {
        $data["name"] = $row["name"];
        $data["code"] = $row["ts_code"];
        $data["trade_date"] = $row["trade_date"];
        $data["pe"] = $row["pe"];
        $data["sort"] = $row["sort"];
        $datas[$i++]=$data;
    }
    //以json格式返回html页面
    echo urldecode(json_encode($datas));
?>