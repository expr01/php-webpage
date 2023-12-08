<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Post List</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .postlist-container {
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      width: 70%;
      max-width: 800px;
      margin: auto;
    }

    .postlist-container h2 {
      margin-bottom: 20px;
    }

    .post-item {
      border-bottom: 1px solid #ccc;
      padding: 15px 0;
      text-align: left;
      margin-bottom: 10px;
    }

    .post-item:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .create-post-button {
      display: inline-block;
      padding: 10px 20px;
      text-decoration: none;
      color: #fff;
      background-color: #007bff;
      border-radius: 5px;
    }

    .create-post-button:hover {
      background-color: #0056b3;
    }

    /* 모달 스타일 */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: white;
      margin: 25% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 400px;
      border-radius: 5px;
      text-align: center;
    }

    .modal-content p {
      margin-bottom: 20px;
    }

    .modal-content button {
      padding: 10px 20px;
      margin-right: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .modal-content button:nth-child(1) {
      background-color: #007bff;
      color: white;
    }

    .modal-content button:nth-child(1):hover {
      background-color: #0056b3;
    }

    .modal-content button:nth-child(2) {
      background-color: #f4f4f4;
      color: #333;
    }

    .modal-content button:nth-child(2):hover {
      background-color: #ddd;
    }

    /* 로그아웃 버튼 */

    .logout-button {
      display: inline-block;
      padding: 10px 20px;
      text-decoration: none;
      color: #fff;
      background-color: #dc3545;
      border-radius: 5px;
      outline: none;
      /* 외곽선 제거 */
    }

    .logout-button:hover {
      background-color: #bd2130;
    }
  </style>
</head>

<body>
  <div class="postlist-container">
    <h2>게시글 목록</h2>
    <?php
    // ViewPostController.php 에서 데이터를 받아서 사용
    ?>

    <!-- 글쓰기 버튼 추가 -->
    <div class="post-item">
      <!-- create_post.php로 수정 -->
      <a href="./create_post.php" class="create-post-button">글쓰기</a>
      <!-- 로그아웃 버튼 추가 -->
      <button onclick="openModal()" class="logout-button">로그아웃</button>
    </div>

  </div>

  <!-- 로그아웃 모달 -->
  <div id="logoutModal" class="modal">
    <div class="modal-content">
      <p>로그아웃을 하시겠습니까?</p>
      <button onclick="logout()">예</button>
      <button onclick="closeModal()">취소</button>
    </div>
  </div>

  <script>
    // 모달 열기 함수
    function openModal() {
      document.getElementById('logoutModal').style.display = 'block';
    }

    // 모달 닫기 함수
    function closeModal() {
      document.getElementById('logoutModal').style.display = 'none';
    }

    // 로그아웃 함수
    function logout() {
      window.location.href = "../controllers/LogoutContoller.php";
    }
  </script>
</body>

</html>