<html>
<head>
<title>自動排賽程程式</title>
</head>
<body>
<?
$week=6; //週數
$time=4;	//時段
$place=3; //場地數
$group=2;	//分組數
$p=0.8;
$games=($time*$place)*$p; //真正使用場數
$tmp=$games%$group; //
$games=intval($games)+$tmp;	//真正使用場數,並可讓兩組可以有相同比賽場數


?>
</body>
</html>

<?
/*
  1 2
1 X 1
2 X X 

  1 2 3
1 X 1 2
2 X X 3
3 X X X

  1 2 3 4
1 X 1 2 3
2 X 4 5 6
3 X X X 7
4 X X X X

  1  2  3  4  5
1 X  1  2  3  4
2 X  X  5  6  7
3 X  X  X  8  9
4 X  X  X  X 10
5 X  X  X  X X
*/
?>