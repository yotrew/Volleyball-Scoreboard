<?php
include 'function.php';
// 確保 check_login 內部有執行 session_start()，否則這裡要取消註解
// session_start(); 
check_login();

if (!isset($_SESSION['pro']) || $_SESSION['pro'] > 10) {
    echo "你的權限不足!!\n";
    exit;
}

// 取得動作指令
$act = $_POST["act"] ?? ''; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>線上檔案總管</title>
    <style>body, td { font-size: 9pt; }</style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" method="post" enctype="multipart/form-data">
    上傳檔案：
    <input type="file" name="up_file">
    <input type="submit" name="act" value="上傳">
</form>

<?php
if ($act == "上傳") {
    // PHP 7+ 必須透過 $_FILES 取得檔案資
    if (!isset($_FILES['up_file']) || $_FILES['up_file']['error'] == UPLOAD_ERR_NO_FILE) {
        echo "您沒有選擇要上傳的檔案呢！請按「瀏覽」選擇要上傳的檔案！";
    } else {
        $file = $_FILES['up_file'];
        $up_dir = "."; // 建議更改為特定目錄如 "./uploads"
        $dest = $up_dir . "/" . basename($file['name']);

        // 使用 move_uploaded_file 是標準且安全的作法
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            @chmod($dest, 0666);
            echo htmlspecialchars($file['name']) . " 已順利上傳！";
            echo "（檔案大小：" . $file['size'] . " 位元組，檔案類型：" . $file['type'] . " ）";
        } else {
            echo "<font color=\"Red\">上傳失敗！錯誤代碼：" . $file['error'] . "</font>";
        }
    }
}
?>

</body>
</html>