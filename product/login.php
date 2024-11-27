<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Form Đăng Nhập</title>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form action="login.php" method="POST">
        <label>Tên Đăng Nhập:</label><br>
        <input type="text" name="username"><br>
        <label>Mật Khẩu:</label><br>
        <input type="password" name="password"><br>
        <button type="submit">Đăng Nhập</button>
    </form>

        
<?php
session_start();
include('connect.php');
include('validation.php');

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (check_format($username) === true && detectSQLi($username) !== false && detectXSS($username) !== false) {
    
      // Ngăn chặn SQL injection bằng prepared statement và bind_param
      $stmt = $conn->prepare('SELECT * FROM USERS WHERE USERNAME = ? AND PASSWORD_HASH = ?');
      $stmt->bind_param('ss', $username, $password);
      $stmt->execute();
      $result = $stmt->get_result();

      // check for existing username and password
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $_SESSION['USERNAME'] = $row['USERNAME'];
          $_SESSION['role'] = $row['role'];
          $_SESSION['userid'] = $row['userid'];
          $_SESSION['status'] = 'login';
          header("Location: search.html");
          
         
      }else {
          die('lỗi người dùng và mật khẩu');
      }
  }
        
}
?>

</body>
</html>
