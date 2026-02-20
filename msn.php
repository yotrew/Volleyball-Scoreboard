<?
include 'function.php';
check_login();
//session_start();
if(!isset($_SESSION['pro']) || $_SESSION['pro']>10)
{
	echo "你的權限不足!!\n";
	exit;
}
$msg_file="msg.txt";
$msn_file="msn.txt";
$msn="";
$msg="";
if(isset($_POST["msn"]))
	$msn=$_POST["msn"];
if(isset($_POST["msg"]))
	$msg=$_POST["msg"];
?>


<html>
<head>
<title> 傳送訊息到各隊連絡人的MSN中 </title>
</style>
</head>

<body>
<?
 if($msn!="" && $msg!="") {
    //將BIG5碼轉成UTF-8,因為新的Linux系統都以UTF-8來存檔
    $token=sprintf ("%c%c",13,10);
	$msg=str_replace($token,"<nl>",$msg);
    //$msg=iconv("BIG5","UTF-8",$msg); 
    
 	  if(!strcmp($msn,"all")) {
 	   	$fp_msn = fopen($msn_file, "r");
 	   	$fp = fopen($msg_file, "a");
			while($fp_data=fscanf($fp_msn,"%s %s\n")) {
				list($team,$msn)=$fp_data;
				if(!strcmp($msn,"all"))
					continue;
	  		
	  		fwrite($fp,"$msn\n$msg\n");
	  	}
	  	fflush($fp);
			fclose($fp);	  		  	

	  	fclose($fp_msn);
 	  }
 	  else {
 	    $fp = fopen($msg_file, "a");
 	    fwrite($fp,"$msn\n$msg\n"); 
 	    fflush($fp);
	  	fclose($fp);
 	  }
 	  echo "訊息已完成輸入<br>\n";
 	  echo "訊息將傳送給:$msn<br>\n";
}
else {
?>
	<form action=msn.php method=POST>
	隊伍: <select name="msn">
<?

	$fp_msn = fopen($msn_file, "r");
	while($fp_data=fscanf($fp_msn,"%s %s\n")) {
	  list($team,$msn)=$fp_data;
	  echo "<option value=\"".$msn."\">".$team."</option>\n";
	}
?>
</select><br><br>
訊息: <br><textarea maxlength=600 length=550 name=msg cols=40 rows=10></textarea><br>
<input type="submit" value="送出"><input type="reset" value="重新輸入">
</form>
<?
fclose($fp_msn);
}
include 'sign.php';
sign();
?>
</body>
</html>