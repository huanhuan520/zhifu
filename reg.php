<?php
try{
//接收post传过来的值
//$_SERVER['REQUEST_METHOD']
if($_SERVER['REQUEST_METHOD'] ==='POST'){
	//接收从页面传过来的值
	//trim()去掉字符串前后的空格
	$username=trim($_POST['username']);
	$password=$_POST['password'];
	//2通过正则验证表单传过来的值是否正确
	//数字 字母 下划线
	$reg='/^\w{4,16}$/i';
	if(!preg_match($reg,$username)){
       throw new Exception('用户名必须是数字，字母，下划线',101);
  }             
  if(!preg_match($reg,$password)){
       throw new Exception('密码必须是数字，字母，下划线',101);
  } 
  $pdo=new PDO('mysql:host=localhost;dbname=mvc','root','');
//设置字符集
  if($pdo->exec("SET NAMES UTF8") === FALSE){
  	throw new Exception('设置字符集有误',100);
  }
   //将表单传过来的值插入数据库 使用pdo预处理
  $stmts=$pdo->prepare('INSERT INTO `mvc_user`(username,password) VALUES(?,?)');
  //执行预处理
  if($stmts->execute([$username,md5($password)] )=== FALSE){ 
  	throw new Exception('插入数据库失败',100);
  }else{
  	echo '<meta charset="utf-8">注册成功';
  	exit;
  }

 }  
}
     catch(Exception $e){
     	echo 'error:'.$e->getMessage();
     	echo' <div id="info">3</div>秒之后跳转';
     	echo '<script>
            var i=document.getElementById("info");
            //获取div标签中文本内容
            //parseInt ()将文本内容转换成整数
            var v=parseInt(i.innerHTML);
            //setInterval()根据第二参数，来不停地来调用第一个参数
            setInterval(function(){
            	v--;
            	 if(v<=0){
            	location.href="reg.php";
            }else{
             i.innerHTML=v;
            }
        },1000)
           

     	</script>';
     exit;
     }
?>
    

<!DOCTYPE html>
<html lang="en">      
<head>
	<meta charset="UTF-8">
	<title>注册</title>
</head>
<body>
	<h1>注册</h1>
	<form method="post">
		<div>用户名：<input type="text" name="username"></div>
		<div>密　码：<input type="password" name="password"></div>
		<div><input type="submit" value="注册"></div>
	</form>
</body>
</html>