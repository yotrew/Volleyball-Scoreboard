<?
include 'function.php';
check_login();
if($_SESSION['pro']>5)
{
        echo "你的權限不足!!\n";
        exit;
}
?>
<html>
<head>
<title>戰績表新增</title>
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
<?
//---global 
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
$amount="";
$teams="";
$group="";
if(isset($_POST["amount"]))
	$amount=$_POST["amount"];
if(isset($_POST["teams"]))
	$teams=$_POST["teams"];
if(isset($_POST["group"]))
	$group=$_POST["group"];
//---
if( $amount!="")
	if($teams!="")
		if( $group!="")
		{
			for($i=0;$i<$gamount;$i++)
			{
				if(!strcmp($group,$gname[$i]))
				{
					$fp=fopen($gfile[$i].".txt","w");
					break;
				}
			}
			fputs($fp,$amount."\n".$teams."\n");
			
			//初始扣分
			for($i=0;$i<($amount);$i++)
				fputs($fp,"0 ");
			fputs($fp,"\n");
			
			//for loop初使化分數--只記錄對角線以上的分數
			for($i=0;$i<($amount*$amount-$amount)/2;$i++)
			{
				for($j=0;$j<4;$j++)
					fputs($fp,"0 0 ");	//三局比數+對戰輸贏局數(x:x)
				fputs($fp,"\n");
			}
			fclose($fp);
			echo $group."戰績表新增完成";
		}
?>
<?
?>
<form action=addgroup.php method=POST>
<table>
 <tr>
  <td>
   組別 : 
  </td>
  <td>
	<select name="group">
	<?
		for($i=0;$i<$gamount;$i++)
		{
			echo "<option value=\"".$gname[$i]."\">".$gname[$i]."</option>\n";
		}
	?>
	</select>
  </td>
 </tr>
 <tr>
  <td>
   總隊數 : 
  </td>
  <td>
   <input type="text" maxlength=2 length=40 name=amount></input><br>
  </td>
  <td>
   ex. 7
  </td>
 </tr>
 <tr>
  <td>
   隊伍 : 
  </td>
  <td>
   <input type="text" length=40 name=teams></input><br>
  </td>
  <td>
	ex. 企管酷 歷史 政治 經濟A 機械菜頭 法律 資工
  </td>
 </tr>
 <tr>
 <td>
   <input type="submit" value="新增">
 </td>
 <td>
   <input type="reset" value="重新填寫">
 </td>
 </tr>
</table>
</form>
<?
include 'sign.php';
sign();
?>
</body>
</html>
