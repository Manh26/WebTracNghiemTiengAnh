<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử làm bài thi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
        .back-btn a {
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .back-btn a:hover {
            background-color: #0056b3;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            padding: 8px 16px;
            margin: 0 2px;
            border-radius: 5px;
        }
        .pagination a:hover {
            background-color: #0056b3;
        }
        .pagination .active {
            background-color: #0056b3;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lịch sử làm bài thi</h1>
      
        <table id="historyTable">
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Exam ID</th>
                <th>Ngày Thi</th>
                <th>Thời Gian Bắt Đầu</th>
                <th>Thời Gian Kết Thúc</th>
                <th>Điểm Số</th>
                <th>Câu Trả Lời Đúng</th>
            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "web1_mysql";
            $records_per_page = 10;

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->query('SET NAMES utf8');

                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($page < 1) $page = 1;

                $start_from = ($page - 1) * $records_per_page;

                $sql = "SELECT * FROM userexamhistory LIMIT :start_from, :records_per_page";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
                $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["UserExamHistoryID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["UserID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["IdExam"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["TestDate"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["StartTime"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["EndTime"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Point"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["CorrectAnswers"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Không có dữ liệu</td></tr>";
                }

                $sql = "SELECT COUNT(*) FROM userexamhistory";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $total_records = $stmt->fetchColumn();
                $total_pages = ceil($total_records / $records_per_page);
            } catch(PDOException $e) {
                echo "Kết nối thất bại: " . $e->getMessage();
            }
            $conn = null;
            ?>
        </table>

        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='lichsulambai.php?page=" . $i . "'";
                if ($i == $page) echo " class='active'";
                echo ">" . $i . "</a>";
            }
            ?>
        </div>

        <div class="back-btn">
            <a href="trangchu.php">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
