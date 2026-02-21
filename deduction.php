<?
include 'function.php';
check_login();

if(!isset($_SESSION['pro']) || $_SESSION['pro']>5)
{
	echo "你的權限不足!!\n";
	exit;
}
$team_name="";
if(isset($_POST["team_name"]))
	$team_name=$_POST["team_name"];
$gfilename="group.txt";
$fp=fopen($gfilename,"r");
$i=0;
while($gfp_data=fscanf($fp,"%s %s\n"))
{
	list($gname[$i],$gfile[$i])=$gfp_data;
	$i++;
}
$gamount=$i;
fclose($fp);
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

$team_name="";
$deduction="";
if(isset($_POST["team_name"]))
	$team_name=$_POST["team_name"];
if(isset($_POST["deduction"]))
	$deduction=$_POST["deduction"];
	
if($team_name!="" && $deduction!="")
{
	$sucess=false;
	if(strncmp($team_name,"boy",3)==0)
	{
		$file_name=substr($team_name,0,5);
		$team_name=substr($team_name,5,strlen($team_name));
	}
	else
  {
	  $file_name=substr($team_name,0,6);
	  $team_name=substr($team_name,6,strlen($team_name));
	}

	
	
	$fp=fopen($file_name.".txt","r");
	for($i=0;$i<$gamount;$i++)
	{
		$teams_amount[$i]=fgets($fp,5);
		$teams=fgets($fp,$teams_amount[$i]*10+1);//隊名長度5個中文字
		//$teams_name=split (" ",chop($teams),$teams_amount[$i]);		
		$teams_name = explode(" ", rtrim($teams), $teams_amount[$i]); //PHP 7.0 later
		for($j=0;$j<$teams_amount[$i];$j++)
		{
		  if(!strcmp(trim($teams_name[$j]),trim($team_name)))
	  	{
	  		$fp1=fopen("tmp.bak","w");
	  		fputs($fp1,$teams_amount[$i]);
	  		fputs($fp1,$teams);
	  		$tmp=fgets($fp,$teams_amount[$i]*3+1); //扣分最多為兩位數
	  		//$tmp=split (" ",chop($tmp),$teams_amount[$i]);	
			$tmp = explode(" ", rtrim($tmp), $teams_amount[$i]); //PHP 7.0 later
	  		for($k=0;$k<$teams_amount[$i];$k++)
	  		{
	  			if($k==$j)
	  			{
	  				  if($deduction==0)
	  						fputs($fp1,"0 ");
	  					else
	  						fputs($fp1,($tmp[$k]+$deduction)." ");
	  			}
	  			else
	  				fputs($fp1,$tmp[$k]." ");
	  		}
	  		fputs($fp1,"\n");
	  		while($tmp=fgets($fp,30))
	  			fputs($fp1,$tmp);
	  		@copy("tmp.bak","$file_name.txt");
	  		fclose($fp1);
	  		$sucess=true;
	  		break;
		  }		  
	  }
	  if($sucess)
	  {
	  	fclose($fp);
	  	break;
	  }
	fclose($fp);
	}
	
	echo "</head><body><font size=+2 color=#11FF22>扣分修改完成</font></body></html>";
}
else {	//else 1

for($i=0;$i<$gamount;$i++)
{
	$fp=fopen($gfile[$i].".txt","r");
	$teams_amount[$i]=fgets($fp,5);
	$teams[$i]=fgets($fp,$teams_amount[$i]*10+1);	//隊名長度5個中文字
	fclose($fp);
}
?>
</head>
<body>
<form action=deduction.php method=POST>
<table>
 <tr>
  <td>
   隊伍 : 
  </td>
  <td>
	<select name="team_name">
	<?
	 for($j=0;$j<$gamount;$j++)
	 {
	 	echo "<option value=\"\">---".$gname[$j]."---</option>\n";
	    //$teams_name=split (" ",chop($teams[$j]),$teams_amount[$j]);
		$teams_name = explode(" ", rtrim($teams[$j]), $teams_amount[$j]); //PHP 7.0 later
		for($i=0;$i<$teams_amount[$j];$i++)
		{
			echo "<option value=\"$gfile[$j]".$teams_name[$i]."\">".$teams_name[$i]."</option>\n";
		}
	 }
	?>
	</select>
  </td>
 </tr>
  <tr>
  <td>
   扣分 : 
  </td>
  <td>
	<select name="deduction">
	<?
		for($i=1;$i<21;$i++)
			echo "<option value=\"".$i."\">".$i."</option>\n";
	?>
	echo "<option value=0>0</option>\n";
	</select>
	(0:為將扣分歸零,1~20:將原來的扣分再加上所選擇的扣分)
  </td>
 </tr>
</table>
<input type="submit" value=送出>
<input type="reset" value=重新輸入>
</form>
</form>
</head>
<body>
<?


}//else 1
?>	

<?
include 'sign.php';
sign();
?>
</body>
</html>