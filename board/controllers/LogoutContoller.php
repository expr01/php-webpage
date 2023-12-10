<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// 세션을 종료하고 로그인 페이지로 이동.
session_start();
session_unset();
session_destroy();

echo "<script>alert('로그아웃 하셨습니다.');
      window.location.href = '../login.php';</script>";
exit();
?>