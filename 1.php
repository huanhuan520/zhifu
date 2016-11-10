<?php
namespace model;
use PDO;
use Exception; 
class UserModel{
	//添加
	public function add($username,$password){
			/*******正则判断数据是否正确**********/
		//数字,字母.下划线组合的4-20
		$reg = '/^\w{4,20}$/';
		if(!preg_match($reg, $username)){
			throw new Exception('用户名是数字,字母.下划线组合的4-20为',101);
		}
		if(!preg_match($reg, $password)){
			throw new Exception('密码是数字,字母.下划线组合的4-20为',101);
		}

		/***连接数据库******/
		$pdo=new \PDO ('mysql:host=localhost;dbname=mvc','root','');
		// 设置字符集
		if($pdo->exec("SET NAMES UTF8")===FALSE){
			throw new Exception('设置字符集有误',100);
		}
       ///插入数据库 //
		 $stmts=$pdo->prepare('INSERT INTO `mvc_user`(username,password) VALUES(?,?)');
  //执行预处理
  if($stmts->execute([$username,md5($password)] )=== FALSE){ 
  	throw new Exception('插入数据库失败',100);
  }else{
  	return true;
  }

	}
}
