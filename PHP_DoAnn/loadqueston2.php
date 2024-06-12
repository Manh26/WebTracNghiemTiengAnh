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
$userId = 1;

if ($idexam !== null) {
    $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD
            FROM questions
            WHERE IdExam = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idexam);
    $stm->execute();
    $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $alert = "không tìm thấy ID Bài !";
    echo "<script> alert('$alert');  </script>";
    echo "<script>window.location.href='trangchu.php';</script>";
}

$startTime = date("Y-m-d H:i:s");
$_SESSION['session'] = $startTime;

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
            margin-bottom: 20px;
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

        .answer-container label {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đề Trắc Nghiệm</h2>
        <form id="quizForm" action="submitanswer.php?IdExam=<?php echo $idexam; ?>" method="post">
            <input type="hidden" name="IdExam" value="<?php echo $idexam; ?>">
            <?php
            $question_number = 1;
            foreach ($data as $item) {
            ?>
                <input type="hidden" name="id[]" value="<?php echo $item['IdQuestion']; ?>">
                <div class="question">
                    <p><?php echo 'Câu ' . $question_number . ': ' . $item['Question']; ?></p>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerA']; ?>"> <?php echo $item['AnswerA']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerB']; ?>"> <?php echo $item['AnswerB']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerC']; ?>"> <?php echo $item['AnswerC']; ?></label>
                    <label><input type="radio" name="answer<?php echo $item['IdQuestion']; ?>" value="<?php echo $item['AnswerD']; ?>"> <?php echo $item['AnswerD']; ?></label>
                </div>
            <?php
                $question_number++;
            }
            ?>
            <div class="btn-container">
    <form action="submitanswer" method="post">
        <input type="submit" class="btn" value="Nộp Bài">
    </form>
    <a href="trangchu.php" class="btn btn-back">Quay lại</a>
</div>

        </form>
        
        <div class="answer-container">
            <h2>Đáp án đã chọn</h2>
            <table id="selectedAnswers">
                <thead>
                    <tr>
                        <th>Câu hỏi</th>
                        <th>Đáp án đã chọn</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="answer-container">
            <h2>Câu chưa trả lời</h2>
            <table id="unansweredQuestions">
                <thead>
                    <tr>
                        <th>Câu hỏi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="btn-container">
                <button class="btn" onclick="showUnansweredQuestions()">Hiển thị câu chưa trả lời</button>
            </div>
        </div>
    </div>

    <script>
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        const selectedAnswersTable = document.getElementById('selectedAnswers');
        const unansweredQuestionsTable = document.getElementById('unansweredQuestions');

        radioButtons.forEach(radioButton => {
            radioButton.addEventListener('click', function() {
                const questionNumber = this.closest('.question').querySelector('p').textContent.split(':')[0].trim();
                const answer = this.value;

                let tableRow = selectedAnswersTable.querySelector(`tr[data-question="${questionNumber}"]`);
                if (!tableRow) {
                    tableRow = document.createElement('tr');
                    tableRow.setAttribute('data-question', questionNumber);
                    selectedAnswersTable.querySelector('tbody').appendChild(tableRow);
                }

                tableRow.innerHTML = `
                    <td>${questionNumber}</td>
                    <td>${answer}</td>
                `;

                const rows = Array.from(selectedAnswersTable.querySelectorAll('tbody tr'));

                rows.sort((a, b) => {
                    const aQuestionNumber = parseInt(a.getAttribute('data-question'));
                    const bQuestionNumber = parseInt(b.getAttribute('data-question'));
                    return aQuestionNumber - bQuestionNumber;
                });
                selectedAnswersTable.querySelector('tbody').innerHTML = '';
                rows.forEach(row => {
                    selectedAnswersTable.querySelector('tbody').appendChild(row);
                });
            });
        });

        function showUnansweredQuestions() {
            const questions = document.querySelectorAll('.question');
            const unansweredQuestions = [];

            questions.forEach(question => {
                const inputs = question.querySelectorAll('input[type="radio"]');
                let answered = false;
                inputs.forEach(input => {
                    if (input.checked) {
                        answered = true;
                    }
                });
                if (!answered) {
                    const questionText = question.querySelector('p').textContent;
                    unansweredQuestions.push(questionText);
                }
            });

            updateTable(unansweredQuestions);
        }

        function updateTable(questions) {
            const tableBody = unansweredQuestionsTable.querySelector('tbody');
            tableBody.innerHTML = '';

            questions.forEach(question => {
                const tableRow = document.createElement('tr');
                tableRow.innerHTML = `
                    <td>${question}</td>
                `;
                tableBody.appendChild(tableRow);
            });
        }
    </script>
</body>

</html>
