<?php
/*
 * Created on 2015-11-17
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
  include("../config.db.php");
 include("Regist.html");

  if(isset($_POST['clickToRegist'])){
	//检查用户名是否重复
	$username=$_POST['username'];
	$sql="select * from users where user_id='$username'";
	$query=mysql_query($sql);
	$result=mysql_fetch_array($query);

	$exist='false';
	$exist=is_array($result);
	
		if($exist==1){
			echo "<script> alert('用户已存在!'); </script>";
		}
                if(empty($username)){
                        echo "<script> alert('用户名不能为空!');</script>";}
		else{
		$num = rand()%53;
		echo "<script> alert($num); </script>";
		$head_portrait = "../Pictures/"."$num".".gif";
		$pw=$_POST['password'];
	 	$sql="insert into users(user_id,user_password,user_name,user_sex,user_birthday,user_head_portrait,user_signature)".
	 	"values('$username','$pw','$_POST[nickname]','$_POST[sex]','$_POST[birthday]','$head_portrait','')";
		if(mysql_query($sql)){
			$_SESSION['uid']=$username;
			$_SESSION['user_shell']=md5($username.$_POST['password']);
			echo "<script> alert('注册成功');self.location.href='../views/index.php'; </script>";
			}
	 	}
}
	

?>
