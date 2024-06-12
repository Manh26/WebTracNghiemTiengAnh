<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query('SET NAMES utf8');
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $stmt = $conn->prepare("SELECT UserID, Password, Role FROM login WHERE UserName = :username AND Password = :passwordd");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':passwordd', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $userid = $row['UserID'];
        $hashed_password = $row['Password']; 
        $role = $row['Role'];

        
        $_SESSION['UserID'] = $userid;
        $_SESSION['UserName'] = $username;
        $_SESSION['Role'] = $role;

        if ($role == 1) {
            header("Location:trangchu.php"); 
        } else if ($role == 0) {
            header("Location: trangchuadmin.php");
            echo "Role không hợp lệ.";
            exit();
        }
        exit();
      
    } else {
        echo "Không tìm thấy người dùng với tên đăng nhập này.";
        header("Location: dangnhap.html");
        exit();
    }
}
?>
