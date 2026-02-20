<?
$crypt_salt="login";
$user_db="user.txt";
$admin_email="yotrew@km.cs.ccu.edu.tw";
$default_limit=99;

if($user!="" && $password !="")
{
	$fp=fopen($user_db,"r");
	$user=trim($user);
        while($user_data=fscanf($fp,"%s %s %s %s %s %s %s\n"))
        {
                list($f_user,$f_passwd,$f_name,$f_depart,$f_email,$f_tel,$f_pro)=$user_data;
		if($f_user==$user)
		{
			echo "帳號已存在!!!\n";
			exit;
			break;
		}
	}
	fclose($fp);
	if($password != $password1)
	{
		echo "兩次密碼不一樣\n";
		exit;
	}
	if($email=="")
	{
		echo "為了方便聯絡您,請輸入email!!<br>\n謝謝!!!\n";
		exit;
	}
	else{
		$fp=fopen($user_db,"a");
		$tmp=crypt($password,$crypt_salt);
		$name=strtr(trim($name)," ","_");	//將字串中的空白轉換"_"
		$email=trim($email);
		$tel=trim($tel);
		fputs($fp,"$user $tmp $name $department $email $tel $default_limit\n");
		fclose($fp);
		$message="$user: 你好\n";
		mail("yotrew@km.cs.ccu.edu.tw","V聯盟註冊",$message,"From:$admin_email\nReply-To:$admin_email");
		echo "註冊成功!!!";
		exit;
	}
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>註冊</title>
<style type="text/css">
<!--
.style1 {font-family: "標楷體"}
body {
        background-image: url();
}
-->
</style>
</head>
<body>
<table>

<form name="reg" id="reg" method="post" action="register.php">
<tr><td>帳號：</td><td><input name="user" type="text" id="user" /></td></tr>
<tr><td>密碼：</td><td><input name="password" type="password" id="password" /></td></tr>
<tr><td>再確認密碼：</td><td><input name="password1" type="password" id="password1" /></td></tr>
<tr><td>姓名：</td><td><input name="name" type="text" id="name" /></td></tr>
<tr><td>系所</td><td><select name="department">
<option value="電機">電機</option>
<option value="資工">資工</option>
<option value="化工">化工</option>
<option value="機械">機械</option>
<option value="企管">企管</option>
<option value="資管">資管</option>
<option value="歷史">歷史</option>
<option value="政治">政治</option>
<option value="經濟">經濟</option>
<option value="法律">法律</option>
<option value="外文">外文</option>
<option value="生科">生科</option>
<option value="勞工">勞工</option>
<option value="財金">財金</option>
<option value="社福">社福</option>
<option value="通訊">通訊</option>
<option value="心理">心理</option>
<option value="中文">中文</option>
<option value="物理">物理</option>
<option value="成教">成教</option>
<option value="傳播">傳播</option>
<option value="犯防">犯防</option>
<option value=""></option>
</select></td></tr>
<tr><td>email：</td><td><input name="email" type="text" id="email" /></td></tr>
<tr><td>連絡電話：</td><td><input name="tel" type="text" id="tel" /> </td></tr>
<tr><td><input type="submit" name="Submit" value="註 冊" />  
<input type="reset" name="reset" value="重 填" /></td></tr>
</form>
</table>
<?
include 'sign.php';
sign();
?>
</body>
</html>
