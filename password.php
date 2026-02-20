<?
include 'function.php';
check_login();
$login_page="login.php";
$user_db="user.txt";
$user_db_bak="user.bak";
$crypt_salt="login";

//session_start();

$sucess=false;
$password="";
$newpassword="";
$newpassword1="";
if(isset($_POST['password']))
	$password=$_POST['password'];
if(isset($_POST['newpassword']))
	$newpassword=$_POST['newpassword'];
if(isset($_POST['newpassword1']))
	$newpassword1=$_POST['newpassword1'];
if(isset($_POST['sucess']))
	$sucess=$_POST['sucess'];

if($password=="" || $newpassword=="" || $newpassword1=="")	//if1
{
} //end if1
else
{
	if( strcmp($newpassword,$newpassword1) == 0)
	{
		
		 $fp=fopen($user_db,"r");
		 $fp_bak=fopen($user_db_bak,"w");
	   while($user_data=fscanf($fp,"%s %s %s %s %s %s %s\n"))
        {
            list($f_user,$f_passwd,$f_name,$f_depart,$email,$tel,$pro)=$user_data;
		         $tmp=crypt($password,$crypt_salt);
		          if($_SESSION['user']==$f_user)
		           if($tmp==$f_passwd)	//認證成功
		           {
		               $tmp=crypt($newpassword,$crypt_salt);
		               $f_passwd=$tmp;
		               $sucess=true;
		           }
		          
		          fputs($fp_bak,"$f_user $f_passwd $f_name $f_depart $email $tel $pro\n");
		     }
		     fclose($fp);
		     fclose($fp_bak);
		     copy($user_db_bak,$user_db); 
	}
}
?>		

<html>
<head>
<title>修改密碼</title>
</head>
<body>
<?
if($password!="" || $newpassword!="" || $newpassword1!="")
{
     if( strcmp($newpassword,$newpassword1) != 0)
	      echo "兩次新密碼輸入不同!!<br>\n";

		 else if($sucess==false)
			echo "密碼修改失敗<br>\n";
}

if($sucess==false)
{
?>
	<form name="form1" id="form1" method="post" action="password.php">
    <p align="center">舊密碼：
    <input name="password" type="password" id="password" />
    </p>
    <p align="center">新密碼：
    <input name="newpassword" type="password" id="newpassword" />
    </p>
    <p align="center">再次輸入新密碼：
    <input name="newpassword1" type="password" id="newpassword1" />
    </p>
    <p align="center">
    <input type="submit" name="Submit" value="送 出" />
    <input type="reset" name="reset" value="反 悔" />
    </p>
	</form>
<?
}
 else
 	echo "密碼修改ok!\n";
?>
<?
include 'sign.php';
sign();
?>     
</body>
</html>