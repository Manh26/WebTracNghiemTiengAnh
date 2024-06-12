<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "web1_mysql";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Kết nối thất bại: " . $conn->connect_error);
// }

// $idexam = isset($_GET['IdExam']) ? $_GET['IdExam'] : null;
// $userId = 1;

// if ($idexam !== null) {
//     $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD
//             FROM questions
//             WHERE IdExam = ?";
//     $stm = $conn->prepare($sql);
//     $stm->bind_param('i', $idexam);
//     $stm->execute();
//     $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$idexam = isset($_GET['IdExam']) ? $_GET['IdExam'] : null;
$userId = 1;

if ($idexam !== null) {
    $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD
            FROM questions
            WHERE IdExam = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idexam);
    $stm->execute();
    $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
}

$startTime = isset($_POST['startTime']) ? $_POST['startTime'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTime = date("Y-m-d H:i:s");
    $point = number_format(($countCorrect / $totalQuestions) * 10, 1);

    $sqlInsert = "INSERT INTO UserExamHistory (UserID, IdExam, TestDate, StartTime, EndTime, Point, CorrectAnswers) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("iissssi", $userId, $idexam, $Testdate, $startTime, $endTime, $point, $countCorrect);
    $stmtInsert->execute();
}

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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
            display: flex; /* Hiển thị phần form và bảng đáp án cùng một cấp độ */
        }

        .quiz-container {
            flex: 70%; /* Chiếm 70% chiều rộng */
            padding-right: 20px; /* Khoảng cách giữa form và bảng đáp án */
        }

        .answer-container {
            flex: 30%; /* Chiếm 30% chiều rộng */
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
            transition: box-shadow 0.3s;
        }

        .question:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            transition: color 0.3s;
        }

        .question label:hover {
            color: #007bff;
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
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #6c757d;
        }

        .btn-back:hover {
            background: #5a6268;
        }

        .timer-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .timer {
            font-size: 2em;
            color: #333;
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #007bff;
            border-radius: 5px;
            transition: color 0.3s, border-color 0.3s;
        }

        .timer:hover {
            color: #0056b3;
            border-color: #0056b3;
        }

        .total-questions {
            width: auto;
            padding: 10px 20px;
            margin-top: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
            background-color: #e9f7fe;
            color: #333;
            font-size: 1.2em;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="quiz-container">
            <h2>Đề Trắc Nghiệm</h2>
        <div class="button-container">
        <input type="hidden" name="startTime" id="startTimeField" value="">
           <a href="loadqueston2.php?IdExam=<?php echo $idexam; ?>"><button class="btn" id="startBtn">Bắt đầu làm bài</button></a> 
            <div id="totalQuestions" class="total-questions">Tổng số câu hỏi: <?php echo count($data); ?></div>
        </div>
</div>

</body>

</html>