<?
$gfilename="group.txt";
$fp=fopen($gfilename,"r");
$win=2;
$lose=1;
$abstained=0;
$group="";
if(isset($_GET["group"]))
	$group=$_GET["group"];
while($gfp_data=fscanf($fp,"%s %s\n"))
{
    list($gname,$gfile)=$gfp_data;
	
	if(!strcmp($group,$gfile))
		break;
}
fclose($fp);
?>
<html>
<head>
<title><? echo $gname; ?>戰績表</title>
<style type="text/css">
<!--
.style1 {font-family: "標楷體"}
body {
        background-image: url();
}
td{text-align:center; padding:0}
-->
</style>
</head>
<body>

<?
/*
PHP 支援一個錯誤控制運算符「@」。當將其放置在一個 PHP 運算式之前，該運算式可能產生的任何錯誤資訊都被忽略掉。這功能有幾個目的：
安全性：避免因程式上的某些錯誤訊息將一些訊息告知了外界，而暴露系統上可能的安全漏洞。 
美觀：因為錯誤訊息會造成顯示畫面的混亂。
*/
$fp=@fopen($gfile.".txt","r");
if(!$fp)
	echo "<br><br><center><font size=+2 color=#EE1111>".$gname."戰績表不存在</font></center>";
else
{//else 1
?>
<!--
// Example:
// onMouseOver="toolTip('tool tip text here')";
// onMouseOut="toolTip()";
// -or-
// onMouseOver="toolTip('more good stuff', '#FFFF00', 'orange')";
// onMouseOut="toolTip()"; 
/*
MOVE this to the <body>:
<div id="toolTipLayer" style="position:absolute; visibility: hidden"></div>
<script language="JavaScript">
initToolTips();
</script>
*/
-->
<script>
var ns4 = document.layers;
var ns6 = document.getElementById && !document.all;
var ie4 = document.all;
var toolTipSTYLE="";
function initToolTips()
{
  if(ns4||ns6||ie4)
  {
    if(ns4) toolTipSTYLE = document.toolTipLayer;
    else if(ns6) toolTipSTYLE = document.getElementById("toolTipLayer").style;
    else if(ie4) toolTipSTYLE = document.all.toolTipLayer.style;
    if(ns4) document.captureEvents(Event.MOUSEMOVE);
    else
    {
      toolTipSTYLE.visibility = "visible";
      toolTipSTYLE.display = "none";
    }
    
  }
}
function toolTip( s1, s2, s3, s4, s5, s6 )
{
	
  if(toolTip.arguments.length < 1) // hide
  {
    if(ns4) toolTipSTYLE.visibility = "hidden";
    else toolTipSTYLE.display = "none";
  }
  else // show
  {
	if(s1==0) s1='0';
	if(s2==0) s2='0';
	if(s3==0) s3='0';
	if(s4==0) s4='0';
	if(s5==s6){	 s5='X'; s6='X';  	}
    var content =
    '<table width=60px height=50px border="0" cellspacing="0" cellpadding="0" style="background-color:#B5CBEF">'+
    '<tr><td >'+ s1 +'</td>' + '<td>-</td><td>'+ s2 + '</td></tr>'+
    '<tr><td>'+ s3 +'</td>' + '<td>-</td><td>'+ s4 + '</td></tr>'+
    '<tr><td>'+ s5 +'</td>' + '<td>-</td><td>'+ s6 + '</td></tr>'+
    '</table>';
    if(ns4)
    {
      toolTipSTYLE.document.write(content);
      toolTipSTYLE.document.close();
      toolTipSTYLE.visibility = "visible";
    }
    if(ns6)
    {
      document.getElementById("toolTipLayer").innerHTML = content;
      toolTipSTYLE.display= 'block';
    }
    if(ie4)
    {
      document.all("toolTipLayer").innerHTML=content;
      toolTipSTYLE.display='block';
    }
  }
}

//自動輸入比數
function score(s1,s2,game)
{
	if(game<3)	//第1,2局
	{
		if(s1.value<=23)
			s2.value=25;
		if(s1.value==24)
			s2.value=26;
	}
	if(game==3)	//第3局
	{
		if(s1.value<=13)
			s2.value=15;
		if(s1.value==14)
			s2.value=16;
	}
}
</script>

<?
//讀檔start:將整個檔案資料load到記憶體中(變數)

	$amount=fgets($fp,5); // 隊數
	
	//隊名五個中文字,所以是10 bytes,再加空白就11bytes
	$tmp=fgets($fp,($amount*11+2));
	/*
	$i=0;
	$tok=strtok ($tmp," ");
	while($tok)
	{
		$teams[$i]=$tok;
        	$i++;
		$tok = strtok (" "); 
	}*/
	//$teams=split(" ",chop($tmp),$amount);
	$teams = explode(" ", rtrim($tmp), $amount); //php 7.0 later

	//扣分
	$tmp=fgets($fp,($amount*3+2));
	//$deduction=split (" ",chop($tmp),$amount);
	$deduction = explode(" ", rtrim($tmp), $amount); //php 7.0 later
	
	//$temps[$amount-1]=strtr($temps[$amount-1],"\n"," ");
	//if($amount!=$i)
		//總隊數和實際隊數不同
	//parse score解析對戰分數
	for($i=0;$i<$amount;$i++)
	{
		for($j=0;$j<$amount;$j++)
		{
			if($j<=$i)//對角線以下的去掉
				continue;
			if(feof($fp))
				break;
			$tmp=rtrim(fgets($fp,26));//8*3+2
			//$score[$i*$amount+$j]=split (" ",$tmp,8);
			$score[$i * $amount + $j] = explode(" ", $tmp, 8); //php 7.0 later
		}
		if(feof($fp))
			break;
	}
	fclose($fp);//close  fopen($gfile.".txt","r");

//讀檔end
?>

<div class="display" ><table style='font-size:15px' width='780px' height='275px' border='0' cellpadding='0' cellspacing='0'>
	<tr height=30px bgcolor=#DDAACC >
	 <td width='50px'>隊\Ｖ<br>伍\Ｓ</td>
<?
	//印出戰績表
	for($i=0;$i<$amount;$i++)
		echo "<td width=50px'>".$teams[$i]."</td>";
	echo "<td width='80px'> 積 分<br>(未算扣分)</td>";
	echo "<td width='40px'> 扣 分<br></td>";
	echo "<td width='55px'><font color=blue>總積分(勝/敗)</font><br></td>";
	echo "<td width='65px'><i>未比場數</i></td>";
	//echo "<td width='70px'>最高可得積分(以剩下場數都為剩場計算)</td>";
	echo "</tr>";
	for($i=0;$i<$amount;$i++)
  {
		$score_t=0;	//積分
		$ac=0;
		$win_game=0;  //勝場數
		$lose_game=0; //敗場數
		$win_round=0; //勝局數
		$lose_round=0; //敗局數
		
		echo "<tr bgcolor=#DDAACC border='0' cellpadding='0' cellspacing='0' onmouseover=\" this.style.background='#999999';\" onmouseout=\"this.style.background='#DDAACC';\">";
		echo "<td width='50px'>".$teams[$i]."</td>\n";
	  
		for($j=0;$j<$amount;$j++)
		{
			if($i==$j)//對角線的處理
			{
				echo "<td>Ｏ</td>\n";
				continue;
			}
			if($j<$i)//對角線以下的處理
			{
				if($score[$j*$amount+$i][7]==0 && $score[$j*$amount+$i][6]==0)
				{
					$ac++;
					echo "<td>--</td>\n";
				}
				else
				{
					if($score[$j*$amount+$i][1]==-1)
						echo "<td onMouseOver=\" toolTip(".$score[$j*$amount+$i][1].",".$score[$j*$amount+$i][0].",".$score[$j*$amount+$i][3].",".$score[$j*$amount+$i][2].",".$score[$j*$amount+$i][5].",".$score[$j*$amount+$i][4]." )\" onMouseOut=\" toolTip() \"><strong> X：".$score[$j*$amount+$i][6]."</strong></td>\n";
					else if($score[$j*$amount+$i][0]==-1)
						echo "<td onMouseOver=\" toolTip(".$score[$j*$amount+$i][1].",".$score[$j*$amount+$i][0].",".$score[$j*$amount+$i][3].",".$score[$j*$amount+$i][2].",".$score[$j*$amount+$i][5].",".$score[$j*$amount+$i][4]." )\" onMouseOut=\" toolTip() \"><strong>".$score[$j*$amount+$i][7]."：X </strong></td>\n";
					else
						echo "<td onMouseOver=\" toolTip(".$score[$j*$amount+$i][1].",".$score[$j*$amount+$i][0].",".$score[$j*$amount+$i][3].",".$score[$j*$amount+$i][2].",".$score[$j*$amount+$i][5].",".$score[$j*$amount+$i][4]." )\" onMouseOut=\" toolTip() \"><strong>".$score[$j*$amount+$i][7]."：".$score[$j*$amount+$i][6]."</strong></td>\n";
					$win_round  += $score[$j*$amount+$i][7];
					$lose_round += $score[$j*$amount+$i][6];
				}
				//echo "<td></td>\n";

				//算積分
				if($score[$j*$amount+$i][6] > $score[$j*$amount+$i][7])
				{
					if($score[$j*$amount+$i][1]==-1)	//棄賽
					{
						$score_t+=$abstained;
						$lose_game++;
					}
					else{
						$score_t+=$lose;	//lose
						$lose_game++;
					}
				}
				else if($score[$j*$amount+$i][6]<$score[$j*$amount+$i][7]) {
					$score_t+=$win;	//win
					$win_game++;
				}
				else;

			}
			else	//對角線以上的處理
			{
				if($score[$i*$amount+$j][7]==0 && $score[$i*$amount+$j][6]==0)
				{
					$ac++;
					echo "<td>--</td>\n";
				}
				else
				{
					if($score[$i*$amount+$j][1]==-1)
						echo "<td onMouseOver=\" toolTip(".$score[$i*$amount+$j][0].",".$score[$i*$amount+$j][1].",".$score[$i*$amount+$j][2].",".$score[$i*$amount+$j][3].",".$score[$i*$amount+$j][4].",".$score[$i*$amount+$j][5].")\" onMouseOut=\" toolTip() \"><strong>".$score[$i*$amount+$j][6]."：X </strong></td>\n";
					else if($score[$i*$amount+$j][0]==-1)
						echo "<td onMouseOver=\" toolTip(".$score[$i*$amount+$j][0].",".$score[$i*$amount+$j][1].",".$score[$i*$amount+$j][2].",".$score[$i*$amount+$j][3].",".$score[$i*$amount+$j][4].",".$score[$i*$amount+$j][5].")\" onMouseOut=\" toolTip() \"><strong> X：".$score[$i*$amount+$j][7]."</strong></td>\n";	
					else
						echo "<td onMouseOver=\" toolTip(".$score[$i*$amount+$j][0].",".$score[$i*$amount+$j][1].",".$score[$i*$amount+$j][2].",".$score[$i*$amount+$j][3].",".$score[$i*$amount+$j][4].",".$score[$i*$amount+$j][5].")\" onMouseOut=\" toolTip() \"><strong>".$score[$i*$amount+$j][6]."：".$score[$i*$amount+$j][7]."</strong></td>\n";
					$win_round  += $score[$i*$amount+$j][6];
					$lose_round += $score[$i*$amount+$j][7];
				}
				//算積分
				if($score[$i*$amount+$j][6] > $score[$i*$amount+$j][7]) {
					$score_t+=$win;	//win
					$win_game++;
				}
				else if($score[$i*$amount+$j][6] < $score[$i*$amount+$j][7])
				{
					if($score[$i*$amount+$j][0]==-1)
					{
						$score_t+=$abstained;	//棄賽
						$lose_game++;
					}
					else {
						$score_t+=$lose;	//lose
						$lose_game++;
					}
				}
				else;
			}
		}
		echo "<td>$score_t</td>"; //原始積分
		echo "<td>".(-$deduction[$i])."</td>"; //扣分 (-$deduction[$i]為了顯示負的)
		echo "<td>".($score_t-$deduction[$i])." ($win_game/$lose_game)</td>"; //總積分
		echo "<td>$ac</td>\n"; //未比賽場數
		//echo "<td>".(($score_t-$deduction[$i])+($ac*$win))."</td>\n";
		echo "</tr>\n";
		                  // (勝場-扣分場)  / (已比賽場數)  --扣分場算法 = 扣分/(勝敗積分差)
		//@$rank[$teams[$i]]['ratio']=($win_game-($deduction[$i]/($win-$lose)))/($win_game+$lose_game);
		@$rank[$teams[$i]]['ratio']=($score_t-$deduction[$i]);
		$rank[$teams[$i]]['rgame']=$win_game;
		//echo($win_round."-".($lose_round).":".($win_round/($lose_round)));
		if($lose_round!=0)
			@$rank[$teams[$i]]['round']=($win_round/($lose_round));
		else
			@$rank[$teams[$i]]['round']=0;
		
	}

}//else 1 end
?>
</tr>
</table></div>
<br>
<b>目前</b>排名(<font color=red>積分</font>->勝場數->勝局/敗局 比):<br>
 &nbsp;&nbsp;&nbsp;
