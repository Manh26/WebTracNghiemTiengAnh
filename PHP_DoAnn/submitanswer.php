<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$idexam = isset($_GET['IdExam']) ? $_GET['IdExam'] : null;

if ($idexam !== null) {
    if (!isset($_SESSION['startTime'])) {
        $_SESSION['startTime'] = date("Y-m-d H:i:s"); 
    }

    $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD, CorrectAnswer FROM questions WHERE IdExam = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idexam);
    $stm->execute();
    $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
}

$questionShow = array();
$countCorrect = 0;
$totalQuestions = count($data); 
$point = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['id'] as $question_id) {
        if (isset($_POST['answer' . $question_id])) {
            $selected_answer = $_POST['answer' . $question_id];
            $questionShow[$question_id] = $selected_answer;
        } else {
            echo "Không có câu trả lời cho câu hỏi có ID: $question_id";
            header('Location: trangchu.php');
            exit();
        }
    }

    $ResultShow = array();
    foreach ($questionShow as $question_id => $selected_answer) {
        foreach ($data as $item) {
            if ($item['IdQuestion'] == $question_id) {
                if ($item['CorrectAnswer'] === $selected_answer) {
                    $ResultShow[$question_id] = $selected_answer;
                    $countCorrect++;
                } else {
                    $ResultShow[$question_id] = "error";
                }
                break;
            }
        }
    }

    $point = number_format(($countCorrect / $totalQuestions) * 10, 1);

    $Testdate = date("Y-m-d");

    $userid = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : null;
    $Testdate = date("Y-m-d ");
    $startTime = $_SESSION['session'];
    $endTime = date("Y-m-d H:i:s");

    $sqlInsert = "INSERT INTO UserExamHistory (UserID, IdExam, TestDate, StartTime, EndTime, Point, CorrectAnswers)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("iissssi", $userid, $idexam, $Testdate, $startTime, $endTime, $point, $countCorrect);

    if ($stmtInsert->execute()) {
        echo "Thao tác thành công!";
        unset($_SESSION['session']);
    } else {
        echo "Thao tác thất bại. Vui lòng thử lại.";
    }
    $stmtInsert->close();
}

$conn->close();
?>
```


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
        .timer {
            font-size: 2em;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .result {
            font-size: 1.2em;
            text-align: center;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đề Trắc Nghiệm</h2>
        <form action="#" method="post">
            <?php
            $question_number = 1;
            foreach ($data as $item) {
                $question_id = $item['IdQuestion'];
            ?>
                <div class="question">
                    <?php
                    $answer_A = "";
                    $answer_B = "";
                    $answer_C = "";
                    $answer_D = "";
                    $selected_answer = isset($questionShow[$question_id]) ? $questionShow[$question_id] : null;
                    if (isset($ResultShow[$question_id]) && $ResultShow[$question_id] === "error") {
                        if ($item['AnswerA'] === $questionShow[$question_id]) $answer_A = "red";
                        if ($item['AnswerB'] === $questionShow[$question_id]) $answer_B = "red";
                        if ($item['AnswerC'] === $questionShow[$question_id]) $answer_C = "red";
                        if ($item['AnswerD'] === $questionShow[$question_id]) $answer_D = "red";
                    } else {
                        if ($item['AnswerA'] === $questionShow[$question_id]) $answer_A = "green";
                        if ($item['AnswerB'] === $questionShow[$question_id]) $answer_B = "green";
                        if ($item['AnswerC'] === $questionShow[$question_id]) $answer_C = "green";
                        if ($item['AnswerD'] === $questionShow[$question_id]) $answer_D = "green";
                    }
                    ?>
                    <p><?php echo 'Câu ' . $question_number . ': ' . $item['Question']; ?></p>
                    <label style="color: <?php echo $answer_A; ?>"><input type="radio" name="answer<?php echo $question_id; ?>" value="<?php echo $item['AnswerA']; ?>" <?php echo ($selected_answer === $item['AnswerA']) ? 'checked' : ''; ?>> <?php echo $item['AnswerA']; ?></label>
                    <label style="color: <?php echo $answer_B; ?>"><input type="radio" name="answer<?php echo $question_id; ?>" value="<?php echo $item['AnswerB']; ?>" <?php echo ($selected_answer === $item['AnswerB']) ? 'checked' : ''; ?>> <?php echo $item['AnswerB']; ?></label>
                    <label style="color: <?php echo $answer_C; ?>"><input type="radio" name="answer<?php echo $question_id; ?>" value="<?php echo $item['AnswerC']; ?>" <?php echo ($selected_answer === $item['AnswerC']) ? 'checked' : ''; ?>> <?php echo $item['AnswerC']; ?></label>
                    <label style="color: <?php echo $answer_D; ?>"><input type="radio" name="answer<?php echo $question_id; ?>" value="<?php echo $item['AnswerD']; ?>" <?php echo ($selected_answer === $item['AnswerD']) ? 'checked' : ''; ?>> <?php echo $item['AnswerD']; ?></label>
                </div>
                <input type="hidden" name="id[]" value="<?php echo $question_id; ?>">
            <?php
                $question_number++;
            }
            ?>
            <div class="btn-container">
                <a href="loadanswer.php?IdExam=<?php echo $idexam; ?>" class="btn">Xem Đáp Án</a>
                <a href="trangchu.php" class="btn btn-back">Quay lại trang chủ</a>
            </div>
        </form>
        <div class="result">
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo 'Tổng số câu đúng: ' . $countCorrect . '<br>Điểm: ' . $point . '/10';
            } ?>
        </div>
    </div>
</body>

</html>

