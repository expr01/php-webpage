<?php
class UserModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function getUserByEmail($email)
  {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return null;
    }
  }

  public function createUser($userName, $userPassword, $email)
  {
    // 패스워드 해싱
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // 사용자 데이터를 삽입하는 쿼리 작성
    $query = "INSERT INTO users (user_name, password, email) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("sss", $userName, $hashedPassword, $email);

    // 쿼리 실행
    if ($stmt->execute()) {
      return true; // 사용자가 성공적으로 생성됨
    } else {
      return false; // 사용자 생성 실패
    }
  }

  public function checkDuplicateEmail($email)
  {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0; // 중복된 이메일이 존재하면 true 반환
  }

  public function checkDuplicateUsername($username)
  {
    $query = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0; // 중복된 유저네임이 존재하면 true 반환
  }
}
