<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>
<?php 
//echo iconv("BIG5","UTF-8",$tname); 
echo $tname;
?>
</title>
</head>
<body>
	<br><br><br>
	<table border="0" align="center" cellpadding="3" cellspacing="3" >
<?
$group=$_GET["group"];
$tname=$_GET["tname"];
$fp=fopen("teams_".$group.".txt","r");
if(!$fp)
        echo "<br><br><center><font size=+2 color=#EE1111>".$tname."</font></center>";
else
{ 
    while(1)
	{
		$tmp=fgets($fp,20);
		if(!strcmp(trim($tmp),trim($tname)) )
		   break;
	}

		echo "<tr>\n";
		//echo "<td colspan=\"7\">".iconv("BIG5","UTF-8",$tname)."</td>\n";
		echo "<td colspan=\"7\">".$tname."</td>\n";
		echo "<td></td><td></td><td></td>\n";
		echo "</tr>\n";
		$data=fscanf($fp,"%s %s %s %s\n");
		for($i=0;$i<3;$i++)
		{
			$data=fscanf($fp,"%s %s %s %s\n");
			list($name,$msn,$tel,$id)=$data;
			echo "<tr>\n";
			echo "<td>第".($i+1)."聯絡人</td>\n";
			//echo "<td>".iconv("BIG5","UTF-8",$name)."</td>\n";
			echo "<td>".$name."</td>\n";
			echo "<td colspan=\"2\"><a href=".$msn.">".$msn."</a></td>\n";
			echo "<td colspan=\"2\">".$tel."</td>\n";
			echo "<td>".$id."</td>";
			echo "<tr>\n";
		}
		
			$data=fscanf($fp,"%s %s %s %s\n");
			list($name,$msn,$tel,$id)=$data;
			//echo($name."-".$msn."-".$tel);
			echo "<tr>\n";
			echo "<td><font size=+1 color=#EEAA11><B>隊長</td>\n";
			//echo "<td>".iconv("BIG5","UTF-8",$name)."</td>";
			echo "<td>".$name."</td>";
			echo "<td colspan=\"2\"><a href=".$msn.">".$msn."</a></td>\n";
			echo "<td colspan=\"2\">".$tel."</td>\n";
			echo "<td>".$id."</td>\n";
			echo "</tr>\n";
			
			while(1)
			{
				$data=fscanf($fp,"%s %s %s %s %s\n");
				list($n1,$n2,$n3,$n4,$n5)=$data;
				if(!strcmp(trim($n1),trim("[end]") ))
					break;
				echo "<tr>\n";
				echo "<td>隊員</td>\n";
				/*echo "<td>".iconv("BIG5","UTF-8",$n1)."</td>\n";
				echo "<td>".iconv("BIG5","UTF-8",$n2)."</td>\n";
				echo "<td>".iconv("BIG5","UTF-8",$n3)."</td>\n";
				echo "<td>".iconv("BIG5","UTF-8",$n4)."</td>\n";
				echo "<td>".iconv("BIG5","UTF-8",$n5)."</td>\n";*/
				echo "<td>".$n1."</td>\n";
				echo "<td>".$n2."</td>\n";
				echo "<td>".$n3."</td>\n";
				echo "<td>".$n4."</td>\n";
				echo "<td>".$n5."</td>\n";
				echo "<td> </td>\n";
				echo "</tr>\n";

			}
			

}
?>

	</table>
</body>
</html>
<?
fclose($fp)
?>