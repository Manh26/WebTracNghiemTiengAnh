<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $iddanhmuc = $_GET['id'];

 
    $sql = "DELETE FROM danhmuc WHERE Iddanhmuc = :iddanhmuc";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':iddanhmuc', $iddanhmuc, PDO::PARAM_INT);

    if ($stm->execute()) {
        header("Location: trangchuadmin.php?status=success");
    } else {
        header("Location: trangchuadmin.php?status=fail");
    }
}
?>
