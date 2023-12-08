<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/models/AttachmentModel.php');

// 데이터베이스 연결 정보
$servername = "localhost";
$username = "jh";
$password = "1234";
$dbname = "forum";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 파일 업로드 디렉토리 경로 설정
$target_dir = __DIR__ . "uploads/"; // 파일이 저장될 디렉토리

// AttachmentModel 인스턴스 생성
$attachmentModel = new AttachmentModel($conn);

// 파일을 서버로 옮김
$target_file = $target_dir . basename($_FILES["file"]["name"]);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "파일 " . basename($_FILES["file"]["name"]) . "이 업로드되었습니다.";

    // 파일 정보를 데이터베이스에 저장하기 위해 모델 호출
    $fileName = basename($_FILES["file"]["name"]);
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $fileUrl = $target_file; // 저장된 파일 경로

    // AttachmentModel을 사용하여 파일 정보 저장
    $result = $attachmentModel->saveToDatabase($fileName, $fileType, $fileSize, $fileUrl);

    // 실제 데이터베이스 쿼리 실행
    if ($conn->query($result) === TRUE) {
        echo "파일 정보가 성공적으로 저장되었습니다.";
    } else {
        echo "파일 정보를 저장하는 데 실패했습니다: " . $conn->error;
    }
} else {
    echo "파일 업로드에 실패했습니다.";
}

// 데이터베이스 연결 종료
$conn->close();
?>
