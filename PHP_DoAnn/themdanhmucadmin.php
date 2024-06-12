<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iddanhmuc = $_POST['iddanhmuc'];
    $tendanhmuc = $_POST['tendanhmuc'];

    $sql = "INSERT INTO danhmuc (Iddanhmuc, tendanhmuc) VALUES (:iddanhmuc, :tendanhmuc)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':iddanhmuc', $iddanhmuc);
    $stmt->bindParam(':tendanhmuc', $tendanhmuc);

   
    if ($stmt->execute()) {
        
        header("Location: trangchuadmin.php?status=success");
        exit();
    } else {
     
        $error_message = "Thêm thất bại. Vui lòng thử lại.";
    }
}

$query = '';
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc WHERE tendanhmuc LIKE :query";
    $stmt = $conn->prepare($sql);
    $searchQuery = '%' . $query . '%';
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
} else {
    $sql = "SELECT Iddanhmuc, tendanhmuc FROM danhmuc";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);

$itemsPerPage = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;
$sql .= " LIMIT :itemsPerPage OFFSET :offset";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="vi">
</html>
