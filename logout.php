<?php
// 啟動 session
session_start();

// 清除所有 session 資料
$_SESSION = array();

// 如果要清除 session cookie，也就是客戶端的 session id
// 注意：這會刪除 session，使得 session cookie 失效，但是不會銷毀 session 資料
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 86400, '/');
}

// 最後銷毀 session
session_destroy();

// 導向回登入頁面或其他指定頁面
header("Location: index.php"); // 登入頁面的路徑
exit();
?>
