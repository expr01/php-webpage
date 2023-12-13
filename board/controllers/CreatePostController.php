<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/PostModel.php');

//DB 연결부
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//세션 변수
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // CreatePostController.php에서 $user_id를 PostModel로 전달하여 게시물을 작성할 때 사용
} else {
    // 로그인 되어 있지 않은 경우 처리
    echo "<script>alert('로그인이 필요합니다.');
    window.location.href = '../login.php';</script>";
    exit; // 작업 중지
}

// POST로 받은 데이터 가져오기
$post_title = $_POST['post_title'];
$post_content = $_POST['post_content'];
$is_attached = !empty($_FILES['file']['name']) ? 1 : 0;

// PostModel 인스턴스 생성
$postModel = new PostModel($conn);

// 데이터베이스에 글 작성
if ($postModel->insertPostWithUserID($user_id, $post_title, $post_content, $is_attached)) {
    // 글 작성 성공
    // 여기에 추가적인 처리를 할 수 있음
    echo "<script>alert('글이 성공적으로 작성되었습니다.');
    window.location.href = '../views/post_list.php';</script>";
} else {
    // 글 작성 실패
    echo "<script>alert('글이 성공적으로 작성되었습니다.');
    window.location.href = '../views/create_post.php';</script>";
}
?>