<?
session_start();

$tmp=0;
$time=0;
$handle=opendir('.');
$i=0;
while ($file[$i] = readdir($handle)) {
	if ($file == "." || $file == "..") 
					continue;
					
	if($file[$i] == "count.txt")
	{
		$i++;
		continue;
	}
	$tmp=filectime ($file[$i]);
	if($tmp>$time)
		$time=$tmp;
	$i++;
}
closedir($handle);
sort($file);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>選單頁框</title>
<style type="text/css">
<!--
.style1 {font-family: "標楷體"}
body {
	background-image: url(images/ba004.gif);
}
-->
</style>
</head>

<body>
<?
	  if ( !($fp = fopen("count.txt", "r")) )  {
  	  echo "File open fail";
  	}
	 else
	 {
 	  fscanf($fp,"%d",$count);
		fclose($fp);
	 
	 if(!isset($_SESSION['count'])||$_SESSION['count']!=true)
  	 {
 		 $count++;
 	 	 $fp = fopen("count.txt", "w");
 	  	 fputs($fp,$count);
 	   	 fclose($fp); 
 	   	 $_SESSION['count']=true; 
 	 	 }
 	 	
 	 }
 	echo "<font size=-1 color=#1111FF>歡迎光臨:<br>您是第".$count."顆排球</font>\n<br><br>";
?>
<!------------ 插入控制碼區段開始 ------------> 
<span id=tick2>
</span>
<script>
<!--

/*By Website Abstraction
http://wsabstract.com
Credit MUST stay intact for use
*/

function show2(){
if (!document.all&&!document.getElementById)
return
thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var seconds=Digital.getSeconds()
var dn="PM"
if (hours<12)
	dn="AM"
if (hours>12)
	hours=hours-12
if (hours==0)
	hours=12
if (minutes<=9)
	minutes="0"+minutes
if (seconds<=9)
	seconds="0"+seconds
var ctime=hours+":"+minutes+":"+seconds+" "+dn
thelement.innerHTML="<b style='font-size:14;color:#EE1111;'>now: "+ctime+"</b>"
setTimeout("show2()",1000)
}
window.onload=show2
//-->
</script>
<!------------ 插入控制碼區段結束 ------------> 

<hr>
<font color="#22EE11">
<?
if (isset($_SESSION['authenticated'])&& $_SESSION['authenticated'] == true)
	echo $_SESSION['user']." 你好!!";
else
	echo "guest 你好!!";
?>
</font>
<br>
<br>
<!--------Menu Contents----------------->
  <script language="JavaScript" src="./scripts/tree.js"></script>
  <script language="JavaScript">
  foldersTree = gFld("CCU V league","","10")
  aux1 = insFld(foldersTree, gFld("V聯盟"))
	  insDoc(aux1, gLnk(0, "簡介", "intro.htm"))
	  insDoc(aux1, gLnk(0, "幹部名單", "leader.htm"))
	  insDoc(aux1, gLnk(0, "排球聯盟公定原則", "rule.htm"))
  aux4 = insFld(foldersTree, gFld("裁判講習"))
	  insDoc(aux4, gLnk(0, "主審副審手勢說明", "geste.pdf"))
	  <?
		for($i=0;$i<count($file);$i++) {
   		if(stristr($file[$i],"referee_exam"))
   		{
   			$year=substr($file[$i], 0,strpos($file[$i],'r'));
   			echo" insDoc(aux4, gLnk(0, \"".$year."聯盟裁判考試通過者名單\", \"".$file[$i]."\")) \n";
   		}
   	}

	  ?>
  aux5 = insFld(foldersTree, gFld("各隊資訊"))
	  <?
	   echo "insDoc(aux5, gLnk(0, \"------男排名單------\", \"\"))\n";
	 	 $fp=fopen("teams.txt","r");
	 	 $group=trim(fgets($fp,20));
	 	 while(1)
	 	 {
	 	 	$tname=trim(fgets($fp,20));
	 	 	if(!strcmp($tname,"[end]"))
	 	 		break;
	 	 	if(!strcmp($tname,"girl"))
	 	 	{
	 	 		$group=$tname;
	 	 		echo "insDoc(aux5, gLnk(0, \"------女排名單------\", \"\"))\n";
	 	 		continue;
	 	 	}
	 	 	if($tname=="")
	 	 		continue;
	 	 		echo "insDoc(aux5, gLnk(0, \"".$tname."\", \"teams_list.php?group=".$group."&tname=".$tname."\"))\n";
	 	 }
	 	 fclose($fp);
	  ?>
	  
  aux2 = insFld(foldersTree, gFld("賽程"))
  	insDoc(aux2, gLnk(0, "比賽場地", "place.jpg"))
  <?
    for($i=0;$i<count($file);$i++) {
   		if(stristr($file[$i],"week"))
   		{
   			$week=substr($file[$i], 4,2);  

   			echo" insDoc(aux2, gLnk(0, \"第".$week."週賽程\", \"".$file[$i]."\")) \n";
   			//insDoc(aux2, gLnk(0, "第".$week."週賽程", "week02.htm"))
   		}
   		if(stristr($file[$i],"playoff"))
   			echo" insDoc(aux2, gLnk(0, \"季後賽賽程\", \"".$file[$i]."\")) \n";
	 }

  ?>
  aux3 = insFld(foldersTree, gFld("戰績"))
	
	<?
		if($_SESSION['pro']<10 && $_SESSION['pro'] != "")
		{
				echo "insDoc(aux3, gLnk(0, \"戰績表新增\",\"addgroup.php\"))\n";
				echo "insDoc(aux3, gLnk(0, \"積分扣分修改\",\"deduction.php\"))\n";
		}
		$gfilename="group.txt";
		$fp=fopen($gfilename,"r");
		while($gfp_data=fscanf($fp,"%s %s\n"))
		{
		 	list($gname,$gfile)=$gfp_data;
			echo "\n\tinsDoc(aux3, gLnk(0, \"".$gname."戰績表\",\"score.php?group=".$gfile."\"))\n";
		}
		fclose($fp);

	?>
 <?
 	if($_SESSION['pro']<10 && $_SESSION['pro'] != "")
 	{
 		echo "insDoc(foldersTree, gLnk(0, \"上傳檔案\", \"explorer.php\"))\n";
 		echo "insDoc(foldersTree, gLnk(0, \"傳送訊息到各隊連絡人的MSN中\", \"msn.php\"))\n";
 		echo "insDoc(foldersTree, gLnk(0, \"V聯盟Web管理者使用手冊\", \"guide.htm\"))\n";
 		echo "insDoc(foldersTree, gLnk(0, \"HTML文件外字相容轉換器(可轉Unicode的代碼)\", \"converter.htm\"))\n";
 	}

	if($_SESSION['authenticated'] == true)
	{
		echo "insDoc(foldersTree, gLnk(0, \"修改密碼\", \"password.php\"))\n" ;
 		echo "insDoc(foldersTree, gLnk(0, \"登出\", \"logout.php\"))\n"; 		
 	}
	else
		echo "insDoc(foldersTree, gLnk(0, \"登入\", \"login.php\"))\n";
		
		
 ?>
 
 insDoc(foldersTree, gLnk(3, "回首頁", "index.htm"))
initializeDocument();

//請使用支援JavaScript的瀏覽器瀏覽...thx...
</script>
<br><br><br>
<hr>
最後更日期:
<?

echo date("M d Y",$time);
?>
<br>
Email:<a href="mailto:yotrew@km.cs.ccu.edu.tw">Yotrew Wing</a>
<br>
<font size=+2 color=#99CC11>徵美工 >.<</font>
</body>
</html>