<?
	arsort($rank);

	$tmp=-1;
	$tmp_wgame=-1;
	for(reset($rank),$i=1 ; $key = key($rank) ; next($rank),$i++) {
		if($tmp_wgame==$rank[$key]['rgame'])
    	if($tmp==$rank[$key]['round'])
    		$i--;
    $tmp_wgame=$rank[$key]['rgame'];
    $tmp=$rank[$key]['round'];
    echo "<b>$i.</b>" .$key." &nbsp;\n";
		//echo "<b>$i.</b>" .$key."(".$rank[$key]['round'].") \n";
	}
?>
<br>
<br>
比分:請將游標移到比數(X:X)上,比分會顯示在戰績表左下方
<br>
<hr>
<div  id="toolTipLayer" style="position:absolute">
<!-- javascript change inner html -->
</div>
<script language="JavaScript">
<!--//要放在div之後 
initToolTips(); //-->
</script>
<font color=#1133EE size=+1>回報/修改分數 : </font><br>
<form method="POST" action="editscore.php" >
比賽隊伍 : 
<?
//列出分組比賽隊伍
for($i=1;$i<=2;$i++)
{
	echo "<select name=\"team".$i."\">\n";
		for($j=0;$j<$amount;$j++)
		{
			echo "<option value=\"".$teams[$j]."\">".$teams[$j]."</option>\n";
		}
	echo "</select>\n";
	if($i==1)
		echo " V.S. ";
}
echo "<br>\n";
for($i=1;$i<=3;$i++)
{
	echo "game".$i." : \n";
	for($j=1;$j<=2;$j++)
	{
		if($j==1)
			echo "<select name=s".(($i-1)*2+$j)." onChange=\"score(this,s".(($i-1)*2+$j+1).",".$i.")\">\n";
		else
			echo "<select name=s".(($i-1)*2+$j)." onChange=\"score(this,s".(($i-1)*2+$j-1).",".$i.")\">\n";
		for($k=0;$k<=35;$k++)
		{
			echo "<option value=".$k.">".$k."</option>";
			if($k%3==2)
				echo "\n";
		}
		echo "<option value=-1>棄賽</option>";	//-1代表棄賽
		echo "</select>\n";
		if($j==1)
			echo "--\n";
	}
	echo "<br>\n";
}
?>
<br>
<input type="hidden" name=group value=<?echo $gfile;?>>
<input type="submit" value=送出>
<input type="reset" value=重新輸入>
</form>
<?
include 'sign.php';
sign();
?>
</body>
</html>
