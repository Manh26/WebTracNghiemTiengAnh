<?php 
include 'connect.php';

$query = '';
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    // Sử dụng truy vấn có tìm kiếm
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc WHERE tendanhmuc LIKE :query";
    $stm = $conn->prepare($sql);
    $searchQuery = '%' . $query . '%';
    $stm->bindParam(':query', $searchQuery, PDO::PARAM_STR);
} else {
    // Truy vấn mặc định
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc";
    $stm = $conn->prepare($sql);
}

$stm->execute();
$data = $stm->fetchAll(PDO::FETCH_OBJ);
?>
