<?
include 'function.php';
check_login();
#session_start();
if(!isset($_SESSION['pro']) || $_SESSION['pro']>10)
{
	echo "你的權限不足!!\n";
	exit;
}
$gname="";
$group="";
$team1="team1";
$team2="team2";
if(isset($_POST["gname"]))
	$gname=$_POST["gname"];
if(isset($_POST["group"]))
	$group=$_POST["group"];
if(isset($_POST["team1"]))
	$team1=$_POST["team1"];
if(isset($_POST["team2"]))
	$team2=$_POST["team2"];
?>
<html>
<head>
<title>分數回報及修改</title>
<style type="text/css">
<!--
.style1 {font-family: "標楷體"}
body {
        background-image: url();
}
-->
</style>
<?
$fp=fopen($group.".txt","r");
if(!$fp)
        echo "<br><br><center><font size=+2 color=#EE1111>".$gname."戰績表不存在</font></center>";
else
{//else 1
	$amount=fgets($fp,5);
	
	//隊名五個中文字,所以是10 bytes,再加空白就11bytes
	$tmp=fgets($fp,($amount*11+2));
	
	$teams_str=$tmp;
	//$teams=split (" ",chop($tmp),$amount);
	$teams = explode(" ", rtrim($tmp), $amount); //PHP 7.0 later

  //扣分
  $tmp=fgets($fp,($amount*3+2));
  $deduction_str=$tmp;
	//$deduction=split (" ",chop($tmp),$amount);
	
	//$temps[$amount-1]=strtr($temps[$amount-1],"\n"," ");
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
                        //$score[$i*$amount+$j]=split (" ",$tmp,$amount);
						$score[$i * $amount + $j] = explode(" ", $tmp, $amount); //PHP 7.0 later
                }
                if(feof($fp))
                        break;
        }
fclose($fp);	//$fp=@fopen($group.".txt","r");
}//else 1 end


//找出對戰隊伍
for($i=0;$i<$amount;$i++)
{
	//if(!strcmp($teams[$i],$team1))
	if ($teams[$i] === $team1)  //PHP 8.1 later	
	{
		$ai=$i;
		continue;
	}
  	//if(!strcmp($teams[$i],$team2))
	if ($teams[$i] === $team2) //PHP 8.1 later
	{
		$aj=$i;
	}
}

//計算每場贏的局數
$gs1=0;
$gs2=0;
$s1=0;
$s2=0;
$s3=0;
$s4=0;
$s5=0;
$s6=0;
if(isset($_POST['s1']))
	$s1=$_POST['s1'];
if(isset($_POST['s2']))
	$s2=$_POST['s2'];
if(isset($_POST['s3']))
	$s3=$_POST['s3'];
if(isset($_POST['s4']))
	$s4=$_POST['s4'];
if(isset($_POST['s5']))
	$s5=$_POST['s5'];
if(isset($_POST['s6']))
	$s6=$_POST['s6'];
if($s1 > $s2)
	$gs1++;
else
	$gs2++;
if($s3 > $s4)
	$gs1++;
else
	$gs2++;
if($s5!=0 || $s6!=0)
{
	if($s5 > $s6)
		$gs1++;
	else
		$gs2++;
}

//記錄分數
$error=0;
if($ai==$aj)
	$error=1;	//別開玩笑了!自己打自己
if($s5!=0 || $s6!=0)
	if( abs($s1-$s2)<2 || abs($s3-$s4)<2 || abs($s5-$s6)<2 )
		$error=2;	//每局分數必須差兩分已上!!(3局)
else
	if( abs($s1-$s2)<2 || abs($s3-$s4)<2)
		$error=3;	//每局分數必須差兩分已上!!(2局)
if(($gs1+$gs2)==3 && ($gs1==0 && $gs2==0))
	$error=3;
if(($gs1+$gs2)>3)
	$error=3;
