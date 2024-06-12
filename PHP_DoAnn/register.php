<?php

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "web1_mysql";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query('SET NAMES utf8');
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    exit();
}

// Kiểm tra phương thức yêu cầu là POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $email = $_POST['Email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email không hợp lệ. Vui lòng thử lại.";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
   
        $error_message = "Mật khẩu phải chứa cả số và chữ cái. Vui lòng thử lại.";
    }
   

  
    $stmt = $conn->prepare("INSERT INTO login (UserName, Password, Email, Role) VALUES (:username, :password, :email, '1')");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);

    if ($stmt->execute()) {
        // Đăng ký thành công
        header("Location: dangnhap.html?status=success");
        exit();
    } else {
        // Đăng ký thất bại
        $error_message = "Đăng ký thất bại. Vui lòng thử lại.";
    }
}
?>
