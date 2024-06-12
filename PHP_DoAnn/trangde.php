<?php 
include 'connect.php';

$iddanhmuc = isset($_GET['id']) ? $_GET['id'] : null;

if ($iddanhmuc !== null) {
    
    $sql = "SELECT IdExam, ExamName, TotalQuestions, TestTime, StartTime, Status 
            FROM exam 
            WHERE Iddanhmuc = :Iddanhmuc";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':Iddanhmuc', $iddanhmuc, PDO::PARAM_INT);
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
} else {
    
    $sql = "SELECT IdExam, ExamName, TotalQuestions, TestTime, StartTime, Status FROM exam";
    $stm = $conn->prepare($sql);
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
    
    if (count($data) === 0) {
        echo "Không có đề nào";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đề</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>
<body>
    <h2 style="text-align: center; margin-top: 30px;margin-bottom: 30px;">DANH MỤC ĐỀ</h2>

    <?php if (count($data) > 0): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tên Đề</th>
                <th>Tổng số câu hỏi</th>
                <th>Thời gian</th>
                <th>Thời gian truy cập</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $item): ?>
            <tr>
                <td><?php echo $item->IdExam ?></td>
                <td><?php echo $item->ExamName ?></td>
                <td><?php echo $item->TotalQuestions ?></td>
                <td><?php echo $item->TestTime ?></td>
                <td><?php echo $item->StartTime ?></td>
                <td><?php echo $item->Status ?></td>
                
                <td>
   
    <a href="loadquestion.php?IdExam=<?php echo $item->IdExam; ?>" class="btn btn-secondary">Làm bài</a>
</td>

                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p style="text-align: center; margin-top: 30px;">Không có đề nào</p>
    <?php endif; ?>



</body>
</html>
