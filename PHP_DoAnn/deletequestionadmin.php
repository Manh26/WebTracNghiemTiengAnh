<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM questions WHERE IdQuestion = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: themquestionadmin.php?status=success");
    } else {
        header("Location: themquestionadmin.php?status=fail");
    }

    $stmt->close();
} else {
    header("Location: themquestionadmin.php?status=fail");
}

$conn->close();
?>
