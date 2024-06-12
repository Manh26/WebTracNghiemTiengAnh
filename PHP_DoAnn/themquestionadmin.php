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

// Handle form submission to add new question
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['nameQuestion'];
    $answerA = $_POST['answerA'];
    $answerB = $_POST['answerB'];
    $answerC = $_POST['answerC'];
    $answerD = $_POST['answerD'];
    $correctAnswer = $_POST['CorrectAnswer'];
    $idExam = $_POST['idExam'];

    $sql = "INSERT INTO questions (Question, AnswerA, AnswerB, AnswerC, AnswerD, CorrectAnswer, IdExam)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $question, $answerA, $answerB, $answerC, $answerD, $correctAnswer, $idExam);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=success");
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?status=fail");
    }
    exit;
}

$sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD, IdExam FROM questions";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đề Trắc Nghiệm</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .question {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .question p {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }
        .question label {
            display: block;
            margin-bottom: 8px;
            font-size: 1em;
            cursor: pointer;
        }
        .question input[type="radio"] {
            margin-right: 10px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-right: 10px;
            text-decoration: none;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-back {
            background: #6c757d;
        }
        .btn-back:hover {
            background: #5a6268;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-left: 10px;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
    </style>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            if (status === 'success') {
                alert('Thao tác thành công!');
            } else if (status === 'fail') {
                alert('Thao tác thất bại. Vui lòng thử lại.');
            }
        }

        function deleteQuestion(id) {
            if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này không?')) {
                window.location.href = 'deletequestionadmin.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Đề Trắc Nghiệm</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="idExam" class="form-label">ID Đề</label>
                <input type="number" class="form-control" id="idExam" name="idExam" required>
            </div>
            <div class="mb-3">
                <label for="nameQuestion" class="form-label">Tên Câu Hỏi</label>
                <input type="text" class="form-control" id="nameQuestion" name="nameQuestion" required>
            </div>
            <div class="mb-3">
                <label for="answerA" class="form-label">Câu A</label>
                <input type="text" class="form-control" id="answerA" name="answerA" required>
            </div>
            <div class="mb-3">
                <label for="answerB" class="form-label">Câu B</label>
                <input type="text" class="form-control" id="answerB" name="answerB" required>
            </div>
            <div class="mb-3">
                <label for="answerC" class="form-label">Câu C</label>
                <input type="text" class="form-control" id="answerC" name="answerC" required>
            </div>
            <div class="mb-3">
                <label for="answerD" class="form-label">Câu D</label>
                <input type="text" class="form-control" id="answerD" name="answerD" required>
            </div>
            <div class="mb-3">
                <label for="CorrectAnswer" class="form-label">Đáp Án Đúng</label>
                <input type="text" class="form-control" id="CorrectAnswer" name="CorrectAnswer" required>
            </div>
            <button type="submit" class="btn">Thêm</button>
        </form>
        <?php
        if ($result->num_rows > 0) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo '<form action="submitanswer.php" method="post">';
            $question_number = 1;
            foreach ($data as $item) {
                ?>
                <input type="hidden" name="id[]" value="<?php echo $item['IdQuestion']; ?>">
                <div class="question">
                    <p><?php echo 'Câu ' . $question_number . ': ' . $item['Question']; ?></p>
                    <p class="question-id"><?php echo 'ID Đề: ' . $item['IdExam']; ?></p>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerA']; ?>"> <?php echo $item['AnswerA']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerB']; ?>"> <?php echo $item['AnswerB']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerC']; ?>"> <?php echo $item['AnswerC']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerD']; ?>"> <?php echo $item['AnswerD']; ?></label>
        
                    <button type="button" class="btn-delete" onclick="deleteQuestion(<?php echo $item['IdQuestion']; ?>)">Xóa</button>
                </div>
                <?php
                $question_number++;
            }
            echo '<div class="btn-container">';
            echo '<input type="submit" class="btn" value="Nộp Bài">';
            echo '<a href="index.php" class="btn btn-back">Quay lại</a>';
            echo '</div>';
            echo '</form>';
        } else {
            echo "<p>Không có kết quả nào</p>";
        }
        ?>
    </div>
</body>
</html>
