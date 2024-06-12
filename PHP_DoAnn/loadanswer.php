<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$idexam = isset($_GET['IdExam']) ? $_GET['IdExam'] : null;

if ($idexam !== null) {
  
    $sql = "SELECT Question, AnswerA, AnswerB, AnswerC, AnswerD, CorrectAnswer
            FROM questions
            WHERE IdExam = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idexam);
    $stm->execute();
    $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đáp Án Đúng và Câu Hỏi</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Đáp Án Đúng và Câu Hỏi</h2>
    <table>
        <thead>
            <tr>
                <th>Câu Hỏi</th>
                <th>Đáp Án A</th>
                <th>Đáp Án B</th>
                <th>Đáp Án C</th>
                <th>Đáp Án D</th>
                <th>Đáp Án Đúng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?php echo $row['Question']; ?></td>
                    <td><?php echo $row['AnswerA']; ?></td>
                    <td><?php echo $row['AnswerB']; ?></td>
                    <td><?php echo $row['AnswerC']; ?></td>
                    <td><?php echo $row['AnswerD']; ?></td>
                    <td><?php echo $row['CorrectAnswer']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="btn-container">
    
        <a href="trangchu.php" class="btn btn-back">Quay lại trang chủ</a>
    </div>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>
