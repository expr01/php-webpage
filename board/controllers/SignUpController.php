<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/UserModel.php');

//DB 연결부
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// POST된 이메일과 패스워드
$usernameToCheck = $_POST['username'];
$passwordToCheck = $_POST['password'];
$emailToCheck = $_POST['email'];

$userModel = new UserModel($conn);
//유저 이메일 중복 확인
if ($userModel->checkDuplicateEmail($emailToCheck)) {
  echo "<script>alert('해당 이메일은 이미 사용 중입니다.');
      window.location.href = '../login.php';</script>";
} else {
  // 유저네임 중복 확인
  if ($userModel->checkDuplicateUsername($usernameToCheck)) {
    echo "<script>alert('해당 사용자명은 이미 사용 중입니다.');
      window.location.href = '../login.php';</script>";
  } else {
    // 중복되지 않는 경우 사용자 추가
    // $added에는 true, false 반환
    $added = $userModel->createUser($usernameToCheck, $passwordToCheck, $emailToCheck);
    if ($added) {
      echo "<script>alert('회원가입 성공!');
      window.location.href = '../login.php';</script>";
    } else {
      echo "<script>alert('회원가입 실패!');
      window.location.href = '../views/sign_up.php';</script>";
    }
  }
}
