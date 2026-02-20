<?
// 1. 啟動 Session
session_start();

// 2. 清除所有已登記的 Session 變數
session_unset();
// 3. 銷毀現有的 Session連線紀錄
session_destroy();

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登出系統</title>
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
<script language="JavaScript">
window.parent.frames.left.location="javascript:location.reload()";
</script>
已登出!!!<br>
<form name="form1" id="form1" method="post" action="login.php">
<p align="center">帳號：
<input name="user" type="text" id="user" />
</p>
<p align="center">密碼：
<input name="password" type="password" id="password" />
</p>
<p align="center">
<input type="submit" name="Submit" value="登 入" />
</p>
</form>
<?
include 'sign.php';
sign();
?>
</body>
</html>
