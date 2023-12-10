<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/ViewPostController.php');

session_start();

if (isset($_SESSION["user_id"])) {
  $currentUserId = $_SESSION['user_id'];
} else {
  // 로그인 되어 있지 않은 경우 처리
  echo "<script>alert('로그인이 필요합니다.');
  window.location.href = '../login.php';</script>";
  exit; // 작업 중지
}
?>

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

    /* 수정, 삭제 버튼 스타일 */
    .edit-link {
      padding: 5px 10px;
      text-decoration: none;
      background-color: #28a745;
      color: white;
      border-radius: 3px;
      margin-right: 5px;
    }

    /* 삭제 버튼 스타일 */
    .delete-button {
      padding: 5px 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>

<body>
  <div class="postlist-container">
    <h2>게시글 목록</h2>

    <?php foreach ($posts as $post) { ?>
      <div class="post-item">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h3><?php echo $post['post_title']; ?></h3>
          <div>
            <button onclick="editPost(<?php echo $post['user_id']; ?>)" class="edit-link">수정</button>
            <button onclick="openDeleteModal(<?php echo $post['user_id'] ?>)" class="delete-button">삭제</button>
          </div>
        </div>
        <p>User ID: <?php echo $post['user_id']; ?></p>
        <p>Post Content: <?php echo $post['post_content']; ?></p>
        <p>Posted At: <?php echo $post['posted_at']; ?></p>
        <p>Modified At: <?php echo $post['modified_at']; ?></p>
      </div>
    <?php } ?>

    <!-- 삭제 모달 -->
    <div id="deleteModal" class="modal">
      <div class="modal-content">
        <p>게시물을 삭제하시겠습니까?</p>
        <button onclick="deletePost()">삭제</button>
        <button onclick="closeDeleteModal()">취소</button>
      </div>
    </div>

    <!-- 글쓰기 버튼과 로그아웃 버튼 -->
    <div class="post-item">
      <a href="./create_post.php" class="create-post-button">글쓰기</a>
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
      window.location.href = "../controllers/LogoutController.php";
    }

    // 삭제 버튼 누를 시 모달 열기 함수
    function openDeleteModal(postUserId) {
      var currentUserId = <?php echo $currentUserId; ?>;
      if (currentUserId === postUserId) {
        document.getElementById('deleteModal').style.display = 'block';
      } else {
        alert("본인의 게시글만 삭제할 수 있습니다.");
      }
    }

    // 모달 닫기 함수
    function closeDeleteModal() {
      document.getElementById('deleteModal').style.display = 'none';
    }

    // 삭제 함수
    function deletePost() {
      window.location.href = "../controllers/DeletePostController.php";
    }

    //수정 함수
    function editPost(postUserId) {
    var currentUserId = <?php echo $currentUserId; ?>;
    if (currentUserId === postUserId) {
      window.location.href = "./edit_post.php?id=<?php echo $post['user_id']; ?>";
    } else {
      showAlert();
    }
  }

    // 수정 버튼 클릭 시 경고 메시지 표시하는 함수
    function showAlert() {
    alert("본인의 게시글만 수정할 수 있습니다.");
  }

  </script>
</body>

</html>