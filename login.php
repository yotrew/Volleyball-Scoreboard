<?
session_start();
$login_page="login.php";
$user_db="user.txt";
$crypt_salt="login";
if(!isset($page) || $page=="")
	$page="index.htm";
//echo($page);
$password="";
$user="";
if(isset($_POST["user"]))
	$user=$_POST["user"];
if(isset($_POST["password"]))
	$password=$_POST["password"];

if($user=="" && $password=="")
{
	if(isset($_SESSION['authenticated'])&&$_SESSION['authenticated'] ==true)
	{
		header ("Location: ".$page); 
		/*echo "<html>\n<head>\n<title>登入!!</title>\n";
                echo "</head>\n<body>\n";
                echo "已登入!!!";
                echo "</body></html>";
                exit;*/
	}
}
else
{
	//echo($user."-".$password);
	$fp=fopen($user_db,"r");
	while($user_data=fscanf($fp,"%s %s %s %s %s %s %s\n"))
        {
          list($f_user,$f_passwd,$f_name,$f_depart,$email,$tel,$pro)=$user_data;
		  $tmp=crypt($password,$crypt_salt);
 
		  
		  if($f_user!=$user)
			continue;
		
		if($tmp==$f_passwd)	//認證成功
		{
			
			$_SESSION['authenticated'] = true;
			$_SESSION['login_time'] = date('Y-m-d h:i:s');
			$_SESSION['user'] = $f_user;
			$_SESSION['pro'] = $pro;
			//header ("Location: ".$page."#top"); 
			echo "<html>\n<head>\n<title>認證OK!!</title>\n";
			echo "</head>\n<body>\n";
			//重導網頁
			#echo "<script>window.parent.frames.location.href=\"".$page."\";</script>";
			echo "<script>window.parent.frames.left.location=\"javascript:location.reload()\"</script>";
			echo "登入OK!!!";
			echo "</body></html>";
			exit;
		}
		else	//認證失敗
		{
			echo "<html>\n<head>\n<title>認證失敗</title>\n";
			echo "<meta http-equiv=\"refresh\" content=\"3; url=$login_page\">\n";
			echo "</head>\n<body>\n";
			echo "認證失敗";
			echo "</body></html>";
			exit;
		}
	}
	fclose($fp);
}
?>
<html>
<head>
<title>登入網頁</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form name="form1" id="form1" method="post" action="login.php">
<p align="center">帳號：
<input name="user" type="text" id="user" />
</p>
<p align="center">密碼：
<input name="password" type="password" id="password" />
</p>
<p align="center">
<input type="submit" name="Submit" value="登 入" />
</p>
</form>
<?
include 'sign.php';
sign();
?>
</body>
</html>