if($s1==0 && $s2==0 && $s3==0 && $s4==0 && $s5==0 &&  $s6==0 )
	{$error=0;$gs1=0;$gs2=0;}

if($error==0)
{
	if($ai>=$aj)
	{
		for($i=0;$i<8;$i++)
			$old_score[$i]=$score[$aj*$amount+$ai][$i];
		$score[$aj*$amount+$ai][0]=$s2;
		$score[$aj*$amount+$ai][1]=$s1;
		$score[$aj*$amount+$ai][2]=$s4;
		$score[$aj*$amount+$ai][3]=$s3;
		$score[$aj*$amount+$ai][4]=$s6;
		$score[$aj*$amount+$ai][5]=$s5;
		$score[$aj*$amount+$ai][6]=$gs2;
		$score[$aj*$amount+$ai][7]=$gs1;
	}
	else
	{
		for($i=0;$i<8;$i++)
			$old_score[$i]=$score[$ai*$amount+$aj][$i];
		$score[$ai*$amount+$aj][0]=$s1;
		$score[$ai*$amount+$aj][1]=$s2;
		$score[$ai*$amount+$aj][2]=$s3;
		$score[$ai*$amount+$aj][3]=$s4;
		$score[$ai*$amount+$aj][4]=$s5;
		$score[$ai*$amount+$aj][5]=$s6;
		$score[$ai*$amount+$aj][6]=$gs1;
		$score[$ai*$amount+$aj][7]=$gs2;
	}
	//寫入檔案
	$fp=fopen($group.".txt","w");
	fputs($fp,$amount);
	fputs($fp,$teams_str);
	fputs($fp,$deduction_str);
        for($i=0;$i<$amount;$i++)
        {
                for($j=0;$j<$amount;$j++)
                {
                        if($j<=$i)//對角線以下的去掉
                                continue;
			for($k=0;$k<7;$k++)
			{
                        	fputs($fp,$score[$i*$amount+$j][$k]." ");
			}
			fputs($fp,$score[$i*$amount+$j][7]."\n");
                }
	}
	fclose($fp);

	//安全機制,記錄修改人的資訊
	//Client端有設定Proxy時,PHP環境變數HTTP_X_FORWARDED_FOR就會有值
	$ip_client_ary=getenv("HTTP_X_FORWARDED_FOR");
	if($ip_client_ary==NULL)
		$ip_client=getenv("REMOTE_ADDR");
	else{
		//另外要考慮到會有FORWARDED多個地方，最前面即是真實IP
		$ip_client_ary=explode(',',$ip_client_ary,2);
		$ip_client=$ip_client_ary[0];
	}
	//$time = getdate();
	$time =  date ("l dS of F Y h:i:s A");
	$fp = fopen("score_log.txt", "a");
	fputs($fp,$_SESSION['user']." ".$time."  IP: ".$ip_client);
	fputs($fp," ".$team1." VS. ".$team2."  score=".$s1." ".$s2." ".$s3." ".$s4." ".$s5." ".$s6);
	fputs($fp," old_score= ");
	for($i=0;$i<7;$i++)
		fputs($fp,$old_score[$i]." ");
	fputs($fp,$old_score[7]."\n");
	
	fclose($fp);
}//error end
?>
<?
echo "<meta http-equiv=\"refresh\" content=\"3; url=score.php?group=".$group."\">\n";
?>
</head>
<body>
<font size=+2 color=#11FF22>
<?
	switch($error)
	{
		case 0:
			echo "分數新增或修改完成<br>\n";
			break;
		case 1:
			echo "別開玩笑了!自己打自己<br>\n";
			break;
		case 2:
		case 3:
			echo "每局分數必須差兩分已上!!<br>\n";
			break;
		default:
	}
	echo "<a href=score.php?group=".$group.">回戰績表</a>\n";
?>
</font>
<?
include 'sign.php';
sign();
?>
</body>
</html>
