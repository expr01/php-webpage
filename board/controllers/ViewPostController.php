<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');

// DB 연결부
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// PostModel 인스턴스 생성
$postModel = new PostModel($conn);

// 모든 글 가져오기
$posts = $postModel->getAllPosts();

// 데이터베이스 연결 종료
$conn->close();

?>
