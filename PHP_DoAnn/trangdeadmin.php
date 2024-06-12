<?php 
include 'connect.php';

$iddanhmuc = isset($_GET['id']) ? $_GET['id'] : null;
$success = false;

// Handle deletion of an exam
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteId'])) {
    $deleteId = $_POST['deleteId'];
    $sql = "DELETE FROM exam WHERE IdExam = :IdExam";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':IdExam', $deleteId, PDO::PARAM_INT);
    $stm->execute();
}

// Handle form submission to add new exam
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['deleteId'])) {
    $examName = $_POST['ExamName'];
    $testTime = $_POST['TestTime'];
    $totalQuestions = $_POST['TotalQuestions'];
    $idDanhmuc = $_POST['Iddanhmuc'];

    $sql = "INSERT INTO exam (Iddanhmuc, ExamName, TotalQuestions, TestTime)
            VALUES (:Iddanhmuc, :ExamName, :TotalQuestions, :TestTime)";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':Iddanhmuc', $idDanhmuc);
    $stm->bindParam(':ExamName', $examName);
    $stm->bindParam(':TotalQuestions', $totalQuestions);
    $stm->bindParam(':TestTime', $testTime);
    
    if ($stm->execute()) {
        $success = true;
    }
}

if ($iddanhmuc !== null) {
    $sql = "SELECT IdExam, ExamName, TotalQuestions, TestTime FROM exam WHERE Iddanhmuc = :Iddanhmuc";
    $stm = $conn->prepare($sql);
    $stm->bindParam(':Iddanhmuc', $iddanhmuc, PDO::PARAM_INT);
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_OBJ);
} else {
    $sql = "SELECT IdExam, ExamName, TotalQuestions, TestTime FROM exam";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($success): ?>
                alert('Thêm đề thành công!');
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center; margin-top: 30px; margin-bottom: 30px;">DANH MỤC ĐỀ</h2>

        <?php if (count($data) > 0): ?>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên Đề</th>
                    <th>Tổng số câu hỏi</th>
                    <th>Thời gian</th>
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
                    <td>
                    <a href="loadquestion.php?IdExam=<?php echo $item->IdExam; ?>" class="btn btn-primary">Làm bài</a>
                        <a href="themquestionadmin.php?IdExam=<?php echo $item->IdExam; ?>" class="btn btn-primary">Thêm Câu Hỏi</a>
                        <form method="post" action="" style="display:inline-block;">
                            <input type="hidden" name="deleteId" value="<?php echo $item->IdExam; ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đề này không?');">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p style="text-align: center; margin-top: 30px;">Không có đề nào</p>
        <?php endif; ?>

        <h2 style="text-align: center; margin-top: 30px; margin-bottom: 30px;">Thêm Đề Mới</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="Iddanhmuc" class="form-label">ID Danh Mục</label>
                <input type="number" class="form-control" id="Iddanhmuc" name="Iddanhmuc" required>
            </div>
            <div class="mb-3">
                <label for="ExamName" class="form-label">Tên Đề</label>
                <input type="text" class="form-control" id="ExamName" name="ExamName" required>
            </div>
            <div class="mb-3">
                <label for="TotalQuestions" class="form-label">Tổng Số Câu Hỏi</label>
                <input type="number" class="form-control" id="TotalQuestions" name="TotalQuestions" required>
            </div>
            <div class="mb-3">
                <label for="TestTime" class="form-label">Thời Gian Thi (phút)</label>
                <input type="number" class="form-control" id="TestTime" name="TestTime" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Đề</button>
        </form>
    </div>
</body>
</html>
