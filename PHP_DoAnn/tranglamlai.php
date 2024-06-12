<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web1_mysql";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy IdExam từ tham số URL
$idexam = isset($_GET['IdExam']) ? $_GET['IdExam'] : null;

// Kiểm tra nếu có IdExam được truyền từ URL
if ($idexam !== null) {
    // Thực hiện truy vấn câu hỏi từ cơ sở dữ liệu với IdExam tương ứng
    $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD
            FROM questions
            WHERE IdExam = ?";
    $stm = $conn->prepare($sql);
    $stm->bind_param('i', $idexam);
    $stm->execute();
    $data = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    // Nếu không có IdExam, thông báo và chuyển hướng trở lại trang chủ
    $alert = "Không tìm thấy ID Bài!";
    echo "<script> alert('$alert');  </script>";
    echo "<script>window.location.href='trangchu.php';</script>";
}

// Đóng kết nối đến cơ sở dữ liệu
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 900px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
            display: flex;
        }

        .quiz-container {
            flex: 70%; 
            padding-right: 20px; 
        }

        .answer-container {
            flex: 30%; 
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

        <form id="" action="submitanswer.php?IdExam=<?php echo $idexam; ?>" method="post">
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
<div class="answer-container">
        <table id="selectedAnswers">
            <thead>
                <tr>
                    <th>Đáp Án Mà Bạn Đã Chọn</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
            <div class="btn-container">
                <input type="submit" class="btn" value="Nộp Bài">
                <a href="trangchu.php" class="btn btn-back">Quay lại</a>
            </div>
        </form>
        
    </div>


</div>
<!-- <script>
    // Hàm để chèn số 0 vào trước các số có một chữ số
    function padZero(num) {
        return (num < 10 ? '0' : '') + num;
    }

    // Hàm để cập nhật thời gian
    function updateTimer() {
        const now = new Date();
        const hours = padZero(now.getHours());
        const minutes = padZero(now.getMinutes());
        const seconds = padZero(now.getSeconds());
        document.getElementById('startTimeField').textContent = hours + ':' + minutes + ':' + seconds;
    }

    // Gọi hàm updateTimer mỗi giây
    setInterval(updateTimer, 1000);
</script> -->
<!-- <script>
        // Function để chèn số 0 vào trước các số có một chữ số
        function padZero(num) {
            return (num < 10 ? '0' : '') + num;
        }

        // Function để cập nhật thời gian và hiển thị nó
        function updateTimer() {
            const timerElement = document.getElementById('startTimeField');
            const now = new Date();
            const testTimeParts = "echo $testTime; ".split(':'); // Chia TestTime thành mảng [giờ, phút, giây]
            const testHour = parseInt(testTimeParts[0]);
            const testMinute = parseInt(testTimeParts[1]);
            const testSecond = parseInt(testTimeParts[2]);
            const endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), testHour, testMinute, testSecond);
            const diff = Math.floor((endTime - now) / 1000); // Tính số giây còn lại
            const hours = padZero(Math.floor(diff / 3600));
            const minutes = padZero(Math.floor((diff % 3600) / 60));
            const seconds = padZero(diff % 60);
            timerElement.textContent = hours + ':' + minutes + ':' + seconds;
        }

        // Gọi hàm updateTimer mỗi giây
        setInterval(updateTimer, 1000);

        // Bắt đầu tính thời gian khi trang được tải
        window.onload = function() {
            updateTimer();
        };
    </script> -->

<script>
function validateForm() {
    const questions = document.querySelectorAll('.question');
    for (let i = 0; i < questions.length; i++) {
        const question = questions[i];
        const inputs = question.querySelectorAll('input[type="radio"]');
        let answered = false;
        for (let j = 0; j < inputs.length; j++) {
            if (inputs[j].checked) {
                answered = true;
                break;
            }
        }
        if (!answered) {
            alert('Chưa làm bài xong! Vui lòng trả lời tất cả các câu hỏi.');
            return false;
        }
    }
    return true;
}
</script>
</div>


<script>
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    const selectedAnswersTable = document.getElementById('selectedAnswers');

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
        });
    });
</script>

</body>

</html>