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
    $name = $_GET['name'];
    $sql = "SELECT * FROM index_basic WHERE trade_date LIKE \"$day\" AND name LIKE \"$name\";"; //SQL查询语句 SELECT * FROM 表名
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
    //echo json_encode($datas);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<title>php表单提交</title>
		<style>
			body{
				margin: 0;padding: 0;
				background-image: url(img/back1.jpg);
				background-repeat: repeat;				
				}
			.main{
				margin-right:auto ;
				margin-left: auto;
				background-repeat: no-repeat;
				width:  552px;
	            height: 552px;
			}
			.form{
				width: 510px;
				height: 410px;
				padding-top: 105px;
				
				position: relative;
			}
			label{
				display: inline-block;
				width: 160px;
				padding-left:20px ;
				text-align: right;
			}
		</style>
	</head>
	<body>
		
		<div class="main">
			<div class="form">
				<p><label>指数名称：</label>
					<?php echo $data["name"] ?>
				</p>
				<p><label>指数代码：</label>
					<?php echo $data["code"] ?>
				</p>
				<p><label>交易日期：</label>
					<?php echo $data["trade_date"] ?>
				</p>
				<p><label>市盈率：</label>
					<?php echo $data["pe"] ?>
				</p>
				<p><label>历史百分位：</label>
					<?php echo $data["sort"] ?>
				</p>
			</div>
		</div>
	</body>
</html>
