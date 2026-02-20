<?
include 'function.php';
check_login();
session_start();
if($_SESSION['pro']>10)
{
	echo "你的權限不足!!\n";
	exit;
}
?>
<html> 
<head> 
    <title>線上檔案總管</title> 
    <style>body,td {font-size : 9pt;}</style> 
</head> 
<body> 
<form action="<?echo $PHP_SELF;?>" method="post" enctype="multipart/form-data"> 
上傳檔案： 
<input type="file" name="up_file"> 
<input type="submit" name="act" value="上傳"> 
</form> 
<? 
if ($act=="上傳"){ 
    if(empty($up_file_name)){ 
        echo "您沒有選擇要上傳的檔案呢！請按「瀏覽」選擇要上傳的檔案！"; 
    }else{ 
        $up_dir="."; 
        $dest="$up_dir/$up_file_name"; 
        if (@copy($up_file,$dest)){ 
            echo "$up_file_name 已順利上傳！（檔案大小：$up_file_size 位元組，檔案類型：$up_file_type ）"; 
        }else{ 
            echo "<font color=\"Red\">上傳失敗！</font>"; 
        } 
    } 
} 
?> 
<table " border="0" cellspacing="1" cellpadding="2" bgcolor="Silver"><tr> 
<td colspan="4" bgcolor="Navy"> 
<font color="White">線上檔案總管</font> 
</td></tr> 
<tr bgcolor="#D7D7D7"><td width="150" align="center">檔名</td>    <td width="120" align="center">大小</td>    <td width="200" align="center">修改日期</td></tr> 
<? 
$fd =opendir('.'); 
while($file = readdir($fd)): 
$file_size=filesize($file); 
$file_time=date("Y/m/d a h:i",filectime($file)); 
?> 
<tr bgcolor="White"><td><?echo $file;?></td> 
<td align="right"><?echo $file_size;?></td> 
<td align="right"><?echo $file_time;?></td> 
</tr> 
<? 
endwhile; 
closedir($fd); 
?> 
</table> 
</body> 
</html> 