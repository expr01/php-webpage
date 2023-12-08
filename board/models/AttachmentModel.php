<?php

class AttachmentModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveToDatabase($fileName, $fileType, $fileSize, $fileUrl) {
        $sql = "INSERT INTO files (file_name, file_type, file_size, file_url) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        // 바인딩하여 쿼리 실행
        $stmt->bind_param("ssis", $fileName, $fileType, $fileSize, $fileUrl);

        if ($stmt->execute()) {
            return true; // 파일 정보가 성공적으로 저장됨
        } else {
            return false; // 파일 정보 저장 실패
        }
    }
}