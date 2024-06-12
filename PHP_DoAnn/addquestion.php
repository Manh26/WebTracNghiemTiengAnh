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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameQuestion = $_POST['nameQuestion'];
            $answerA = $_POST['answerA'];
            $answerB = $_POST['answerB'];
            $answerC = $_POST['answerC'];
            $answerD = $_POST['answerD'];
            $correctanswer=$_POST['CorrectAnswer'];
            $sqlInsert = "INSERT INTO questions (Question, AnswerA, AnswerB, AnswerC, AnswerD,CorrectAnswer) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("ssssss", $nameQuestion, $answerA, $answerB, $answerC, $answerD,$correctanswer);

            if ($stmt->execute()) {
             
                header("Location: themquestionadmin.php?status=success");
                exit();
            } else {
          
                $error_message = "Thao tác thất bại. Vui lòng thử lại.";
            }
            $stmt->close();
        }

//         $sql = "SELECT IdQuestion, Question, AnswerA, AnswerB, AnswerC, AnswerD FROM questions";
//         $result = $conn->query($sql);
//        
//         if ($result->num_rows > 0) {
//             $data = [];
//             while ($row = $result->fetch_assoc()) {
//                 $data[] = $row;
//             }

//             echo '<form action="submitanswer.php" method="post">';
//             $question_number = 1;
//             foreach ($data as $item) {
//                 echo '<input type="hidden" name="id[]" value="' . $item['IdQuestion'] . '">';
//                 echo '<div class="question">';
//                 echo '<p>' . 'Câu ' . $question_number . ': ' . $item['Question'] . '</p>';
//                 echo '<label><input type="radio" name="answer' . $item['IdQuestion'] . '" value="' . $item['AnswerA'] . '"> ' . $item['AnswerA'] . '</label>';
//                 echo '<label><input type="radio" name="answer' . $item['IdQuestion'] . '" value="' . $item['AnswerB'] . '"> ' . $item['AnswerB'] . '</label>';
//                 echo '<label><input type="radio" name="answer' . $item['IdQuestion'] . '" value="' . $item['AnswerC'] . '"> ' . $item['AnswerC'] . '</label>';
//                 echo '<label><input type="radio" name="answer' . $item['IdQuestion'] . '" value="' . $item['AnswerD'] . '"> ' . $item['AnswerD'] . '</label>';
//                 echo '</div>';
//                 $question_number++;
//             }
//             echo '<div class="btn-container">';
//             echo '<input type="submit" class="btn" value="Nộp Bài">';
//             echo '<a href="index.php" class="btn btn-back">Quay lại</a>';
//             echo '</div>';
//             echo '</form>';
//         } else {
//             echo "<p>Không có kết quả nào</p>";
//         }

